<?php

namespace HearthStone\services\server;

use HearthStone\services\AccessControl;

trait ServerTrait
{
    /**
     * 获取返回给客户端的字符串
     *
     * @param $receiveStr string
     * @return $pushData
     */
    private function getPushData($receiveStr)
    {
        $receivedData = json_decode($receiveStr);

        $this->debugMode && $this->logger->info('接收到数据 ' . $receiveStr);

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