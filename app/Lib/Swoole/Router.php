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
//        print_r($request_uri);
        if($request_uri == 'index'){
            $this->controller = 'Swoole\IndexController';
            $this->action = 'index';
        }elseif($request_uri == 'chat'){

            $this->controller = 'Swoole\MsgController';
            $this->action = 'chat';
        }
    }

    public function execute(){
        $controller = 'App\Http\Controllers\\'.$this->controller;

        return call_user_func_array([new $controller(),$this->action],[$this->request]);
    }

}