<?php

namespace HearthStone\services\userCardSetProvider;

abstract class UserCardSetProvider
{
    protected $userCardSet;
    
    /**
     * @return null| \HearthStone\models\UserCardSet
     */
    public function getUserCardSet()
    {
        return $this->userCardSet;
    }
}