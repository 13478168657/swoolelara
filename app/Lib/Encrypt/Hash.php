<?php

namespace App\Lib\Encrypt;


class Hash{

    public static function hash_lists()
    {
        $hash_algos = hash_algos();
        print_r($hash_algos);
        return $hash_algos;
    }

    public function hash_copy(){
        $context = hash_init("md5");
        print_r($context);
        hash_update($context, "data");
        print_r($context);
        /* 拷贝上下文资源以便继续使用 */
        $copy_context = hash_copy($context);
        print_r($context);
        echo hash_final($context), "\n";

        hash_update($copy_context, "data");
        echo hash_final($copy_context), "\n";
    }

    public function get_hash_hkdf(){
        $inputKey = random_bytes(32);
        $salt = random_bytes(16);
        print_r($inputKey);
        echo "\n";
// Derive a pair of separate keys, using the same input created above.
        $encryptionKey = hash_hkdf('sha256', $inputKey, 32, 'aes-256-encryption', $salt);
        $authenticationKey = hash_hkdf('sha256', $inputKey, 32, 'sha-256-authentication', $salt);
        print_r($authenticationKey);
        var_dump($encryptionKey !== $authenticationKey); // bool(true)
    }
}