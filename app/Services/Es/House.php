<?php


namespace App\Services\Es;
class House extends Base{


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
                    "id"=>[
                        'type'=>'integer'
                    ],
                    "name"=>[
                        'type'=>"text"
                    ],
                    "updatetime"=>[
                        'type'=>'integer'
                    ],
                    'site'=>[
                        'type'=>'text'
                    ],
                    'relation_city'=>[
                        'type'=>'text'
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

    public function create_doc(){
        $data = [['id'=>1,"name"=>"bj楼盘1","site"=>"bj","updatetime"=>time()+rand(0,100),'relation_city'=>"bj"],
            ['id'=>2,"name"=>"bj楼盘2","site"=>"bj","updatetime"=>time()+rand(0,100),'relation_city'=>"bj"],
            ['id'=>3,"name"=>"bj楼盘3","site"=>"bj","updatetime"=>time()+rand(0,100),'relation_city'=>"bj"],
            ['id'=>4,"name"=>"bj楼盘4","site"=>"bj","updatetime"=>time()+rand(0,100),'relation_city'=>"relation_city"],
            ['id'=>5,"name"=>"lf楼盘1","site"=>"lf","updatetime"=>time()+rand(0,10),'relation_city'=>"bj|lf"],
            ['id'=>6,"name"=>"lf楼盘2","site"=>"lf","updatetime"=>time()+rand(0,10),'relation_city'=>"bj|lf"],
            ['id'=>7,"name"=>"lf楼盘3","site"=>"lf","updatetime"=>time()+rand(0,10),'relation_city'=>"bj|lf"],
            ['id'=>8,"name"=>"lf楼盘4","site"=>"lf","updatetime"=>time()+rand(0,10),'relation_city'=>"lf"],
            ['id'=>9,"name"=>"lf楼盘5","site"=>"lf","updatetime"=>time()+rand(0,10),'relation_city'=>"sh|lf"],
            ['id'=>10,"name"=>"lf楼盘6","site"=>"lf","updatetime"=>time()+rand(0,10),'relation_city'=>""],
            ['id'=>11,"name"=>"sh楼盘1","site"=>"sh","updatetime"=>time()+rand(0,10),'relation_city'=>"sh"],
            ['id'=>12,"name"=>"sh楼盘2","site"=>"sh","updatetime"=>time()+rand(0,10),'relation_city'=>"sh"],
            ['id'=>13,"name"=>"sh楼盘3","site"=>"sh","updatetime"=>time()+rand(0,10),'relation_city'=>"sh"],
            ['id'=>14,"name"=>"sh楼盘4","site"=>"sh","updatetime"=>time()+rand(0,10),'relation_city'=>"bj|sh"],
            ['id'=>15,"name"=>"sh楼盘5","site"=>"sh","updatetime"=>time()+rand(0,10),'relation_city'=>"sh"],
            ['id'=>16,"name"=>"sh楼盘6","site"=>"sh","updatetime"=>time()+rand(0,10),'relation_city'=>"sh"]];

        foreach($data as $v){

            $url = $this->link.'/'.$this->index.'/'.$this->type.'/'.$v['id'];
            $result = $this->curlUtil->request($url,$v,'PUT');
            print_r($result);
        }

    }

}