<?php

namespace HearthStone\commands;


use HearthStone\models\Account;

class DoLoginCommand extends BaseCommand
{
    /**
     * @var Account
     */
    private $user;
    
    public function handler($server, $frame)
    {
        $receivedData = json_decode($frame->data);

        //用户存在并且密码验证成功,则更新登录信息(登录时间,token)
        $this->user = (new Account())->getAccountInfo($receivedData->params->loginName);

        if( $this->user && $this->user->validPassword($receivedData->params->password) ){
            $this->user = $this->user->updateLoginInfo($receivedData->params->loginName);

            if( $this->user->getToken() ){
                $this->clients->offsetSet($this->user->getToken(), $frame->fd);
            }
            
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