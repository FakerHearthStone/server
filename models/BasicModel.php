<?php

namespace HearthStone\models;


use HearthStone\services\ContainerBuilder;

class BasicModel
{
    protected $container;

    /**
     * @var \Predis\Client
     */
    protected $redis;

    public function __construct()
    {
        $this->container = ContainerBuilder::getInstance();
        
        $this->redis = $this->container['redis'];
    }

    /**
     * @return mixed
     */
    public static function model()
    {
        $className = get_called_class();
        return new $className();
    }
}