<?php

namespace HearthStone\models;


class Account extends BasicModel
{
    public function register($account)
    {
        if( ! $this->redis->exists('account:' . $account['accountName']) ){
            $this->redis->hmset('account:' . $account['accountName'], $account);
            
            return true;
        }
        
        return false;
    }
    
    public function getAccountInfo($accountName, $password)
    {
        $accountInfo = $this->redis->hmget('account:' . $accountName, ['accountName']);
        if( $accountInfo ){
            
        }
        
        return false;
    }
}