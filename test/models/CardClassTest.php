<?php

use HearthStone\models\CardClass;
use HearthStone\services\ContainerBuilder;

class CardClassTest extends PHPUnit_Framework_TestCase
{
    private static $container;

    public static function setUpBeforeClass()
    {
        self::$container = ContainerBuilder::getInstance();
    }

    public function testConstruct()
    {
        $cardClass = new CardClass(CardClass::DRUID);
        
        $this->assertNotEmpty($cardClass);
    }

    public function testGetCardClassByCode()
    {
        $cardClass = CardClass::getCardClassByCode('DRUID');
        
        $this->assertNotEmpty($cardClass);
        $this->assertArrayHasKey('name', $cardClass);
    }

    public function testGetAllCardClass()
    {
        $all = CardClass::getAllCardClass();
        $this->assertNotEmpty($all);
    }
}