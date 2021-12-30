<?php

namespace App\Common\Model\State;

class MorningState extends State{


	public function finishTask(){

		if($this->context->time < 9){

			print_r("good morning");
		} else {

			$this->context->setState(new AfternoonState($this->context));
			$this->context->work();
		}
	}
}