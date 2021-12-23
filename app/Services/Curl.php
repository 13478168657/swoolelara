<?php

namespace App\Services;
class Curl {


    public function request($url, $data, $type = 'POST',$header = [], $timeout = 30){
        $header =array("Content-type:application/json;charset='utf-8'","Accept:application/json");
        switch($type){

            case 'GET':

                $response = $this->get($url,$data,$type,$header,$timeout);
                break;
            case 'POST':

                $response = $this->post($url,$data,$type,$header,$timeout);
                break;
            case 'PUT':

                $response = $this->post($url,$data,$type,$header,$timeout);
                break;
            case 'DELETE':

                $response = $this->post($url,$data,$type,$header,$timeout);
                break;
            default:

                break;
        }

        return $response;
    }
    public function get($url,$data, $type, $header, $timeout){

        $result = $this->http($url, $type, $data, $header, $timeout);

        return $result;
    }


    public function post($url, $data, $type, $header=[], $timeout=0){

        $result = $this->http($url, $type, $data, $header, $timeout);
        return $result;

    }

    function http($url, $method, $postData=[], $headers=[], $timeout=0) {

        $ci = curl_init();
        curl_setopt($ci, CURLOPT_TIMEOUT, $timeout);
        curl_setopt($ci, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ci, CURLOPT_HEADER, FALSE);
        !empty($postData) && $postData = json_encode($postData);
        switch ($method) {
            case 'POST':

                curl_setopt($ci, CURLOPT_POST, TRUE);
                if(!empty($postData)){
                    curl_setopt($ci, CURLOPT_POSTFIELDS, $postData);
                }
                break;
            case 'GET':
                curl_setopt($ci, CURLOPT_FOLLOWLOCATION, 1);
                if(!empty($postData)){
                    curl_setopt($ci, CURLOPT_POSTFIELDS, $postData);
                }
                break;
            case 'PUT':
                curl_setopt($ci, CURLOPT_CUSTOMREQUEST, 'PUT');
                if(!empty($postData)){
                    curl_setopt($ci, CURLOPT_POSTFIELDS, $postData);
                }
                break;
            case 'DELETE':
                curl_setopt($ci, CURLOPT_CUSTOMREQUEST, 'DELETE');
//                curl_setopt($ci, CURLOPT_POSTFIELDS,$postData);
                break;
        }

        curl_setopt($ci, CURLOPT_URL, $url);
        curl_setopt($ci, CURLOPT_HTTPHEADER, $headers );
//        var_dump(curl_getinfo($ci));
        $response = curl_exec($ci);
        curl_close ($ci);
        return $response;
    }
}