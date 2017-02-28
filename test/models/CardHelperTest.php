<?php


use HearthStone\models\CardHelper;
use HearthStone\services\ContainerBuilder;

class CardHelperTest extends PHPUnit_Framework_TestCase
{
    private static $container;

    public static function setUpBeforeClass()
    {
        self::$container = ContainerBuilder::getInstance();
    }

    public function searchProvider()
    {
        return [
            [null, null, null, '', false, true,],
            [['CORE'], null, null, '', false, true,],
            [['CORE'], ['NEUTRAL'], null, '', false, true,],
            [['CORE'], ['SHAMAN'], null, '', false, true,],
            [['CORE'], ['NEUTRAL', 'SHAMAN'], null, '', false, true,],
            [['CORE'], ['NEUTRAL', 'SHAMAN'], 1, '', false, true,],
            [['CORE'], ['NEUTRAL', 'SHAMAN'], null, '风', false, true,],
            [['EXPERT1'], null, null, '', false, true,],
        ];
    }

    public function cardDetailProvider()
    {
        return [
            ['AT_132'],
            ['CS2_039'],
        ];
    }

    /**
     * @dataProvider searchProvider
     */
    public function testSearch($set, $playerClass, $cost, $searchText, $onlyGold, $collectible)
    {
        $cards = CardHelper::model()->search($set, $playerClass, $cost, $searchText, $onlyGold, $collectible);
        $this->assertNotEmpty($cards);
    }

    /**
     * @dataProvider cardDetailProvider
     */
    public function testGetCardDetail($id)
    {
        $card = CardHelper::model()->getCardDetail($id);
        $this->assertNotEmpty($card);
        $this->assertInstanceOf('HearthStone\models\Card', $card);
    }
}
