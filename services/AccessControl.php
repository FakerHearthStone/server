<?php

namespace HearthStone\services;

use HearthStone\models\Account;

class AccessControl
{
    /**
     * 不需要校验token的command列表
     * @var array
     */
    private static $allowCommand = [
        'DoLogin',
    ];
    
    public static function checkLogin($receivedData)
    {
        if( in_array( $receivedData->cmd, self::$allowCommand ) ||
            (isset($receivedData->token) && Account::model()->checkToken($receivedData->token)) ){
            return true;
        }

        return false;
    }
}