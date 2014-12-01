<?php
	
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	
	include_once('../constant/Constants.php');
	include_once('../bo/MessageBO.php');
	include_once('../gui/LogInGUI.php');
	
	if(isset($_POST['log_out']) && (session_status() == PHP_SESSION_ACTIVE)) {
		//destroy session
		session_unset();
		session_destroy();
		//show login gui
		showLogInGui(null, new MessageBO('Du wurdest erfolgreich abgemeldet.', MESSAGE_TYPE_SUCCESS));
		
	} else {
		//redirect
		header('Location: ' . URL . 'domain/LogIn.php');
	}
	exit;
	
?>