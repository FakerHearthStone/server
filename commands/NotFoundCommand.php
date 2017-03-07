<?php

namespace HearthStone\commands;


class NotFoundCommand extends BaseCommand
{
    protected $code = STATUS_NOT_FOUND_CMD;
    protected $msg = '';

    public function handler($server, $frame)
    {
        $receivedData = json_decode($frame->data);
        $this->msg = '没有找到' . (isset($receivedData->cmd) ? ucfirst($receivedData->cmd) : '') . 'Command';
        return $this;
    }
}