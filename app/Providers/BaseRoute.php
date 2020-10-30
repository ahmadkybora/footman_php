<?php
namespace App\Providers;

use AltoRouter;

class BaseRoute
{
    protected $uri;
    protected $controller;
    protected $method;

    public function __construct(AltoRouter $router)
    {
        $this->uri = $router->match();

        if($this->uri)
        {
            list($controller, $method) = explode('@', $this->uri['target']);
                $this->controller = $controller;
                $this->method = $method;

                if(is_callable(array(new $this->controller, $this->method)))
                {
                    call_user_func_array(array(new $this->controller, $this->method), array($this->uri['params']));
                }
                else
                {
                    echo "The Method {$this->method} is not defined in {$this->controller}";
                }
        }
        else
        {
            header($_SERVER['SERVER_PROTOCOL'] . '404 not found');
            view('errors/404');
        }
    }
}
