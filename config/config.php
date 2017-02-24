<?php

return [
    'common' => [
        'debug' => true,
    ],
    'redis' => [
        'host' => '192.168.10.10',
        'port' => 6379,
    ],
    'server' => [
        'server_type' => 'websocket',
        'websocket' => [
            'host' => '192.168.10.10',
            'port' => '9502',
        ],
        'tcpserver' => [
            'host' => '0.0.0.0',
            'port' => '9501',
        ],
    ]
];