<?php

namespace App\Common\Model\Danli;


class Danli {

    public static $instance;

    public function __construct()
    {

    }

    public static function getInstance(){

        if(static::$instance instanceof static){
            echo "88";
            print_r(new static);
            return static::$instance;
        }
        print_r(new static);
        static::$instance = new static();
        echo "66";
        return static::$instance;
    }

    public static function set($value)
    {
        echo $value;
    }

}