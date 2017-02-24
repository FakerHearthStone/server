<?php

namespace HearthStone\commands;


class NotFoundCommand extends BaseCommand
{
    protected $code = STATUS_NOT_FOUND_CMD;
    protected $msg = '';

    public function handler($params)
    {
        $this->msg = '没有找到' . (isset($params->cmd) ? ucfirst($params->cmd) : '') . 'Command';
        return $this;
    }
}