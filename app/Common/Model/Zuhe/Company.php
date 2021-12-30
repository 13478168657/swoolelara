<?php

namespace App\Common\Model\Zuhe;


abstract class Company{


    public function __construct()
    {

    }

    abstract public function add(Company $company);
    abstract public function remove(Company $company);
    abstract public function display($depth);
}