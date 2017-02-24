<?php

namespace HearthStone\services;

use Swoole;
use HearthStone;
use HearthStone\commands;

class ServerFactory
{
    private $container;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    private $config;

    private $currServerConfig;

    private $serverType;

    public function create()
    {
        $this->container = ContainerBuilder::getInstance();

        $this->logger = $this->container['log'];
        $this->config = $this->container['config'];
        $this->serverType = $this->config['server']['server_type'];
        $this->currServerConfig = $this->config['server'][$this->serverType];

        switch ($this->serverType){
            case 'websocket':
                return $this->createWebSocketServer();
            default :
                return $this->createTckServer();
        }
    }

    private function createWebSocketServer()
    {
        $serv = new Swoole\Websocket\Server($this->currServerConfig['host'], $this->currServerConfig['port']);

        $serv->on('Open', function($server, $req) {
            $this->config['common']['debug'] && $this->logger->info('连接成功...');
            $server->push($req->fd, new HearthStone\commands\ConnectionSuccessCommand());
        });

        $serv->on('Message', function($server, $frame) {
            $receivedData = json_decode($frame->data);

            $this->config['common']['debug'] && $this->logger->info('接收到数据 ' . $frame->data);

            if( ! isset($receivedData->cmd) ){
                $pushData = new HearthStone\commands\InvalidCommand();
            }else{
                $pushData = HearthStone\commands\CommandFactory::create($receivedData->cmd)->handler($receivedData);
            }
            $server->push($frame->fd, $pushData);

            $this->config['common']['debug'] && $this->logger->info('发送的数据 ' . $pushData);
        });

        $serv->on('Close', function($server, $fd) {
            $this->config['common']['debug'] && $this->logger->info('连接关闭...');
        });

        return $serv;
    }

    private function createTckServer()
    {
        $serv = new Swoole\Server($this->currServerConfig['host'], $this->currServerConfig['port']);
        $serv->set(array(
            'worker_num' => 8,
            'daemonize' => true,
        ));

        $serv->on('connect', function ($serv, $fd){
            $this->config['common']['debug'] && $this->logger->info('连接成功...');
        });
        $serv->on('receive', function ($serv, $fd, $from_id, $data) {
            $receivedData = json_decode($data);

            $this->config['common']['debug'] && $this->logger->info('接收到数据 ' . $data);

            if( ! isset($receivedData->cmd) ){
                $pushData = new HearthStone\commands\InvalidCommand();
            }else{
                $pushData = HearthStone\commands\CommandFactory::create($receivedData->cmd)->handler($receivedData);
            }

            $this->config['common']['debug'] && $this->logger->info('发送的数据 ' . $pushData);

            $serv->send($fd, $pushData);
            $serv->close($fd);
        });
        $serv->on('close', function ($serv, $fd) {
            $this->config['common']['debug'] && $this->logger->info('连接关闭...');
        });

        return $serv;
    }
}