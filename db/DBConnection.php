<?php

	function getConnection() {
		$db_user = 'root';
		$db_pw = '';
		
		$mysqli = new mysqli('localhost', $db_user, $db_pw, 'event_calendar');
		$mysqli->set_charset('utf8');
		
		return $mysqli;
	}
	
?>