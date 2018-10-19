<?php

class User{

	public function __construct($username = null, $email = null, $telephone = null, $password = null, $userlevel = null, $status = null, $expire = null){
		$this->username = $username;
		$this->email = $email;
		$this->telephone = $telephone;
		$this->password = $password;
		$this->userlevel = $userlevel;
		$this->status = $status;
		$this->expire = $expire;
	}
	
	public $username;
	public $email;
	public $telephone;
	public $password;
	public $userlevel;
	public $status;
	public $expire;
}

?>