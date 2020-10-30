<?php

namespace App\Traits;


use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Payment;
use App\Models\Product;
use App\Providers\Mail;
use App\Providers\Session;

trait PayableTrait
{
    public function logPaymentAndMailClient($vendor, $data)
    {
        $result['product'] = [];
        $result['order_number'] = [];
        $result['total'] = [];

        $vendor == 'paypal' ? $order_id = $data['transactions'][0]['custom'] : $order_id = uniqid();
        $vendor == 'paypal' ? convertMoneyToCents($data['transactions'][0]['amount']['total']) : $amount = $data->amount;
        $vendor == 'paypal' ? $status = $data['status'] : $status = $data->status;

        foreach($_SESSION['user_cart'] as $cart_items)
        {
            $productId = $cart_items['product_id'];
            $quantity = $cart_items['quantity'];
            $item = Product::where('id', $productId)->first();

            if(!$item)
                continue;

            $total_price = $item->price * $quantity;
            $total_price = number_format($total_price, 2);

            $order = new OrderDetail();
            $order->user_id = user()->id;
            $order->product_id = $productId;
            $order->unit_price = $item->price;
            $order->status = 'Pending';
            $order->quantity = $quantity;
            $order->total = $total_price;
            $order->order_no = $order_id;
            $order->save();

            $item->quantity = $item->quantity - $quantity;
            $item->save();

            array_push($result['product'], [
                'name' => $item->name,
                'price' => $item->price,
                'total' => $total_price,
                'quantity' => $quantity,
            ]);
        }

        $payment = new Payment();
        $payment->user_id = user()->id;
        $payment->amount = $amount;
        $payment->status = $status;
        $payment->oarder_no = $order_id;
        $payment->save();

        $result['order_no'] = $order_id;
        $result['total'] = Session::get('cartTotal');

        $data = [
            'to' => user()->email,
            'subject' => 'Order Confirmation',
            'view' => 'purchase',
            'name' => user()->first_name . ' ' . user()->last_name,
            'body' => $result,
        ];

        (new Mail())->send($data);
    }
}