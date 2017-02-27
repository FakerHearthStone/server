<?php

namespace HearthStone\services;

use Swoole;
use HearthStone;
use HearthStone\commands;
use HearthStone\services\server\WebSocket;
use HearthStone\services\server\TcpServer;

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
                return (new WebSocket($this->currServerConfig['host'], $this->currServerConfig['port']))->init();
            default :
                return (new TcpServer($this->currServerConfig['host'], $this->currServerConfig['port']))->init();
        }
    }
}