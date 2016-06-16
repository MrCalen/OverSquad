<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

class WebSocketServer extends Command
{
    protected $signature = 'ws:serve';

    protected $description = 'Launch WebSocket Server';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new \App\Ws\WebSocketServer()
                )
            ),
            '8090',
            '0.0.0.0'
        );
        $server->run();
    }
}
