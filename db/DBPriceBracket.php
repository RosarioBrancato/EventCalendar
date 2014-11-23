<?php

	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	function getPriceBrackets() {
		$values = array();
		$values[] = new PriceBracketBO(1, 'Students', 5.5);
		$values[] = new PriceBracketBO(2, 'Adults', 11);
		
		return $values;
	}
	
	function getPriceBracket() {
		return new PriceBracketBO(1, 'Students', 5.5);
	}
?>