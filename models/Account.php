<?php

namespace HearthStone\models;


use HearthStone\services\userCardSetProvider\DefaultUserCardSetProvider;

class Account extends BasicModel
{
    private $fields = [
        'accountName',
        'password',
        'nickName',
        'accountStatus',
        'coin',
        'dust',
        'level',
        'starsNum',
        'isRank',
        'rank',
        'incomeToday',
        'netPoints',
        'registerTime',
        'lastLoginTime',
        'token'
    ];

    protected $password;

    /**
     * 校验账号是否存在
     *
     * @param $accountName string
     *
     * @return bool
     */
    public function checkAccountExists($accountName)
    {
        if( $this->redis->hexists("account:$accountName", 'accountName') ){
            return true;
        }else{
            return false;
        }
    }
    
    public function register($account)
    {
        if( ! $this->checkAccountExists($account['accountName']) ){
            if( empty($account) ){
                return false;
            }

            $account['roleInfo'] = json_encode($this->getRoleInfo());
            
            //设置账号信息
            $this->redis->hmset("account:{$account['accountName']}", $account);

            //设置账号初始卡牌
            $this->redis->set("usercards:{$account['accountName']}", json_encode(CardHelper::model()->getInitCards()));

            //设置用户初始套牌
            foreach( CardClass::getAllCardClass(false) as $cardClassVal => $cardClassArr ){
                $defaultCardSet = (new DefaultUserCardSetProvider($cardClassVal))->getUserCardSet();
                $this->redis->set("usercardset:{$account['accountName']}:" . md5($defaultCardSet->getName()),
                    json_encode($defaultCardSet->getUserCardSetArr()));
            }
            return true;
        }
        
        return false;
    }
    
    public function getAccountInfo($accountName)
    {
        if( $this->checkAccountExists($accountName) ){
            $accountInfo = $this->redis->hmget("account:$accountName", $this->fields);
            $accountArr = array_combine($this->fields, $accountInfo);

            foreach ($accountArr as $attr => $val){
                $this->$attr = $val;
            }

            return $this;
        }
        
        return false;
    }
    
    public function validPassword($password)
    {
        return $this->password == md5($password);
    }

    public function updateLoginInfo($accountName)
    {
        if( $this->checkAccountExists($accountName) ) {
            $token = self::getNewToken();
            $this->redis->hmset("account:$accountName", [
                'lastLoginTime' => date('Y-m-d H:i:s'),
                'token'         => $token,
            ]);

            $this->redis->set("tokens:$token", $accountName);

            return $this->getAccountInfo($accountName);
        }

        return null;
    }

    public static function getNewToken()
    {
        $str = md5(uniqid(md5(microtime(true)), true));
        $str = sha1($str);
        return $str;
    }
    
    public function getToken()
    {
        return $this->token;
    }
    
    public function checkToken($token)
    {
        return $this->redis->get("tokens:$token");
    }

    private function getRoleInfo()
    {
        $roles = array_keys(CardClass::getAllCardClass(false));

        return array_fill_keys($roles, ['level' => 0, 'numOfWins' => 0]);
    }
}