<?php


namespace App\Common\Model\State;



class AfternoonState extends State{


	public function  finishTask(){

		if($this->context->time >= 9) {

			print_r("good afternoon");
		}
	}
}