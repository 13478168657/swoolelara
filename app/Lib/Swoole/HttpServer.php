<?php

namespace App\Lib\Swoole;

use Illuminate\Events\Dispatcher;
use Illuminate\Routing\Route;

class HttpServer {


    protected $server;
    public function __construct()
    {
        $this->init();
    }

    public function init(){

        $addr = env('LARAVELS_LISTEN_IP');
        \Swoole\Runtime::enableCoroutine($flags = SWOOLE_HOOK_ALL);
        $http = new \Swoole\Http\Server($addr, 9501);

        $http->set([
            'worker_num'      => 2,
//            'enable_coroutine' => false
//            'reactor_num' => 5,

//    'task_object' => true, // v4.6.0版本增加的别名
        ]);
        $http->on('start', function ($server) use ($addr) {
            echo "Swoole http server is started at $addr:9501\n";
        });

        $http->on('request', function ($request, $response) {
            $router = new Router($request);
            $router->dispatch();
            $result = $router->execute();

//            $request ="<pre>".json_encode($request);
//            $response->header('Content-Type', 'text/plain');
            $response->end($result);
        });
        $this->server = $http;
        $http->start();

    }

    public function reload(){

        $this->server->reload();
    }
}

