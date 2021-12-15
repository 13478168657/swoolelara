<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Common\Crypt;
use Illuminate\Support\Facades\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $module_config;

    //密钥
    private $private_key;
    private $public_key;
    public function __construct()
    {
        $this->set_crypt_key();
//        $this->module_crypt = new Crypt();
//        $this->decrypt_params();
    }

    /**
     * api接口成功输出数据
     * @param int $total
     * @param array $data
     */
    protected function _api_response($error_code = 0, $error_msg = '' , $info = array(), $is_crypt = 1)
    {
        $return = array(
            'error_code' => $error_code,
            'error_msg' => $error_msg,
            'data' => $info,
            'request' => array()
        );

        $return_str = json_encode($return);

        $encrypt_data = $this->module_crypt->aes_encrypt($this->aes_key, $return_str);

        $encrypt_key = $this->module_crypt->rsa_encrypt($this->client_public_key, $this->aes_key);
        $return_str = json_encode(array('d'=>$encrypt_data, 'p'=>base64_encode($encrypt_key)));

        if ($this->zip == 4)
        {
            header('Content-type: application/json;charset=UTF-8');
            header('Content-Encoding: deflate');
            echo gzdeflate($return_str);
            exit;
        }
        if ($this->zip == 3)
        {
            header('Content-type: application/json;charset=UTF-8');
            header('Content-Encoding: legzip');
            echo gzdeflate($return_str);
            exit;
        }
        header('Content-type: application/json;charset=UTF-8');
        //header('Content-Type: application/zip');
        header('Cache-Control: no-cache, no-store, max-age=0, must-revalidate');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header("Access-Control-Allow-Origin: *");
        echo $return_str;
        exit;
    }

    private function decrypt_params(Request $request){
        $encrypt = $request->input('e');
        $en_aeskey = $request->input('x');
        if (empty($encrypt) || empty($en_aeskey))
        {
            $this->_api_fial('-100','参数错误！', array(), 2);
        }

        $aes_key = $this->module_crypt->rsa_decrypt($this->private_key, base64_decode($en_aeskey));

        $this->client_aes_key = $aes_key;//解密获取客户端aes key

        $decrypt = $this->module_crypt->aes_decrypt($this->client_aes_key, $encrypt);

        $params = json_decode($decrypt, true);

        $device = $request->input('device');
        $this->module_crypt->update_client_aeskey($device, $this->client_aes_key);

        $keys = $this->module_crypt->get_cryptkey($device);

        $this->private_key = $keys['private_key'];

        if (!isset($keys['client_public_key']) || empty($keys['client_public_key']))
        {
            $this->_api_fial('-107', '参数验证错误！', array(), 2);
        }
        $this->client_public_key = $keys['client_public_key'];

        $this->aes_key = $keys['aes_key'];

    }

    /**
     * Notes:
     * User: kuokuo@leju.com
     * Date: ${DATE}
     * Time: ${TIME}
     * rsa公钥，私钥
     */
    private function set_crypt_key(){

        $this->private_key = "-----BEGIN PRIVATE KEY-----
MIICdgIBADANBgkqhkiG9w0BAQEFAASCAmAwggJcAgEAAoGBANZZkZXPF4aUNDM+
d9hHaRshEix/ku/tYw9h1DjR94vG1DiD++29v6zB0pUaUkflNizLrIsWtyPwyNtZ
+6zK7no6RjUk0XWZwOCSsqbq+1ntZ9vmMZGruUgu+35a6z+8HR5R9wVE6kalCTNT
B3FGrQg8GXn86hMlY833ci5EFX/7AgMBAAECgYEAqAcClvsGKBsZaGo5rDMec4PT
KUrANpBSLQa1Q+1kLhAo4DymSlGKZbRyjStbALzvYOIwWb/uxJ/F9B1vqp5RndOO
/t5xUF+CRaZppZ1ShIZrn3VGmcZfXz/TMvyixwqUHdACQR1ZPY0xmfgPTUPJW8Xy
2MgU5RlZKidK1/9G/3ECQQDxbJGWxXEvTCOmrD+vSoRs/CpPLaQHaivlHdEkyVeh
etLe9CFO1YCw2ntMOipcs4Wb+sjvOKNRRWjjYfUx8r6tAkEA40qLBWP0TnU7ApJo
RlgJWcqNTHp10G7vKnhqqx22Z/mvjvS7o+ib3V1BQH1NW0vh7NDupka0Ip7hdBJ1
eZbWRwJAA/PkGlTXOpADkWoGjOcqbeJfCvbTVa++Ujz/vJtzTNiG9VGH7hN+zOZ2
2FOnd+cUi+46Nfh2bBE322kyK4Qu7QJABOr1+xXgkVoD/thAHVWGTkUNrZvwtKPR
1O9qD23DJpjGbadp7+/2f2GnKcgMRm9r4f3bTAm3mBAr/KDxncHfvQJATLiXpnen
UL1Xcky+fF+WKVPDBRXq4TiClKsSoD9r7mzlZ6GcO60eF9xj3pBhXmESegcbJM7A
nKUJuZv3JbFvCA==
-----END PRIVATE KEY-----";
        $this->public_key = "-----BEGIN PUBLIC KEY-----
MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDWWZGVzxeGlDQzPnfYR2kbIRIs
f5Lv7WMPYdQ40feLxtQ4g/vtvb+swdKVGlJH5TYsy6yLFrcj8MjbWfusyu56OkY1
JNF1mcDgkrKm6vtZ7Wfb5jGRq7lILvt+Wus/vB0eUfcFROpGpQkzUwdxRq0IPBl5
/OoTJWPN93IuRBV/+wIDAQAB
-----END PUBLIC KEY-----";
    }

    protected function get_private_key()
    {
        return $this->private_key;
    }

    protected function get_public_key()
    {
        return $this->public_key;
    }
}
