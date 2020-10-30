<?php
///**
// * Created by PhpStorm.
// * User: kybora
// * Date: 10/13/2020
// * Time: 9:05 PM
// */
//
//namespace App\Providers;
//
//
//class Response
//{
//namespace Foo\Http;
//
//class Response implements ResponseInterface
//{
//
//    private $statusCode = 'HTTP/1.1 200 OK';
//    private $headers = [];
//
//    public function addHeader($name, $value){
//        $this->headers[$name][] = $value;
//    }
//
//    public function setHeader($name, $value){
//        $this->headers[$name] = [
//            (string) $value,
//        ];
//    }
//
//    public function redirect($url){
//        $this->setHeader('Location', $url);
//    }
//
//}
//namespace Foo\Http;
//use Foo\Storage\ArrayHandler as access;
//class Request implements RequestInterface
//{
//
//    protected $get;
//    protected $post;
//    protected $files;
//    protected $server;
//    protected $cookies;
//
//
//    public function __construct(
//        access $get,
//        access $post,
//        access $files,
//        access $server,
//        access $cookies
//    ) {
//        $this->get = $get;
//        $this->post = $post;
//        $this->files = $files;
//        $this->server = $server;
//        $this->cookies = $cookies;
//    }
//
//
//    public function get($key, $defaultValue = null){
//        return $this->get->get($key, $defaultValue);
//    }
//
//    public function post($key, $defaultValue = null){
//        return $this->post->get($key, $defaultValue);
//    }
//
//    public function server($key, $defaultValue = null){
//        return $this->server->get($key, $defaultValue);
//    }
//
//    public function getMethod(){
//        return $this->server->get('REQUEST_METHOD');
//    }
//}
//namespace Foo\Http;
//interface ResponseInterface
//{
//    public function setStatusCode($statusCode);
//    public function addHeader($name, $value);
//    public function setContentType($contentType);
//    public function redirect($url);
//}
//namespace Foo\Http;
//interface RequestInterface
//{
//    public function get($key, $default = null);
//    public function post($key, $default = null);
//    public function server($key, $default = null);
//    public function getMethod();
//}
//}