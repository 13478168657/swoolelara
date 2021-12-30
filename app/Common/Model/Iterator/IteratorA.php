<?php

namespace App\Common\Model\Iterator;


class IteratorA implements Iterator{

    public $current = 0;

    public function __construct(UserArray $arr)
    {
        $this->userArr = $arr;
    }
    public function first(){

        return $this->userArr->list[0];
    }
    public function current()
    {
        return $this->userArr->list[$this->current];
    }

    public function next()
    {
        $this->current++;
        return $this->userArr->list[$this->current];
    }
    public function hasNext()
    {

        return $this->current < count($this->userArr->list)-1;
    }
}