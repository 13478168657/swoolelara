<?php

namespace App\Lib\Swoole;


class WebSocketServer {

    public function __construct()
    {
        $this->init();
    }

    public function init(){

        //创建WebSocket Server对象，监听0.0.0.0:9502端口
        $ws = new \Swoole\WebSocket\Server('0.0.0.0', 9502);

        $ws->on('Start', function($wx){

            echo "started\n";
        });
        //监听WebSocket连接打开事件
        $ws->on('Open', function ($ws, $request) {
            $ws->push($request->fd, "hello, welcome\n");
        });

        //监听WebSocket消息事件
        $ws->on('Message', function ($ws, $frame) {
            echo "Message: {$frame->data}\n";
            $ws->push($frame->fd, "server: {$frame->data}");
        });

        //监听WebSocket连接关闭事件
        $ws->on('Close', function ($ws, $fd) {
            echo "client-{$fd} is closed\n";
        });

        $ws->start();
    }

}