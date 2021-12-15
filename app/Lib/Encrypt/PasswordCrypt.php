<?php

namespace App\Lib\Encrypt;


class PasswordCrypt{

    public function algos(){
        if (version_compare(PHP_VERSION, '7.4.0', '<')) {
            function password_algos()
            {
                $algos = [PASSWORD_BCRYPT];
                defined('PASSWORD_ARGON2I')  && $algos[] = PASSWORD_ARGON2I;
                defined('PASSWORD_ARGON2ID') && $algos[] = PASSWORD_ARGON2ID;
                return $algos;
            }
        }
        $algos = password_algos();

        print_r($algos);
        return $algos;
    }

    public function pass_hash(){

        $a= password_hash("rasmuslerdorf", PASSWORD_DEFAULT);

        var_dump(password_get_info($a));
//change every refresh
        var_dump($a);

    }
}