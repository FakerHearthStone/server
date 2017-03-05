<?php

namespace HearthStone\services\userCardSetProvider;

use HearthStone\models\CardClass;
use HearthStone\models\CardContainer;
use HearthStone\models\CardFilter;
use HearthStone\models\CardHelper;
use HearthStone\models\UserCard;
use HearthStone\models\UserCardSet;

class DefaultUserCardSetProvider extends UserCardSetProvider
{
    protected $userCardSet;

    public function __construct($cardClsVal)
    {
        $cardContainer = new CardContainer();
        $filter = new CardFilter(CardHelper::$coreSet, [CardClass::NEUTRAL]);
        $neutralCards = array_slice(CardHelper::model()->search($filter), 0, 15, true);

        foreach ($neutralCards as $card){
            $cardContainer->addCard(new UserCard($card->id, 2));
        }
        
        $cardClass = new CardClass($cardClsVal);        
        $this->userCardSet = new UserCardSet('基础' . $cardClass->getName(), $cardClass->getCardClassVal(), $cardContainer->getArrayCopy());
    }
}