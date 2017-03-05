<?php
namespace HearthStone\models;


class UserCardSet extends BasicModel
{
    private $name;
    private $cardClass;
    private $cards;
    
    public function getName()
    {
        return $this->name;
    }
    
    public function __construct($name, $cardClassVal, $cards)
    {
        parent::__construct();
        
        $this->name = $name;
        $this->cardClass = $cardClassVal;
        $this->cards = $cards;
    }
    
    public function getUserCardSetArr()
    {
        $cardArr = [];
        foreach ($this->cards as $card){
            $cardArr[] = $card->toArray();
        }
        
        return [
            'name' => $this->name,
            'cardClass' => $this->cardClass,
            'cards' => $cardArr,
        ];
    }
    
    public function getCards()
    {
        return $this->cards;
    }
}