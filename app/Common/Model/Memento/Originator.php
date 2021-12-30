<?php

namespace App\Common\Model\Memento;


class Originator {

    private $state;
    public function __construct()
    {

    }

    public function setState($state){

        $this->state = $state;
    }

    public function createMemento(){

        return new Memento($this->state);
    }

    public function recoveryMemento(Memento $memento){
        $this->state = $memento->getState();
    }

    public function getState(){

        return sprintf("state: %s<br>",$this->state);
    }
}