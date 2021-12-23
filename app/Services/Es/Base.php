<?php

namespace App\Services\Es;

use App\Services\Curl;
abstract class Base{

    public $index;
    public $link = '172.17.0.8:9200';

    public $matches = [];
    public $match = [];
    public $filters = [];
    public $should = [];
    public $must = [];
    public $sort = [];
    public $group = [];
    public $from;
    public $size;
    public $fields = [];
    public $cutlUtil;
    public $mapping = [];
    public $term = [];
    public $terms = [];
    public $query = [];
    public $range = [];
    public $source = [];
    public $bool = [];
    public $exists = [];
    public function __construct($index, $type = 'doc')
    {
        $this->index = $index;
        $this->type = $type;
        $this->curlUtil = new Curl();
    }

    public function type($type){
        $this->type = $type;
        return $this;
    }

    public function match($data){
        $this->match = $data;
        return $this;
    }

    /**
     * Notes:
     * @param $data
     * User: kuokuo@leju.com
     * "multi_match":{"query":"zhangsan","fields":{"name^3","title^2"}
     *
     */
    public function multi_match($data){
        $multi_match = $data;

        return $this;
    }

    public function term($data){

        $this->term = $data;
        return $this;
    }

    public function terms($data){
        foreach($data as $k => $value){

            $this->terms[$k] = $value;
        }


        return $this;
    }
    public function should($data){
        $this->bool['should'] = $data;
        return $this;
    }


    public function must($data){
        $this->bool['must'] = $data;
        return $this;
    }

    public function must_not($data){
        $this->bool['must_not'] = $data;
    }

    public function filter($data){

        $this->filters = ['filtered'=>["query"=> [
            "match_all"=>[]],'filter'=>['term'=>['name'=>'ykk']]]];
        return $this;
    }

    public function group($data){

        return $this;
    }
    public function from($from = 0){
        $this->from = $from;
        return $this;
    }

    public function size($size){

        $this->size = $size;
        return $this;
    }

    public function order($column, $sort = 'asc'){

        $this->sort[] = [$column=>$sort];

        return $this;
    }

    public function limit($limit){

        $this->limit = $limit;
        return $this;
    }


    public function query(){
        $query['query'] = [];

        if(!empty($this->term)){
            foreach($this->term as $k => $val){
                $query['query']['term'] = [$k=>$val];
            }
        }

        if(!empty($this->filters)){
            $query['query'] = $this->filters;
        }

        if(!empty($this->match)){
            $query['query']['match'] = $this->match;
        }
        if(!empty($this->size)){
            $query['size'] = $this->size;
            $query['from'] = ($this->from-1)*$this->size;
        }

        if(!empty($this->terms)){
            $query['query']['terms'] = $this->terms;
        }

        if(!empty($this->bool)){
            $query['query']['bool'] = $this->bool;
        }


        if(!empty($this->sort)){

            $query['sort'] = $this->sort;
        }

        if(!empty($this->source)){
            $query['_source'] = $this->source;
        }

        return $query;
    }

    public function select($data){

    }

    public function source($source = []){

        $this->source = $source;
        return $this;
    }
    public function get(){
        $url = $this->link.'/'.$this->index.'/'.$this->type.'/_search?pretty';
        $data = $this->query();

//        print_r($data);die;
        return $this->curlUtil->request($url,$data,'GET');
    }

    /**
     * Notes:
     * @param $data
     * User: kuokuo@leju.com
     * Date: ${DATE}
     * {"filter":"exists":{"field":"location.name"}}
     */
    public function exists($data){

        $this->exists = $data;
        return $this;
    }


    public function bulk($data){

    }

    public function insert($data){
        $url = $this->link.'/'.$this->index.'/'.$this->type.'/'.$data['id'];
//        print_r($data);die;
        return $this->curlUtil->request($url,$data,'PUT');
    }

    public function update($data){
        $url = $this->link.'/'.$this->index.'/'.$this->type.'/'.$data['id'].'/_update';
        $data = ["doc"=>$data];
//        print_r($data);die;
        return $this->curlUtil->request($url,$data,'POST');
    }

    /**
     * Notes:
     * @param $data
     * User: kuokuo@leju.com
     * Date: ${DATE}
     * Time: ${TIME}
     * "range":{"age":{"gt":20,"lt":20}}
     */
    public function range($data){
        $this->range = $data;//范围

        return $this;
    }

    public function delete($id){

        $url = $this->link.'/'.$this->index.'/'.$this->type.'/'.$id;
//        print_r($data);die;
        return $this->curlUtil->request($url,[],'DELETE');
    }

    public function create_index(){

    }

    public function delete_index(){

    }

    public function mapping($data){
        $this->mapping = $data;
    }
}