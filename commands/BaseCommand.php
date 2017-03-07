<?php

namespace HearthStone\commands;

use HearthStone\services\ContainerBuilder;

const STORE_CLOSED = 'STORE_CLOSED';
const STORE_OPENED = 'STORE_OPENED';

const ROOM_IS_FULL = 'ROOM_IS_FULL';
const ROOM_HAVE_FREE = 'ROOM_HAVE_FREE';

const STATUS_SUCCESS       = 0;
const STATUS_INVALID_CMD   = 1;
const STATUS_NOT_FOUND_CMD = 2;
const STATUS_NOT_FOUND_USER = 10000;
const STATUS_PLS_LOGIN = 10001;

abstract class BaseCommand
{
    
    protected $code = STATUS_SUCCESS;
    protected $cmd;
    protected $type = 'sys';
    protected $msg = '';
    protected $data = [];
    
    protected $container;
    /**
     * @var \ArrayObject
     */
    protected $clients;
    
    public function __construct()
    {
        $this->container = ContainerBuilder::getInstance();
        $this->clients = $this->container['clients'];
    }

    /**
     * @param $server 
     * @param $frame
     */
    protected function handler($server, $frame)
    {
        
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return json_encode(
            [
                'code' => $this->code,
                'cmd' => array_slice(explode('\\', get_class($this)), -1, 1)[0],
                'type' => $this->type,
                'msg' => $this->msg,
                'data' => $this->data,
            ]
        );
    }
}