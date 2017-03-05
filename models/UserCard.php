<?php

namespace HearthStone\models;


class UserCard
{
    /**
     * @var string
     */
    private $id;

    /**
     * @var int 同一卡牌的数量
     */
    private $num;

    /**
     * @var int 同一卡牌金卡的数量
     */
    private $isGoldNum;

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getNum()
    {
        return $this->num;
    }

    /**
     * @return boolean
     */
    public function getGoldNum()
    {
        return $this->isGoldNum;
    }

    /**
     * 添加卡牌
     * @param UserCard $card
     *
     * @return $this
     */
    public function addCard(UserCard $card)
    {
        $this->num = $this->num + $card->num;
        $this->isGoldNum = $this->isGoldNum + $card->isGoldNum;
        
        return $this;
    }
    
    public function __construct($id, $num, $isGoldNum = 0)
    {        
        $this->id = $id;
        $this->num = $num;
        $this->isGoldNum = $isGoldNum;
    }
    
    public function toArray()
    {
        return [
            'id' => $this->id,
            'num' => $this->num,
            'isGoldNum' => $this->isGoldNum,
        ];
    }
}