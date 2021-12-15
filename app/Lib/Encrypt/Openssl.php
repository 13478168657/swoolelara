<?php

namespace App\Lib\Encrypt;


class Openssl{

    private $ciphter;
    private $tag;

    public function __construct()
    {
        $this->cipher = "aes-128-ccm";
        $this->tag = "123456";
    }

    public function get_methods(){

        $methods =  openssl_get_cipher_methods();
        print_r($methods);
        return $methods;
    }


    public function aes_encrypt($content)
    {
        $plaintext = $content;

        $key = openssl_random_pseudo_bytes(20);
        if (in_array($this->cipher, openssl_get_cipher_methods()))
        {
            //加密
            $ivlen = openssl_cipher_iv_length($this->cipher);
            $iv = openssl_random_pseudo_bytes($ivlen);
            print_r($ivlen);
            $ciphertext = openssl_encrypt($plaintext, $this->cipher, $key, $options=0, $iv, $this->tag);
            //store $cipher, $iv, and $tag for decryption later

            //解密
            $original_plaintext = openssl_decrypt($ciphertext, $this->cipher, $key, $options=0, $iv, $this->tag);
            echo $original_plaintext."\n";
        }
    }

    public function aes_decrypt()
    {

    }
}