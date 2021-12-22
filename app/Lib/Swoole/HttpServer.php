<?php

namespace App\Lib\Swoole;

use Illuminate\Events\Dispatcher;
use Illuminate\Routing\Route;

class HttpServer {


    public function __construct()
    {
        $this->init();
    }

    public function init(){


        $http = new \Swoole\Http\Server('172.17.0.4', 9501);

        $http->set([
            'worker_num'      => 8,
            'reactor_num' => 5
//    'task_object' => true, // v4.6.0版本增加的别名
        ]);
        $http->on('start', function ($server) {
            echo "Swoole http server is started at http://172.17.0.4:9501\n";
        });

        $http->on('request', function ($request, $response) {
            $router = new Router($request);
            $router->dispatch();
            $result = $router->execute();

//            $request ="<pre>".json_encode($request);
//            $response->header('Content-Type', 'text/plain');
            $response->end($result);
        });

        $http->start();

    }
}

