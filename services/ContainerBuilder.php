<?php

namespace HearthStone\services;

use Pimple\Container;

class ContainerBuilder
{
    private static $container;
    
    private function __construct()
    {
        
    }
    
    public static function getInstance()
    {
        if( self::$container == null ){
            self::$container = new Container();
        }
        
        return self::$container;
    }
}