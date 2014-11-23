<?php

	include_once('../constant/Constants.php');
	
	class LogInBO {
	
		private $username = '';
		private $password = '';
	
		public function __construct($username, $password) {
			$this->username = $username;
			
			if($password != null) {
				$this->password = md5($password);
			} else {
				$this->password = '';
			}
		}
		
		public function getUsername() {
			return $this->username;
		}
		
		public function getPassword() {
			return $this->password;
		}
	
	}
	
?>