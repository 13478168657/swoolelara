<?php

namespace App\Common\Model\Zuhe;


class SubCompany extends Company{

    protected $component = [];
    protected $name;
    public function __construct($name)
    {
        $this->name = $name;
    }

    public function add(Company $company){
        $this->component[] = $company;
    }

    public function remove(Company $company)
    {
        $pos = array_search($company,$this->component);
        if(!is_null($pos)) unset($this->component[$pos]);
    }

    public function display($depth)
    {
        echo str_repeat('-',$depth).$this->name."<br>";
        foreach($this->component as $com){
            $com->display($depth+2);
        }
    }

}