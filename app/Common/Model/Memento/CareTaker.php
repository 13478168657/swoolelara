<?php


namespace App\Common\Model\Memento;


class CareTaker {
    protected $historyMemento = [];

    public function setMemento(Memento $memento){
        $this->historyMemento[] =  $memento;
    }

    public function getMemento($id){

        return $this->historyMemento[$id];
    }
}