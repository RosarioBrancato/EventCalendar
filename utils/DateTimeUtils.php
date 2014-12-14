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
	
	function formatDate($date) {
		$retVar = '';
		
		if($date != null) {
		
			$retVar = isDateMySQLFormat($date);
			
			if(strlen($retVar) <= 0) {
				//get parts
				$parts = explode('.', $date);
				
				//2 parts
				if(sizeof($parts) == 3) {
					//parts are numeric
					if(is_numeric($parts[0]) && is_numeric($parts[1]) && is_numeric($parts[2])) {
						//parts are max 2 digits long
						if(strlen(trim($parts[0])) <= 2 && strlen(trim($parts[1])) <= 2 && strlen(trim($parts[2])) <= 4) {
							//day must be between 1 and 31
							//month must be between 1 and 12
							//year must be over 1900
							if(intval($parts[0]) > 0 && intval($parts[0]) <= 31 
								&& intval($parts[1]) > 0 && intval($parts[1]) <= 12
								&& intval($parts[2]) > 1900 && intval($parts[2]) <= 9999) {
								//combine to valide date
								$day = prependZeros($parts[0], 2);
								$month = prependZeros($parts[1], 2);
								$year = $parts[2];
								
								$retVar = $year . '-' . $month . '-' . $day;
							}
						}
					}
				}
			}
		}
		
		return $retVar;
	}
	
	function isDateMySQLFormat($date) {
		$retVar = '';
		
		if($date != null) {
			//get parts
			$parts = explode('-', $date);
			
			//2 parts
			if(sizeof($parts) == 3) {
				//parts are numeric
				if(is_numeric($parts[0]) && is_numeric($parts[1]) && is_numeric($parts[2])) {
					//parts are max 2 digits long
					if(strlen(trim($parts[0])) <= 4 && strlen(trim($parts[1])) <= 2 && strlen(trim($parts[2])) <= 2) {
						//day must be between 1 and 31
						//month must be between 1 and 12
						//year must be over 1900
						if(intval($parts[2]) > 0 && intval($parts[2]) <= 31 
							&& intval($parts[1]) > 0 && intval($parts[1]) <= 12
							&& intval($parts[0]) > 1900 && intval($parts[0]) <= 9999) {
							
							//date is correct
							$retVar = $date;
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