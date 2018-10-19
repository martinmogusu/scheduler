<?php

class Request{

	public function __construct($crq = null, $user_id = null, $title = null, $time_created = null, $estimated_duration = null, $status = null){
		$this->crq = $crq;
		$this->user_id = $user_id;
		$this->title = $title;
		$this->time_created = $time_created;
		$this->estimated_duration = $estimated_duration;
		$this->status = $status;

	}

	public $crq;
	public $user_id;
	public $title;
	public $time_created;
	public $estimated_duration;
	public $status;
}

?>