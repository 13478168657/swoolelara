<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Lib\Swoole\WebSocketServer;
class WebSocket extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'websocket {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'socket链接';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $action = $this->argument('action');

        switch($action)
        {
            case 'start':
                $server = new WebSocketServer();
                break;
            case 'stop':
                $server = new WebSocketServer();
                break;
            default:
                break;
        }
        $server->init();
    }
}
