<?php

namespace App\Services\Es;

class User extends Base{

    public function __construct($index,$type)
    {
        parent::__construct($index,$type);
    }

    public function getUserBy($id)
    {

    }

    public function getUser()
    {

    }

    public function create_index()
    {
        $url = $this->link.'/'.$this->index;
        $shards = ["number_of_shards"=>3, "number_of_replicas"=>1];
        $mapping['settings'] = $shards;
        $result = $this->curlUtil->request($url,$mapping,'PUT');
        return $result;
    }

    public function createMapping(){

        $mapping= [
            $this->type =>[
                "properties"=>[
                    "title"=>[
                        'type'=>"text"
                    ]
                ]
            ]
        ];
        $url = $this->link.'/'.$this->index.'/_mapping/'.$this->type;
        $result = $this->curlUtil->request($url,$mapping,'POST');
        return $result;
    }
    public function delete_index(){

        $url = $this->link.'/'.$this->index;
        $result = $this->curlUtil->request($url,[],'DELETE');
        return $result;
    }

}