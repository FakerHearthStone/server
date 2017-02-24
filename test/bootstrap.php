<?php

define('DS', '/');
define('ROOT_PATH', str_replace('\test', '', __DIR__));
define('CONFIG_PATH', ROOT_PATH . DS . 'config');
require_once ROOT_PATH . DS . 'vendor/autoload.php';

use HearthStone\services\ContainerBuilder;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

define('MODE', 'dev');

$container = ContainerBuilder::getInstance();

/***********************config******************************/
if( MODE == 'prod' || MODE == 'test' ){
    $configArr = require_once CONFIG_PATH . DS . MODE . '/config.php';
}else{
    $configArr = require_once CONFIG_PATH . DS . 'config/config.php';
}

$container['config'] = $configArr;

/***********************log******************************/
$log = new Logger('log');
$log->pushHandler(new StreamHandler(ROOT_PATH . DS . 'data' . DS . 'log' . DS . date('Y-m-d') . '.log', Logger::INFO));

$container['log'] = $log;