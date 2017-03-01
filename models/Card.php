<?php
/**
 * 卡牌类
 */

namespace HearthStone\models;


class Card extends BasicModel
{
    public $artist;
    public $attack;
    public $collectible;
    public $cost;
    public $dbfId;
    public $dust;
    public $flavor;
    public $health;
    /**
     * @var string
     */
    public $id;
    public $mechanics;
    public $name;
    public $playerClass;
    public $rarity;
    public $set;
    public $text;
    public $type;

    public $howToEarn;
    public $howToEarnGolden;
    public $race;
    public $playRequirements;
    public $faction;
    public $collectionText;
    public $entourage;
    public $targetingArrowText;
    public $spellDamage;
    public $classes;
    public $multiClassGroup;
    public $overload;
    public $durability;

    public function __construct($obj){
        parent::__construct();

        $cardData = (array)$obj;
        foreach ($cardData as $attr => $value){
            $this->$attr = $value;
        }

        return $this;
    }

    public function __toString()
    {
        return $this->id;
    }

    public function __get($attr)
    {
        return isset($this->$attr) ? $this->$attr : null;
    }

    public function __set($attr, $value)
    {
        $this->$attr = $value;
    }


    /**
     * 判断卡牌是否在集合中,在集合中返回true,否则返回false
     *
     * @param $set array
     *
     * @return bool
     */
    public function inSet($set = [])
    {
        if( empty($set) ){
            return true;
        }elseif ( is_array($set) && ( isset($this->set ) && ! in_array($this->set, $set) ) ){
            return false;
        }

        return true;
    }

    /**
     * 判断卡牌是否在某个职业集合中,在集合中返回true,否则返回false
     * @param $playerClass array
     *
     * @return bool
     */
    public function playerClassIn($playerClass = [])
    {
        if( is_array($playerClass) ){
            foreach ($playerClass as &$cls){
                if( is_int($cls) ){
                    $cls = (new CardClass())->getCardClassCode($cls, true);
                }
            }
        }

        if( empty($playerClass) ){
            return true;
        }elseif( $playerClass != null && isset($this->playerClass) && ! in_array($this->playerClass, $playerClass) ){
            return false;
        }

        return true;
    }

    /**
     * 判断卡牌是否需要花费给定的水晶
     * @param $cost null|int 需要花费,null为任意花费
     *
     * @return bool
     */
    public function needCost($cost = null)
    {
        if ( $cost != null && ( ! isset($this->cost) || $this->cost != $cost) ){
            return false;
        }

        return true;
    }

    /**
     * 检查卡牌是否满足条件
     *
     * @param string $searchText 条件字符串
     *
     * @return bool
     */
    public function matchSearchText($searchText = '')
    {        
        $parseArr = explode(':', $searchText);

        if( count($parseArr) == 0 || count($parseArr) == 1 && $parseArr[0] == '' ){
            return true;
        }if( count($parseArr) == 1 && $parseArr[0] != '' ){
            return strpos($this->name, $searchText) !== false;
        }elseif( count($parseArr) == 2 ){
            list($attrDesc, $attrVal) = $parseArr;

            //TODO: 尚待完成
            return
                ($attrDesc == '攻击力' && isset($this->attack) && $attrVal == $this->attack) ||
                ($attrDesc == '生命值' && isset($this->health) && $attrVal == $this->health);
        }else{
            return false;
        }
    }

    public function isGold($onlyGold = false)
    {
        return true;
    }

    /**
     * 判断卡牌可合成状态和预期的相符
     *
     * @param bool $collectible true 表示卡牌可以合成, false 表示卡牌不可合成
     *
     * @return bool
     */
    public function isCollectible($collectible = false)
    {
        if( $this->collectible != $collectible ){
            return false;
        }

        return true;
    }
    
    public function isHero()
    {
        if( $this->type == 'HERO' ){
            return true;
        }
        
        return false;
    }
}