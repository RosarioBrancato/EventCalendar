<?php
	
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	
	include_once('../constant/Constants.php');
	include_once('../bo/MessageBO.php');
	include_once('../gui/OverviewGUI.php');
	
	if(isset($_SESSION['user_id'])) {
		//show gui
		showOverviewGUI(null);
	
	} else {
		//redirect
		header('Location: ' . URL . 'domain/LogIn.php');
		exit;
	}
	
?>