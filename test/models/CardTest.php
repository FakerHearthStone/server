<?php

use HearthStone\models\CardHelper;
use HearthStone\models\CardClass;
use HearthStone\services\ContainerBuilder;

class CardTest extends PHPUnit_Framework_TestCase
{
    private static $container;

    public static function setUpBeforeClass()
    {
        self::$container = ContainerBuilder::getInstance();
    }

    public function inSetProvider()
    {
        return [
            ['AT_132', ['TGT'], true],
            ['AT_132', [], false],
            ['AT_132', false, false],
            ['AT_132', null, false],
            ['CS2_039', ['TGT'], false],
            ['CS2_039', ['CORE'], true],
            ['CS2_039', ['CORE', 'TGT'], true],
        ];
    }

    public function playerClassInProvider()
    {
        return [
            ['AT_132', ['NEUTRAL'], true],
            ['AT_132', [CardClass::NEUTRAL], true],
            ['AT_132', [], true],
            ['AT_132', false, true],
            ['AT_132', null, true],
            ['CS2_039', ['NEUTRAL'], false],
            ['CS2_039', ['SHAMAN'], true],
            ['CS2_039', [CardClass::SHAMAN], true],
            ['CS2_039', ['NEUTRAL', 'SHAMAN'], true],
            ['EX1_295', ['MAGE'], true]
        ];
    }

    public function needCostProvider()
    {
        return [
            ['AT_132', 1, false],
            ['AT_132', 6, true],
            ['AT_132', null, true],
            ['CS2_039', 1, false],
            ['CS2_039', 2, true],
            ['CS2_039', null, true],
            ['EX1_295', null, true]
        ];
    }

    public function matchSearchTextProvider()
    {
        return [
            ['AT_132', '', true],
            ['AT_132', '生命值:3', true],
            ['AT_132', '生命值:4', false],
            ['AT_132', '龙', false],
            ['BRM_004', '龙', true],
            ['BRM_004', '攻击力:2', true],
            ['BRM_004', '攻击力:3', false],
        ];
    }

    public function isCollectibleProvider()
    {
        return [
            ['AT_132', true, true],
            ['CS2_039', true, true],
            ['EX1_295', true, true],
        ];
    }

    /**
     * @dataProvider inSetProvider
     */
    public function testInSet($id, $set, $rst)
    {
        $card = CardHelper::model()->getCardDetail($id);
        $inSetRst = $card->inSet($set);
        $this->assertEquals($inSetRst, $rst);
    }

    /**
     * @dataProvider playerClassInProvider
     */
    public function testPlayerClassIn($id, $playerClass, $rst)
    {
        $card = CardHelper::model()->getCardDetail($id);
        $playerClassInRst = $card->playerClassIn($playerClass);
        $this->assertEquals($playerClassInRst, $rst);
    }

    /**
     * @dataProvider needCostProvider
     */
    public function testNeedCost($id, $cost, $rst)
    {
        $card = CardHelper::model()->getCardDetail($id);
        $needCostRst = $card->needCost($cost);
        $this->assertEquals($needCostRst, $rst);
    }

    /**
     * @dataProvider matchSearchTextProvider
     */
    public function testMatchSearchText($id, $searchText, $rst)
    {
        $card = CardHelper::model()->getCardDetail($id);
        $searchTextRst = $card->matchSearchText($searchText);
        $this->assertEquals($searchTextRst, $rst);
    }

    /**
     * @dataProvider isCollectibleProvider
     */
    public function testIsCollectible($id, $collectible, $rst)
    {
        $card = CardHelper::model()->getCardDetail($id);
        $collectibleRst = $card->isCollectible($collectible);
        $this->assertEquals($collectibleRst, $rst);
    }
}
