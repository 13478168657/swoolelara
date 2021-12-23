<?php


class loadClass{


    public function autoload($class){

        require_once $class.'.php';
    }
}

spl_autoload_register([new loadClass(),'autoload']);