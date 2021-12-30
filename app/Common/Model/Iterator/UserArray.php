<?php

namespace App\Common\Model\Iterator;


class UserArray{

    public $list = [];
    public function __construct()
    {

    }

    public function add($value){
        array_push($this->list,$value);
    }

    public function remove($value){
        $pos = array_search($value, $this->list);
        if(!is_null($pos)) unset($this->list[$pos]);
    }


}