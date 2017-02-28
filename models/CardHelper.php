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
     * @param array  $set 卡牌所属集合
     * @param array   $playerClass 职业
     * @param null|int   $cost 法力
     * @param string $searchText 搜索文本
     * @param bool   $onlyGold 只搜索金卡
     * @param bool   $collectible 是否可制作
     *
     * @return mixed
     */
    public function search($set = [], $playerClass = [], $cost = null, $searchText = '', $onlyGold = false, $collectible = true){
        //只要不满足某个条件就返回false,否则返回true
        return array_filter($this->cardArr, function(Card $card) use($set, $playerClass, $cost, $searchText, $onlyGold, $collectible){
            return
                $card->inSet($set) &&
                $card->playerClassIn($playerClass) &&
                $card->needCost($cost) &&
                $card->matchSearchText($searchText) &&
                $card->isGold($onlyGold) &&
                $card->isCollectible($collectible);
        });
    }

    public function getInitCards()
    {
        $userCards = [];
        $coreCards = $this->search(['CORE']);

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