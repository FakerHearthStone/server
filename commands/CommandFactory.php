<?php

namespace HearthStone\commands;


class CommandFactory
{
    public static function create($command)
    {
        $class = '\HearthStone\commands\\' . ucfirst($command) . 'Command';

        if( class_exists($class) ){
            return new $class();
        }else{
            return new NotFoundCommand();
        }
    }
}