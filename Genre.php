<?php

	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	
	include_once('constant/Constants.php');
	
	//session id must be set
	if(isset($_SESSION['user_id'])) {
			
		//include files
		include_once('utils/DateTimeUtils.php');
		include_once('bo/GenreBO.php');
		include_once('bo/MessageBO.php');
		include_once('model/DBGenre.php');
		include_once('view/GenreGUI.php');
		include_once('view/GenreAlterGUI.php');
		//to event controller
		include_once('controller/Genre.php');
			
	} else {
		//redirect
		header('Location: ' . URL . 'controller/LogIn.php');
		exit;
	}
	
?>