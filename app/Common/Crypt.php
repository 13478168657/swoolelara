<?php

namespace App\Common;


use Illuminate\Support\Facades\Redis;
class Crypt {

    public  $data_cryptkeys;
    protected $lib_redis;
    private $iv = '4JQhfldCgt27fciHx6LuVw==';
    public function __construct()
    {
        $this->lib_redis = new Redis();
    }

    public function rsa_decrypt($key, $content){
        $pi_key =  openssl_pkey_get_private($key);
        $result = openssl_private_decrypt($content, $decrypt, $pi_key, OPENSSL_PKCS1_PADDING);
        return $result ? $decrypt : $result;
    }

    /**
     * AES加密
     * @param unknown $key
     * @param unknown $content
     * @return string
     */
    public function aes_encrypt($key, $content)
    {
        $lib_aesencrypt = new lib_aesencrypt($key, base64_decode($this->iv), 'PKCS7', 'cbc', 'base64');
        $en_content = $lib_aesencrypt->encrypt($content);
        return $en_content;
    }

    /**
     * AES 解密
     * @param unknown $key
     * @param unknown $content
     * @return Ambigous <type, mixed>
     */
    public function aes_decrypt($key, $content)
    {
        $lib_aesencrypt = new lib_aesencrypt($key, base64_decode($this->iv), 'PKCS7', 'cbc', 'base64');
        $de_content = $lib_aesencrypt->decrypt($content);
        return $de_content;
    }

    /**
     * RSA 数据加密
     * @param unknown $key
     * @param unknown $content
     * @return unknown
     */
    public function rsa_encrypt($key, $content)
    {
        $pu_key = openssl_pkey_get_public($key);
        $result = openssl_public_encrypt($content, $encrypt, $pu_key, OPENSSL_PKCS1_PADDING);
        return $result ? $encrypt : $result;
    }

    /**
     * 更细客户端AES密钥
     * @param unknown $device
     * @param unknown $client_aeskey
     * @return Ambigous <string, boolean>
     */
    public function update_client_aeskey($device, $client_aeskey)
    {
        $keys = $this->lib_redis->get("crypt_keys_{$device}");
        $k = json_decode($keys, true);
        if ($k['client_aes_key'] == $client_aeskey)
        {
            return true;
        }
        else
        {
            $k['client_aes_key'] = $client_aeskey;
        }

        return $this->lib_redis->set("crypt_keys_{$device}", json_encode($k));

        //return $this->data_cryptkeys->update(array('client_aes_key'=>$client_aeskey), array('device'=>$device));
    }

    /**
     * 获取该设备密钥信息
     * @param unknown $device
     * @return Ambigous <multitype:, multitype:>
     */
    public function get_cryptkey($device)
    {
        $keys = $this->lib_redis->get("crypt_keys_{$device}");
        $result = json_decode($keys, true);
        //$result = $this->data_cryptkeys->fetch_row(array('device'=>$device));
        return $result;
    }

    /**
     * 添加密钥
     * @param unknown $device
     * @param unknown $private_key
     * @param unknown $public_key
     * @param unknown $client_public_key
     * @param unknown $aes_key
     * @return Ambigous <boolean, string>
     */
    public function add_crypt_keys($device, $private_key, $public_key, $client_public_key, $aes_key)
    {
        $data = array(
            'device' => $device,
            'private_key' => $private_key,
            'public_key' => $public_key,
            'client_public_key' => $client_public_key,
            'aes_key' => $aes_key,
            'create_time' => time(),
        );

        $result = $this->lib_redis->set("crypt_keys_{$device}", json_encode($data));

        //$result = $this->data_cryptkeys->replace($data);
        return $result;
    }

    public function add_crypt_keys_test($device, $private_key, $public_key, $client_public_key, $aes_key)
    {
        $data = array(
            'device' => $device,
            'private_key' => $private_key,
            //'public_key' => $public_key,
            'client_public_key' => $client_public_key,
            'aes_key' => $aes_key,
            'create_time' => time(),
        );

        $result = $this->lib_redis->set("crypt_keys_test_{$device}", json_encode($data));

        //$result = $this->data_cryptkeys->replace($data);
        return $result;
    }

    /**
     * 随机生成AES密钥
     * @return string
     */
    public function create_aes_key()
    {
        $size = mcrypt_get_iv_size(MCRYPT_CAST_256, MCRYPT_MODE_ECB);
        $iv = mcrypt_create_iv($size, MCRYPT_DEV_URANDOM);
        $key = hash_pbkdf2('md5', 'fwkjb3ljfbizgxc93b', $iv, 8000, 0, false);
        return $key;
    }
}