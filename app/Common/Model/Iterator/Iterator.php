<?php

namespace App\Common\Model\Iterator;


interface Iterator{

    public function current();

    public function next();

    public function hasNext();
}