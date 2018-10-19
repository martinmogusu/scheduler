<?php

class Pool{

	public function __construct($start_time = null, $end_time = null){
		$this->start_time = $start_time;
		$this->end_time = $end_time;
	}

	public $start_time;
	public $end_time;
}

?>