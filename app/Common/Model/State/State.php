<?php


namespace App\Common\Model\State;


abstract class State {

	protected $contect;
	public function __construct(Context $context){
		$this->context = $context;
	}

	abstract public function finishTask();
}