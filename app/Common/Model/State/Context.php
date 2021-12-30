<?php

namespace App\Common\Model\State;



class Context{


	public $state;
	public $time;
	public function __construct(){

		$this->state = new MorningState($this);
	}

	public function setState(State $state){
		$this->state = $state;
	}
	public function work(){

		$this->state->finishTask($this);
	}
}