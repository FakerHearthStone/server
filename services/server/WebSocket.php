<?php
namespace HearthStone\services\server;

use HearthStone\services\ContainerBuilder;
use HearthStone\services\AccessControl;


class WebSocket extends \Swoole\Websocket\Server
{
    
    private $debugMode = false;

    private $container;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    private $config;
    
    public function __construct($host, $port)
    {
        $this->container = ContainerBuilder::getInstance();

        $this->logger = $this->container['log'];
        $this->config = $this->container['config'];
        $this->debugMode = $this->config['common']['debug'];
        
        parent::__construct($host, $port);
    }

    public function init()
    {
        $this->on('Open', function(\swoole_websocket_server $server, $req) {
            $this->debugMode && $this->logger->info('连接成功...');
            $server->push($req->fd, new \HearthStone\commands\ConnectionSuccessCommand());
        });

        $this->on('Message', function(\swoole_websocket_server $server, \swoole_websocket_frame $frame) {
            $server->push($frame->fd, $this->getPushData($server, $frame));
        });

        $this->on('Close', function($server, $fd) {
            $this->debugMode && $this->logger->info('连接关闭...');
        });
        
        return $this;
    }
    
    private function getPushData(\swoole_websocket_server $server, \swoole_websocket_frame $frame)
    {
        $receivedData = json_decode($frame->data);

        $this->debugMode && $this->logger->info('接收到数据 ' . $frame->data);

        if( ! isset($receivedData->cmd) ){
            $pushData = new \HearthStone\commands\InvalidCommand();
        }else{
            if( AccessControl::checkLogin($receivedData) ){
                $pushData = \HearthStone\commands\CommandFactory::create($receivedData->cmd)->handler($receivedData);
            }else{
                $pushData = new \HearthStone\commands\NoticeLoginCommand();
            }
        }

        $this->debugMode && $this->logger->info('发送的数据 ' . $pushData);

        return $pushData;
    }
}