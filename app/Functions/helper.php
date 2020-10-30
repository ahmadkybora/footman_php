<?php

use Philo\Blade\Blade;
use App\Providers\Session;
use voku\helper\Paginator;
use Illuminate\Database\Capsule\Manager as Capsule;
use Carbon\Carbon;
use App\Models\User;

/**
 * this method for make view in directory resources
 * @param $path
 * @param array $data
 */
function view($path, array $data = [])
{
    $view = __DIR__ . '/../../resources/views';
    $catch = __DIR__ . '/../../bootstrap/cache';

    $blade = new Blade($view, $catch);
    echo $blade->view()->make($path, $data)->render();
}

function make($fileName, $data)
{
    extract($data);

    /**
     * this down statement turn on output buffering
     */
    ob_start();

    /**
     * this down statement for include page or template
     */
    include_once __DIR__ . '/../../resources/views/mails' . $fileName . 'blade.php';

    /**
     * this down statement for get content of the file
     */
    $content = ob_get_contents();

    /**
     * this down statement erase the output and turn off output buffering
     */
    ob_end_clean();

    return $content;
}

if(! function_exists('dd')) {
    function dd(...$vars)
    {
        foreach ($vars as $v) {
            var_dump($v);
        }

        exit(1);
    }
}
/**
 * this method for public path
 *
 * @param $value
 * @return mixed
 */
if(! function_exists('public_path')) {
    function public_path($value)
    {
        echo require_once __DIR__ . '/../../public/' . $value;
    }
}
/**
 * this method for base path
 *
 * @param $value
 * @return mixed
 */
if(! function_exists('base_path')) {
    function base_path($value)
    {
        return require_once __DIR__ . '/../../' . $value;
    }
}
/**
 * this method for storage path
 *
 * @param $value
 * @return mixed
 */
if(! function_exists('storage_path')) {
    function storage_path($value)
    {
        return require_once __DIR__ . '/../../storage' . $value;
    }
}
/**
 * Generate Token
 *
 * @return mixed
 * @throws Exception
 */
if(! function_exists('csrf_token')) {
    function csrf_token()
    {
        if (!Session::has('token')) {
            $random_token = base64_encode(openssl_random_pseudo_bytes(32));
            Session::add('token', $random_token);
        }

        return Session::get('token');
    }
}

/**
 * verify CSRF Token
 *
 * @param $requestToken
 * @return bool
 * @throws \Exception
 */

if(! function_exists('verifyCSRFToken')) {
    function verifyCSRFToken($requestToken)
    {
        if (Session::has('token') and Session::get('token') === $requestToken) {
            Session::remove('token');
            return true;
        }

        return false;
    }
}

/**
 * redirect to specific page
 *
 * @param $page
 */
if(! function_exists('redirectTo')) {
    function redirectTo($page)
    {
        header("location: $page");
        exit;
    }
}

/**
 * redirect to same page
 */
if(! function_exists('back')) {
    function back()
    {
        $uri = $_SERVER['REQUEST_URI'];
        header("location: $uri");
    }
}

/**
 * this method for echo message
 * @param $value
 */
function withMessage($value)
{
    echo $value;
}

/**
 * this method for slug
 *
 * @param $value
 * @return string
 */
if(! function_exists('slug')) {
    function slug($value)
    {
        // remove all character not in this list: underscore | letters | numbers | whitespace
        $value = preg_replace('![^' . preg_quote('_') . '\pL\pN\s]+!u', '', mb_strtolower($value));

        // replace underscore with a dash -
        $value = preg_replace('![' . preg_quote('-') . '\s]+!u', '', $value);

        // remove whitespace
        return trim($value, '-');
    }
}

if(! function_exists('paginate')) {
    function paginate($num_of_records, $total_record, $table_name, $object)
    {
        $categories = [];
        $pages = new Paginator($num_of_records, 'p');
        $pages->set_total($total_record);

        $data = Capsule::select("SELECT * FROM {$table_name} ORDER BY created_at DESC" . $pages->get_limit());
        foreach ($data as $item) {
            $c = new Carbon($item->created_at);
            array_push($categories, [
                'id' => $item->id,
                'name' => $item->name,
                'slug' => $item->slug,
                'created_at' => $c->toFormattedDateString(),
                'updated_at' => $item->updated_at,
                'deleted_at' => $item->deleted_at,
            ]);
        }

        return [$categories, $pages->page_links()];
    }
}

if(! function_exists('session')) {
    function session($name, $value)
    {
        if ($name != '' and !empty($name) and $value != '' and !empty($value)) {
            return $_SESSION[$name] = $value;
        }

        throw new \Exception('Name and Value is required');
    }
}

if (! function_exists('response')) {
    /**
     * Return a new response from the application.
     *
     * @param  \Illuminate\View\View|string|array|null  $content
     * @param  int  $status
     * @param  array  $headers
     * @return \Illuminate\Http\Response|\Illuminate\Contracts\Routing\ResponseFactory
     */
    function response($content = '', $status = 200, array $headers = [])
    {
        $factory = app(ResponseFactory::class);

        if (func_num_args() === 0) {
            return $factory;
        }

        return $factory->make($content, $status, $headers);
    }
}

/**
 *
 */
if(! function_exists('isAuthenticated'))
{
    function isAuthenticated ()
    {
        return Session::has('SESSION_USER_ID') ? true : false;
    }
}

/**
 *
 */
if(! function_exists('user'))
{
    function user ()
    {
        if(isAuthenticated())
        {
            return User::findOrFail(Session::get('SESSION_USER_ID'));
        }

        return false;
    }
}

/**
 *
 */
if(! function_exists('convertMoneyToCents'))
{
    function convertMoneyToCents($value)
    {
        $value = preg_replace("/\,/i", "", $value);
        $value = preg_replace("/([^0-9\.\-])/i", "", $value);

        if(!is_numeric($value))
        {
            return 0.00;
        }

        $value = (float) $value;
        return round($value, 2) * 100;
    }
}
/**
 *
 */
if(! function_exists('json')) {
    function json($data = [], $status = 200, array $headers = [], $options = 0)
    {
    }
}