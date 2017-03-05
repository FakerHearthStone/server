<?php

namespace HearthStone\models;


class CardContainer extends \ArrayObject
{
    /**
     * 统计同一张卡牌已经有都少张,不区分普通卡和金卡
     *
     * @param string $cardId
     *
     * @return int
     */
    public function countCard($cardId)
    {
        if( $this->offsetExists($cardId) ){
            $card = $this->offsetGet($cardId);
            return empty($card) ? 0 : $card->getNum();
        }else{
            return 0;
        }
    }

    /**
     * 统计总卡牌数量
     * 
     * @return int
     */
    public function countTotalCard()
    {
        return array_reduce($this->getArrayCopy(), function($i, UserCard $card){
           return $i + $card->getNum();
        }, 0);
    }

    /**
     * 添加卡牌
     *
     * @param UserCard $targetCard
     *
     * @return bool 添加是否成功
     */
    public function addCard(UserCard $targetCard)
    {
        //如果没有达到卡牌数量的上限,则添加并返回true,否则返回false
        $cardDetail = CardHelper::model()->getCardDetail($targetCard->getId());
        
        if( $cardDetail->rarity == 'LEGENDARY' && $this->countCard($targetCard->getId()) == 1 ){
            return false;
        }elseif( $this->countCard($targetCard->getId()) == 2 ){
            return false;
        }elseif( $this->countCard($targetCard->getId()) + $targetCard->getNum() > 2 ){
            return false;
        }elseif( $targetCard->getNum() == 0 ){
            return false;
        }

        //当前类型的卡牌已经存在,则更新已存在的数据,否则为添加
        if( $this->countCard($targetCard->getId()) == 0 ){
            $this->offsetSet($targetCard->getId(), $targetCard);
        }else{
            $this->offsetSet($targetCard->getId(), $this->offsetGet($targetCard->getId())->addCard($targetCard));
        }

        return true;
    }

    /**
     * 移除所有卡牌
     */
    public function removeAllCard()
    {
        foreach( array_keys($this->getArrayCopy()) as  $offset ){
            $this->offsetUnset($offset);
        }
    }
}