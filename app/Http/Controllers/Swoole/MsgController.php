<?php


namespace App\Http\Controllers\Swoole;

use App\Common\Crypt;
use App\Lib\Encrypt\Hash;
use App\Lib\Encrypt\Openssl;
use App\Lib\Encrypt\PasswordCrypt;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Request;


class MsgController extends Controller{

    public function __construct()
    {
        parent::__construct();

    }


    public static function chat($request)
    {

        return view('msg.msg');
    }

}