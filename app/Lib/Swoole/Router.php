<?php

namespace App\Lib\Swoole;


class Router{

    public $request;
    public $controller;
    public $action;
    public function __construct($request)
    {
        $this->request = $request;
    }

    public function dispatch(){
        $server = $this->request->server;
        $request_uri = trim($server['request_uri'],'/');
        print_r($request_uri);
        if($request_uri == 'index'){
            $this->controller = 'App\Http\Controllers\Swoole\IndexController';
            $this->action = 'index';
        }
    }

    public function execute(){
        return call_user_func_array([new $this->controller(),$this->action],[$this->request]);
    }

}