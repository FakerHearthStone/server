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

    public function getNormalCardClass($cls = null, $withNeutral = false)
    {
        $names = [
            self::DRUID => '德鲁伊',
            self::HUNTER => '猎人',
            self::MAGE => '法师',
            self::PALADIN => '圣骑士',
            self::PRIEST => '牧师',
            self::ROGUE => '盗贼',
            self::SHAMAN => '萨满',
            self::WARLOCK => '术士',
            self::WARRIOR => '战士',
        ];

        if( $withNeutral ){
            $names[self::NEUTRAL] = '中立';
        }

        if( $cls ){
            return $names[$cls];
        }else{
            return $names;
        }
    }
    
    public function getCardClassCode($cls = null, $withNeutral = false)
    {
        $codes = [
            self::DRUID => 'DRUID',
            self::HUNTER => 'HUNTER',
            self::MAGE => 'MAGE',
            self::PALADIN => 'PALADIN',
            self::PRIEST => 'PRIEST',
            self::ROGUE => 'ROGUE',
            self::SHAMAN => 'SHAMAN',
            self::WARLOCK => 'WARLOCK',
            self::WARRIOR => 'WARRIOR',
        ];
        
        if( $withNeutral ){
            $codes[self::NEUTRAL] = 'NEUTRAL';
        }
        
        if( $cls ){
            return $codes[$cls];
        }else{
            return $codes;
        }
    }
}