<?php

	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	function getConnection() {
		$db_user = 'guest';
		$db_pw = 'guest';
		
		if(isset($_SESSION['user_id'])) {
			$db_user = 'moderator';
			$db_pw = 'moderator';
		}
		
		$mysqli = new mysqli('localhost', $db_user, $db_pw, 'event_calendar');
		$mysqli->set_charset('utf8');
		
		return $mysqli;
	}
	
?>