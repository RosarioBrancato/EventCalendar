<?php

	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	
	include_once('constant/Constants.php');
	
	//session id must be set
	if(isset($_SESSION['user_id'])) {
			
		//include files
		include_once('bo/PriceBracketBO.php');
		include_once('bo/MessageBO.php');
		include_once('model/DBPriceBracket.php');
		include_once('view/PriceBracketGUI.php');
		include_once('view/PriceBracketAlterGUI.php');
		//to event controller
		include_once('controller/PriceBracket.php');
			
	} else {
		//redirect
		header('Location: ' . URL . 'controller/LogIn.php');
		exit;
	}
	
	?>