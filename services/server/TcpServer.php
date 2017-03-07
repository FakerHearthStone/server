<?php

namespace HearthStone\services\server;

use HearthStone\services\ContainerBuilder;
use HearthStone\services\AccessControl;


class TcpServer extends \Swoole\Server
{

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

        $this->on('receive', function (\Swoole\Server $serv, $fd, $from_id, $data) {
            $serv->send($fd, $this->getSendData($serv, $fd, $from_id, $data));
            $serv->close($fd);
        });
        $this->on('close', function ($serv, $fd) {
            $this->debugMode && $this->logger->info('连接关闭...');
        });

        return $this;
    }

    /**
     * 获取返回给客户端的字符串
     *
     * @param $receiveStr string
     * @return $pushData
     */
    private function getSendData(\Swoole\Server $serv, $fd, $from_id, $data)
    {
        $receivedData = json_decode($data);

        $this->debugMode && $this->logger->info('接收到数据 ' . $data);

        if( ! isset($receivedData->cmd) ){
            $pushData = new \HearthStone\commands\InvalidCommand();
        }else{
            if( AccessControl::checkLogin($receivedData) ){
                //TODO: TcpServer 暂时无法使用下面的代码
                $pushData = \HearthStone\commands\CommandFactory::create($receivedData->cmd)->handler($serv, $data);
            }else{
                $pushData = new \HearthStone\commands\NoticeLoginCommand();
            }
        }

        $this->debugMode && $this->logger->info('发送的数据 ' . $pushData);

        return $pushData;
    }
}