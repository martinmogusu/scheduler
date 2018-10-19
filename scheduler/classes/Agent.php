<?php

class Agent{

	public function __construct($username = null, $fullname = null, $phone = null, $email = null){
		$this->username = $username;
		$this->fullname = $fullname;
		$this->phone = $phone;
		$this->email = $email;
	}
	public $username;
	public $fullname;
	public $phone;
	public $email;
}

?>