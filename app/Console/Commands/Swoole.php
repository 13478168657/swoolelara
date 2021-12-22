<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Lib\Swoole\HttpServer;
class Swoole extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'http {action}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'qindong swoole';

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
                $server = new HttpServer();
                break;
            case 'reload':
                $server = new HttpServer();
                $server->reload();
                break;
            default:
                break;
        }
        $server->init();
    }
}
