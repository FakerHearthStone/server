<?php

namespace HearthStone\commands;


class InvalidCommand extends BaseCommand
{
    protected $code = STATUS_INVALID_CMD;
    protected $msg = '无效的Command';
}