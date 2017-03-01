<?php

namespace HearthStone\models;


class CardFilter
{
    private $set;
    private $playerClass;
    private $cost;
    private $searchText;
    private $onlyGold;
    private $collectible;
    
    public function __construct($set = [], $playerClass = [], $cost = null, $searchText = '', $onlyGold = false, $collectible = true)
    {
        $this->set = $set;
        $this->playerClass = $playerClass;
        $this->cost = $cost;
        $this->searchText = $searchText;
        $this->onlyGold = $onlyGold;
        $this->collectible = $collectible;
    }



    /**
     * @return array
     */
    public function getSet()
    {
        return $this->set;
    }

    /**
     * @return array
     */
    public function getPlayerClass()
    {
        return $this->playerClass;
    }

    /**
     * @return null
     */
    public function getCost()
    {
        return $this->cost;
    }

    /**
     * @return string
     */
    public function getSearchText()
    {
        return $this->searchText;
    }

    /**
     * @return boolean
     */
    public function isOnlyGold()
    {
        return $this->onlyGold;
    }

    /**
     * @return boolean
     */
    public function isCollectible()
    {
        return $this->collectible;
    }
}