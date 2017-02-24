<?php


use HearthStone\models\Account;
use HearthStone\services\ContainerBuilder;

class AccountTest extends PHPUnit_Framework_TestCase
{
    private static $container;

    public static function setUpBeforeClass()
    {
        self::$container = ContainerBuilder::getInstance();
    }

    public function testRegister()
    {
        Account::model()->register([
            'accountName' => 'n' . rand(1, 100),
            'password' => '',
            'nickName' => '',
            'accountStatus' => '',
            'coin' => '',
            'dust' => 0,
            'level' => '',
            'starsNum' => '',
            'isRank' => 'N',
            'rank' => '',
            'incomeToday' => '',
            'netPoints' => '',
            'registerTime' => date('Y-m-d H:i:s'),
            'lastLoginTime' => date('Y-m-d H:i:s'),
            'token' => '',
        ]);
    }

    public function testGetAccountInfo()
    {
        Account::model()->getAccountInfo('n94', '123456');
    }
}
