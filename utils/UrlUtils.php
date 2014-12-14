<?php

function IsUrlValid($url) {
	$retVar = false;

	if($url != null) {
		//the @ suppresses the warning to the user if the url is not valid
		$array = @get_headers($url);
		$response = $array[0];
		if(strpos($response, '200')) {
			$retVar = true;
		}
	}

	return $retVar;
}

?>