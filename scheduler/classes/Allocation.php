<?php

class Allocation{

	public function __construct($request_id = null, $pool_id = null, $allocation_time = null, $closing_time = null, $status = null){
		$this->request_id = $request_id;
		$this->pool_id = $pool_id;
		$this->allocation_time = $allocation_time;
		$this->closing_time = $closing_time;
		$this->status = $status;
	}

	public $request_id;
	public $pool_id;
	public $allocation_time;
	public $closing_time;
	public $status;
}

?>