<?php


use HearthStone\models\CardHelper;
use HearthStone\models\CardFilter;
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
            [ new CardFilter(null, null, null, '', false, true) ],
            [ new CardFilter(['CORE'], null, null, '', false, true) ],
            [ new CardFilter(['CORE'], ['NEUTRAL'], null, '', false, true) ],
            [ new CardFilter(['CORE'], ['SHAMAN'], null, '', false, true) ],
            [ new CardFilter(['CORE'], ['NEUTRAL', 'SHAMAN'], null, '', false, true) ],
            [ new CardFilter(['CORE'], ['NEUTRAL', 'SHAMAN'], 1, '', false, true) ],
            [ new CardFilter(['CORE'], ['NEUTRAL', 'SHAMAN'], null, '风', false, true) ],
            [ new CardFilter(['EXPERT1'], null, null, '', false, true) ],
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
     * @param CardFilter $filter
     * @dataProvider searchProvider
     */
    public function testSearch($filter)
    {
        $cards = CardHelper::model()->search($filter);
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
