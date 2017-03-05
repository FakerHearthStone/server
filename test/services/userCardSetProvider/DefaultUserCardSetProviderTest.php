<?php


use HearthStone\services\ContainerBuilder;
use HearthStone\services\userCardSetProvider\DefaultUserCardSetProvider;
use HearthStone\models\CardClass;

class DefaultUserCardSetProviderTest extends PHPUnit_Framework_TestCase
{
    private static $container;

    public static function setUpBeforeClass()
    {
        self::$container = ContainerBuilder::getInstance();
    }

    public function testConstruct()
    {
        $provider = new DefaultUserCardSetProvider(CardClass::DRUID);
        $this->assertEquals(15, count($provider->getUserCardSet()->getCards()));
    }
}
