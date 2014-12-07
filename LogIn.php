<?php

	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	
	include_once('constant/Constants.php');
	
	//include files
	include_once('bo/LogInBO.php');
	include_once('bo/MessageBO.php');
	include_once('model/DBLogIn.php');
	include_once('view/LogInGUI.php');
	include_once('controller/EventMain.php');
	//to login controller
	include_once('controller/LogIn.php');
		
?>