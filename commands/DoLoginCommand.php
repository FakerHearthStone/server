<?php

namespace HearthStone\commands;


use HearthStone\models\Account;

class DoLoginCommand extends BaseCommand
{
    private $user;
    
    public function handler($request)
    {
        $this->user = Account::model()->getAccountInfo($request->params->loginName, $request->params->password);

        if( $this->user ){
            $this->data['user'] = $this->user;
            //TODO: 后续需要补充用户信息
            $this->data['storeState'] = STORE_OPENED;
            $this->data['roomState'] = ROOM_HAVE_FREE;
            $this->data['serverState'] = 0;
            $this->data['cardset'] = [];
        }else{
            $this->code = STATUS_NOT_FOUND_USER;
            $this->msg = '没有找到用户';
        }

        return $this;
    }
}