<?php

use HearthStone\models\CardContainer;
use HearthStone\models\UserCard;

class CardContainerTest extends \PHPUnit_Framework_TestCase
{

    public function testCountTotalCard()
    {
        $cardContainer = new CardContainer();

        $cardContainer->addCard(new UserCard('EX1_116', 1));
        $this->assertEquals(1, $cardContainer->countTotalCard());

        //传说卡牌只能有1张
        $cardContainer->addCard(new UserCard('EX1_116', 1, 1));
        $this->assertEquals(1, $cardContainer->countTotalCard());

        $cardContainer->addCard(new UserCard('EX1_166', 2));
        $this->assertEquals(3, $cardContainer->countTotalCard());

        //同一非传说卡牌只能小于或等于2张
        $cardContainer->addCard(new UserCard('EX1_166', 2, 1));
        $this->assertEquals(3, $cardContainer->countTotalCard());

        $cardContainer->addCard(new UserCard('EX1_544', 1));
        $this->assertEquals(4, $cardContainer->countTotalCard());

        //同一非传说卡牌只能小于或等于2张(1普通 1 金卡)
        $cardContainer->addCard(new UserCard('EX1_544', 1, 1));
        $this->assertEquals(5, $cardContainer->countTotalCard());

        $cardContainer->addCard(new UserCard('EX1_544', 1));
        $this->assertEquals(5, $cardContainer->countTotalCard());
    }

    public function testAddCard()
    {
        $cardContainer = new CardContainer();
        
        $ret = $cardContainer->addCard(new UserCard('EX1_116', 1));
        $this->assertTrue($ret);

        //传说卡牌只能有1张
        $ret = $cardContainer->addCard(new UserCard('EX1_116', 1, 1));
        $this->assertFalse($ret);

        $ret = $cardContainer->addCard(new UserCard('EX1_166', 2));
        $this->assertTrue($ret);

        //同一非传说卡牌只能小于或等于2张
        $ret = $cardContainer->addCard(new UserCard('EX1_166', 2, 1));
        $this->assertFalse($ret);

        $ret = $cardContainer->addCard(new UserCard('EX1_544', 1));
        $this->assertTrue($ret);

        //同一非传说卡牌只能小于或等于2张(1普通 1 金卡)
        $ret = $cardContainer->addCard(new UserCard('EX1_544', 1, 1));
        $this->assertTrue($ret);

        $ret = $cardContainer->addCard(new UserCard('EX1_544', 1));
        $this->assertFalse($ret);
    }

    public function testRemoveAllCard()
    {
        $cardContainer = new CardContainer();

        $ret = $cardContainer->addCard(new UserCard('EX1_116', 1));

        $ret = $cardContainer->addCard(new UserCard('EX1_166', 2, 1));

        $ret = $cardContainer->addCard(new UserCard('EX1_544', 1));

        $cardContainer->removeAllCard();

        $this->assertEquals(0, $cardContainer->count());

        $ret = $cardContainer->addCard(new UserCard('EX1_544', 1));

        $this->assertEquals(1, $cardContainer->count());

    }
}
