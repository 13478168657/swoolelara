<?php

namespace App\Services\Es;
class client{


    public function index(){
        $house = new House('house','house');
//        $result = $user->match(['name'=>'ykk'])->should(['id'=>1])->from(1)->size(10)->source(['id', 'name'])->get();
//        $house->create_index();
        $house->create_doc();
//        $result = $user->update(['id'=>3,'name'=>'lisi3']);
//        $result = $user->dselete(3);

//        print_r($result);die;
//        $res = $user->delete_index();
//        print_r($res);die;
    }
}

$client = new client();
$client->index();