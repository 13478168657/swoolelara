<?php
namespace App\Common\Model\Zuhe;


class LeafCompany extends Company{

    protected $name;
    public function __construct($name)
    {
        $this->name = $name;
    }

    public function add(Company $company){

    }

    public function remove(Company $company){

    }

    public function display($depth)
    {
        echo str_repeat('-',$depth).$this->name."<br>";
    }
}