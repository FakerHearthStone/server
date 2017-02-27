<?php

namespace HearthStone\services\server;

use HearthStone\services\ContainerBuilder;


class TcpServer extends \Swoole\Server
{
    use ServerTrait;

    private $debugMode = false;

    private $container;

    /**
     * @var \Psr\Log\LoggerInterface
     */
    private $logger;

    public function __construct($host, $port)
    {
        $this->container = ContainerBuilder::getInstance();

        $this->logger = $this->container['log'];


        parent::__construct($host, $port);
    }

    public function init()
    {
        $this->set(array(
            'worker_num' => 8,
            'daemonize' => true,
        ));

        $this->on('connect', function ($serv, $fd){
            $this->debugMode && $this->logger->info('连接成功...');
        });

        $this->on('receive', function ($serv, $fd, $from_id, $data) {
            $serv->send($fd, $this->getPushData($data));
            $serv->close($fd);
        });
        $this->on('close', function ($serv, $fd) {
            $this->debugMode && $this->logger->info('连接关闭...');
        });

        return $this;
    }
}