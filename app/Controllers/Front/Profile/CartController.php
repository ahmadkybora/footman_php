<?php

namespace App\Controllers\Front\Profile;


use App\Controllers\Controller;
use App\Controllers\Panel\Category\ProductCategoryController;
use App\Layer\Cart;
use App\Layer\Middleware;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Providers\CSRFToken;
use App\Providers\Mail;
use App\Providers\Redirect;
use App\Providers\Request;
use App\Providers\Session;
use App\Traits\PayableTrait;
use GuzzleHttp\Client;
use Stripe\Charge;
use Stripe\Customer;

class CartController extends Controller
{
    use PayableTrait;

    protected $paypal_base_url;

    public function __construct()
    {
        if(getenv('APP_ENV') !== 'production')
        {
            $this->paypal_base_url = '';
        }
        else
        {
            $this->paypal_base_url = '';
        }
    }

    public function addToCart()
    {
        if(Request::has('POST') and $request = Request::get('POST'))
        {
            if(CSRFToken::verifyCSRFToken($request->token, false))
            {
                if(!$request->product_id)
                {
                    throw new \Exception('Malicious Activity');
                }

                Cart::add($request);
                echo json_encode(['success' => 'Product Add to Cart Successfully']);
                exit;
            }
        }
    }

    public function show()
    {
        return view('cart');
    }

    public function getCart()
    {
        try{
            $result = array();
            $cartTotal = 0;
            if(!Session::has('user_cart') || count(Session::get('user_cart')) < 1)
            {
                echo json_encode(['fail' => 'No item in the cart']);
                exit;
            }
            $index = 0;
            foreach($_SESSION['user_cart'] as $cart_items)
            {
                $productId = $cart_items['product_id'];
                $quantity = $cart_items['quantity'];
                $item = Product::where('id', $productId)->first();

                if(!$item)
                    continue;

                $total_price = $item->price * $quantity;
                $cartTotal = $total_price + $cartTotal;
                $total_price = number_format($total_price, 2);
                array_push($result, [
                    'id' => $item->id,
                    'name' => $item->name,
                    'image' => $item->image_path,
                    'description' => $item->description,
                    'price' => $item->price,
                    'total' => $total_price,
                    'quantity' => $quantity,
                    'stock' => $item->quantity,
                    'index' => $index
                ]);
                $index++;
            }

            $cartTotal = number_format($cartTotal, 2);
            Session::add('cartTotal', $cartTotal);

            echo json_encode([
                'items' => $result,
                'cartTotal' => $cartTotal,
                'authenticated' => isAuthenticated(),
                'amountInCents' => convertMoneyToCents($cartTotal),
            ]);
            exit;

        }catch (\Exception $e)
        {

        }
    }

    public function updateQuantity()
    {
        if(Request::has('POST') and $request = Request::get('POST'))
        {
            if(CSRFToken::verifyCSRFToken($request->token, false))
            {
                if(!$request->product_id)
                {
                    throw new \Exception('Malicious Activity');
                }
                $index = 0;
                $quantity = "";
                foreach ($_SESSION['user_cart'] as $cart_items)
                {
                    $index++;
                    foreach ($cart_items as $key => $value)
                    {
                        if($key == 'product_id' and $value ==$request->product_id)
                        {
                            switch ($request->operator)
                            {
                                case '+':
                                    $quantity = $cart_items['quantity'] + 1;
                                    break;
                                case '-':
                                    $quantity = $cart_items['quantity'] + 1;
                                    if($quantity < 1)
                                    {
                                        $quantity = 1;
                                    }
                                    break;
                            }
                            array_splice($_SESSION['user_cart'], $index - 1, 1, array(
                                [
                                    'product_id' => $request->product_id,
                                    'quantity' => $quantity
                                ]
                            ));
                        }
                    }
                }
            }
        }
    }

    public function removeFromCart()
    {
        if(Request::has('POST') and $request = Request::get('POST'))
        {
            if(CSRFToken::verifyCSRFToken($request->token, false))
            {
                if($request->item_index === '')
                {
                    throw new \Exception('Malicious Activity');
                }

                Cart::removeItem($request->item_index);
                echo json_encode(['success' => 'Product Add to Cart Successfully']);
                exit;
            }
        }
    }

    public function checkout()
    {
        $request = Request::get('post');
        $token = $request->stripToken;
        $email = $request->stripeEmail;
        try{
            $customer = Customer::create([
                'email' => $email,
                'token' => $token,
            ]);

            /*$id = user()->id;*/

            $amount = convertMoneyToCents(Session::get('cartTotal'));
            $charge = Charge::create([
                'customer' => $customer->id,
                'amount' => $amount,
                'description' => user()->first_name . '' . user()->last_name . '-cart purchase',
                'currency' => 'usd'
            ]);

            $this->logPaymentAndMailClient('stripe', $charge);

            echo json_encode(['customer' => 'thx']);
            exit;
        }
        catch (\Exception $e)
        {
            echo $e->getMessage();
        }
        Cart::clear();
        echo json_encode(['success' => 'thx']);
    }

    public function paypalCreatePayment()
    {
        $client = new Client;

        $accessTokenRequest = $client->post("{$this->paypal_base_url}/oauth2/token", [
            'headers' => [
                'Accept' => 'application/json'
            ],
            'auth' => [
                getenv('PAYPAL_CLIENT_ID'), getenv('PAYPAL_SECRET')],
            'form_params' => [
                'grant_type' => 'client_credentials'
            ]
        ]);

        $token = json_decode($accessTokenRequest->getBody());
        $bearer_token = $token->access_token;
        Session::add('paypal_access_token', $bearer_token);
        $app_base_url = getenv('APP_URL');
        $order_number = uniqid();
        $payload = [
            "intent" => "sale",
            "payer" => [
                "payment_method" => "paypal"
            ],
            "redirect_urls" => [
                "return_url" => "{$app_base_url}/cart",
                "cancel_url" => "{$app_base_url}/cart",
            ],
            "transaction" => [
                [
                    "amount" => [
                        "total" => Session::get('cartTotal'),
                        "currency" => "USD",
                        "details" => [
                            "subtotal" => Session::get('cartTotal'),
                        ]
                    ],
                    "description" => "Purchase form Footman",
                    "custom" => $order_number,
                    "payment_options" => [
                        "allowed_payment_method" => "INSTANT_FOUNDING_SOURCE"
                    ]
                ]
            ]
        ];

        $response = $client->post("{$this->paypal_base_url}/payments/payment", [
            "headers" => [
                'Content-type' => 'application/json',
                'Authorization' => 'Bearer ' . $bearer_token
            ],
            "body" =>json_encode($payload),
        ]);

        $response = json_decode($response->getBody());
        echo json_encode($response);
    }

    public function paypalExecutePayment()
    {
        $request = Request::get('post');

        $payer_id = $request->payerId;
        $payment_id = $request->paymentId;
        $payment_path = "payments/payment/{$payment_id}/execute";
        $access_token = Session::get('paypal_access_token');

        $paymentResponse = (new Client)->post($this->paypal_base_url . "/{$payment_path}", [
            "headers" => [
                'Content-type' => 'application/json',
                'Authorization' => 'Bearer ' . $access_token
            ],
            "body" =>json_encode(['payer_id' => $payer_id]),
        ]);

        $response = json_decode($paymentResponse->getBody(), true);

        try{
            $this->logPaymentAndMailClient('paypal', $response);
            Cart::clear();
            echo json_encode([
                'success' => 'ok'
            ]);
        }
        catch (\Exception $e)
        {
            echo $e->getMessage();
        }
    }

    public function emptyCart()
    {
        Cart::clear();
        echo json_encode(['success' => 'ok']);
        exit;
    }
}