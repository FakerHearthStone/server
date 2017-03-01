<?php

namespace HearthStone\models;


class CardHelper extends BasicModel
{
    private $cardArr = [];
    public static $crazySet = ['NAXX', 'GVG', 'REWARD'];
    public static $standSet = ['CORE', 'EXPERT1', 'BRM', 'TGT', 'LOE', 'OG', 'KARA', 'GANGS'];

    //HERO_SKINS 英雄皮肤
    public static $sets = [
        'CORE',    //基础
        'EXPERT1', //专家
        'NAXX', //纳克萨玛斯
        'GVG', //地精大战侏儒
        'REWARD', //奖励
        'PROMO', //促销
        'BRM', //黑石山的火焰
        'TGT', //冠军的试炼
        'LOE', //探险者协会
        'OG', //上古神
        'KARA', //卡拉赞
        'GANGS', //加基森
    ];

    public function __construct(){
        parent::__construct();
        $jsonData = file_get_contents(ROOT_PATH . '/data/cards.collectible.json');
        $this->cardArr = json_decode($jsonData);

        foreach ($this->cardArr as &$card){
            $card = new Card($card);
        }
    }

    /**
     * 获取卡牌的详细信息
     *
     * @param string $id   AT_132
     *
     * @return Card
     */
    public function getCardDetail($id){
        if( ! is_string($id) || $id == '' ){
            throw new \Exception("无效的卡牌id");   
        }
        
        $finds = array_filter($this->cardArr, function($card) use($id){
            return $card->id == $id;
        });

        return $finds[array_keys($finds)[0]];
    }

    /**
     * 根据条件搜索卡牌
     *
     * @param CardFilter $filter
     *
     * @return mixed
     */
    public function search(CardFilter $filter){
        //只要不满足某个条件就返回false,否则返回true
        return array_filter($this->cardArr, function(Card $card) use ($filter) {
            return
                $card->inSet($filter->getSet()) &&
                $card->playerClassIn($filter->getPlayerClass()) &&
                $card->needCost($filter->getCost()) &&
                $card->matchSearchText($filter->getSearchText()) &&
                $card->isGold($filter->isOnlyGold()) &&
                $card->isCollectible($filter->isCollectible()) && 
                ! $card->isHero();
        });
    }

    public function getInitCards()
    {
        $userCards = [];
        $coreCards = $this->search(new CardFilter(['CORE']));

        foreach ($coreCards as $card){
            $userCards[] = [
                'id' => $card->id,
                'num' => 2,
                'isGold' => 0,
            ];
        }

        return $userCards;
    }
}