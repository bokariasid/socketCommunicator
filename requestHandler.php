<?php
namespace FinomenaTest;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
// use FinomenaTest\ServerInterface;
include_once 'ServerInterface.php';
    require 'vendor/autoload.php';

    $server = IoServer::factory(
        new HttpServer(
            new WsServer(
                new ServerInterface()
            )
        ),
        8089
    );


    $server->run();