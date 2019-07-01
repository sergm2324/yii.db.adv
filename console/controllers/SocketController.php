<?php


namespace console\controllers;


use console\components\SocketServer;
use yii\console\Controller;
use Ratchet\Http\HttpServer;
use Ratchet\Server\IoServer;
use Ratchet\WebSocket\WsServer;

class SocketController extends Controller
{
    public function actionStartSocket($port=6380)
    {
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new SocketServer()
                )
            ), $port

        );
        $server->run();
    }



}