<?php
	function formatTime($time) {
		$retVar = '';
		
		if($time != null) {
			//get parts
			$parts = explode(':', $time);
			
			//2 parts
			if(sizeof($parts) == 2) {
				//parts are numeric
				if(is_numeric($parts[0]) && is_numeric($parts[1])) {
					//parts are max 2 digits long
					if(strlen($parts[0]) <= 2 && strlen($parts[1]) <= 2) {
						//minutes must be under 60, hours does not matter
						if(intval($parts[1]) < 60) {
							//combine to valide time
							$hours = prependZeros($parts[0], 2);
							$minutes = prependZeros($parts[1], 2);
							
							$retVar = $hours . ':' . $minutes;
						}
					}
				}
			}
		}
		
		return $retVar;
	}
	
	function prependZeros($numberString, $length) {
		$retVar = $numberString;
		
		while(strlen($retVar) < $length) {
			$retVar = '0' . $retVar;
		}
		
		return $retVar;
	}
?>