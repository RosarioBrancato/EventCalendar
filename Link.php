<?php

	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	
	include_once('constant/Constants.php');
	
	//session id must be set
	if(isset($_SESSION['user_id'])) {
			
		//include files
		include_once('bo/LinkBO.php');
		include_once('bo/EventBO.php');
		include_once('bo/MessageBO.php');
		include_once('model/DBLink.php');
		include_once('view/LinkAlterGUI.php');
		//to event controller
		include_once('controller/Link.php');
			
	} else {
		//redirect
		header('Location: ' . URL . 'controller/LogIn.php');
		exit;
	}

?>