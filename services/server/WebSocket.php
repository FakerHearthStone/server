<?php
namespace HearthStone\services\server;

use HearthStone\services\ContainerBuilder;


class WebSocket extends \Swoole\Websocket\Server
{
    use ServerTrait;
    
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
        $this->on('Open', function($server, $req) {
            $this->debugMode && $this->logger->info('连接成功...');
            $server->push($req->fd, new \HearthStone\commands\ConnectionSuccessCommand());
        });

        $this->on('Message', function($server, $frame) {
            $server->push($frame->fd, $this->getPushData($frame->data));
        });

        $this->on('Close', function($server, $fd) {
            $this->debugMode && $this->logger->info('连接关闭...');
        });
        
        return $this;
    }
}