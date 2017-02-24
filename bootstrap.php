<?php
use HearthStone\services\ContainerBuilder;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

require_once 'vendor/autoload.php';
define('ROOT_PATH', __DIR__);
define('DS', '/');

$container = ContainerBuilder::getInstance();

$container['config'] = function($c){
    if( MODE == 'prod' || MODE == 'test' ){
        return require_once 'config/' . MODE . '/config.php';
    }
    return require_once 'config/config.php';
};

$container['log'] = function($c){
    $log = new Logger('log');
    $log->pushHandler(new StreamHandler(fopen('php://output', 'w'), Logger::INFO));
    return $log;
};

$container['redis'] = function($c){
    return new \Predis\Client($c['config']['redis']);
};