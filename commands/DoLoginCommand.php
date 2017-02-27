<?php

namespace HearthStone\commands;


use HearthStone\models\Account;

class DoLoginCommand extends BaseCommand
{
    /**
     * @var Account
     */
    private $user;
    
    public function handler($request)
    {
        //用户存在并且密码验证成功,则更新登录信息(登录时间,token)
        $this->user = (new Account())->getAccountInfo($request->params->loginName);

        if( $this->user && $this->user->validPassword($request->params->password) ){
            $this->user = $this->user->updateLoginInfo($request->params->loginName);
            
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