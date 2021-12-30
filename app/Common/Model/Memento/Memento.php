<?php

namespace App\Common\Model\Memento;


class Memento {

    public $state;
    public function __construct($state)
    {
        $this->state = $state;
    }

    public function getState(){
        return $this->state;
    }
}