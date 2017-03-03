<?php

namespace HearthStone\models;


class CardClass
{
    const DEATHKNIGHT = 1;
    const DREAM = 11;
    const DRUID = 2;
    const HUNTER = 3;
    const INVALID = 0;
    const MAGE = 4;
    const NEUTRAL = 12;
    const PALADIN = 5;
    const PRIEST = 6;
    const ROGUE = 7;
    const SHAMAN = 8;
    const WARLOCK = 9;
    const WARRIOR = 10;

    private $cardClassVal;

    private $code;

    private $name;

    /**
     * @return int
     */
    public function getCardClassVal()
    {
        return $this->cardClassVal;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    public function __construct($val)
    {
        $this->cardClassVal = $val;

        $cardClassData = self::getAllCardClass()[$val];
        $this->name = $cardClassData['name'];
        $this->code = $cardClassData['code'];
    }

    /**
     * @param $code string
     *
     * @return mixed|null
     */
    public static function getCardClassByCode($code)
    {
        foreach (self::getAllCardClass() as $cardClsVal => $cardClsArr){
            if( $cardClsArr['code'] == $code ){
                return $cardClsArr;
            }
        }
        
        return null;
    }
    
    public static function getAllCardClass($withNeutral = true)
    {
        $all = [
            self::DRUID => ['name' => '德鲁伊', 'code' => 'DRUID'],
            self::HUNTER => ['name' => '猎人', 'code' => 'HUNTER'],
            self::MAGE => ['name' => '法师', 'code' => 'MAGE'],
            self::PALADIN => ['name' => '圣骑士', 'code' => 'PALADIN'],
            self::PRIEST => ['name' => '牧师', 'code' => 'PRIEST'],
            self::ROGUE => ['name' => '盗贼', 'code' => 'ROGUE'],
            self::SHAMAN => ['name' => '萨满', 'code' => 'SHAMAN'],
            self::WARLOCK => ['name' => '术士', 'code' => 'WARLOCK'],
            self::WARRIOR => ['name' => '战士', 'code' => 'WARRIOR'],
        ];

        if( $withNeutral ){
            $all[self::NEUTRAL] = ['name' => '中立', 'code' => 'NEUTRAL'];
        }

        return $all;
    }
}