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

    public function accountNameProvider()
    {
        return [
            ['n94', true],
            ['not_exists', false]
        ];
    }

    public function updateLoginAccountNameProvider()
    {
        return [
            ['n94', true],
            ['not_exists', false]
        ];
    }

    public function tokenProvider()
    {
        return [
            ['9961943b18de0245976f753b5982601f7939f7b5', true],
            ['', false]
        ];
    }

    public function testRegister()
    {
        Account::model()->register([
            'accountName' => 'n' . rand(1, 100),
            'password' => md5(123456),
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

    /**
     * @dataProvider accountNameProvider
     */
    public function testGetAccountInfo($accountName, $isExists)
    {
        $accountInfo = Account::model()->getAccountInfo($accountName);
        $this->assertEquals(boolval($accountInfo), $isExists);
    }

    /**
     * @dataProvider updateLoginAccountNameProvider
     */
    public function testUpdateLoginInfo($accountName, $isExists)
    {
        Account::model()->updateLoginInfo($accountName);
    }

    /**
     * @dataProvider tokenProvider
     */
    public function testCheckToken($token, $isExists)
    {
        $userName = Account::model()->checkToken($token);
        $this->assertEquals(boolval($userName), $isExists);
    }
}
