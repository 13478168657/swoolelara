<?php


namespace App\Http\Controllers\Swoole;

use App\Common\Crypt;
use App\Lib\Encrypt\Hash;
use App\Lib\Encrypt\Openssl;
use App\Lib\Encrypt\PasswordCrypt;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Request;


class IndexController extends Controller{

    public function __construct()
    {
        parent::__construct();

    }


    public static function index($request)
    {
        echo "<pre>";
        echo "=====\n";
        print_r(env(''));
        print_r($request->get['a']);
        print_r($request->get['b']);
        echo "====\n";
        echo "\n";
        echo posix_getpid()."\n";
        $hash = new Openssl();
        $hash->aes_encrypt("message to be encrypted");
        $hash->get_methods();
        logger()->info("afaf");
        return view('index.index');
    }
    /**
     * rsa 公钥加密私钥解密
     * Notes:
     * User: kuokuo@leju.com
     * Date: ${DATE}
     * Time: ${TIME}
     */
    public function pub_decrypt(){

        $pri_key = $this->get_private_key();
        $pub_key = $this->get_public_key();
//        print_r($pub_key);die;
        $source = "abcdefghijklmn";
        $p = openssl_pkey_get_public($pub_key);//从证书中解析公钥
        $keyData = openssl_pkey_get_details($p);//获取公钥详细信息 retun array();
        openssl_public_encrypt($source,$crypttext,$pub_key);//公钥加密
//        print_r($key);
        $pi_key =  openssl_pkey_get_private($pri_key);
        $s = openssl_pkey_get_details($pi_key);
        echo "<pre>";
        print_r($s);die;
//        var_dump($pi_key);
        $result = openssl_private_decrypt($crypttext, $decrypt, $pi_key, OPENSSL_PKCS1_PADDING);
        print_r($decrypt);die;
    }

    /**
     * rsa 私钥加密公钥解密
     * Notes:
     * User: kuokuo@leju.com
     * Date: ${DATE}
     * Time: ${TIME}
     */
    public function decrypt_pub(){

        $pri_key = $this->get_private_key();
        $pub_key = $this->get_public_key();
//        print_r($pub_key);die;
        $source = "abcdefghijklmn";
        $pi_key =  openssl_pkey_get_private($pri_key);
//        var_dump($pi_key);
        openssl_private_encrypt($source, $crypttext, $pi_key, OPENSSL_PKCS1_PADDING);
//        $p = openssl_pkey_get_public($pub_key);//从证书中解析公钥
//        $keyData = openssl_pkey_get_details($p);//获取公钥详细信息 retun array();
        openssl_public_decrypt($crypttext,$newsource,$pub_key);//公钥加密
//        print_r($key);
        echo "7777ba\n";
        print_r($newsource);die;
    }

    public function add(){

        print_r(88232);
    }


    /**
     * 交换公钥接口
     */
    public function plk(Request $request)
    {

        $device = $request->input('device');
        $client_public_key = $request->input('p');
        $client_public_key = "-----BEGIN PUBLIC KEY-----\n" . wordwrap($client_public_key, 64, "\n", true) . "\n-----END PUBLIC KEY-----";
        $module_crypt = new Crypt();
        $aes_key = $module_crypt->create_aes_key();//aes_key值
        $private_key = $this->get_private_key();
        $public_key = $this->get_public_key();
        $module_crypt->add_crypt_keys($device, $private_key, $public_key, $client_public_key, $aes_key);

        $data = array('p'=>$public_key);
        $this->_api_response(0, '', $data, 2);
    }

}