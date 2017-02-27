<?php

namespace HearthStone\commands;


class NoticeLoginCommand extends BaseCommand
{
    protected $code = STATUS_PLS_LOGIN;
    protected $msg = '请先登录';
}