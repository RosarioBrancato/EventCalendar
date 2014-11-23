<?php
	
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	
	include_once('../constant/Constants.php');
	include_once('../bo/LogInBO.php');
	include_once('../bo/MessageBO.php');
	include_once('../db/DBLogIn.php');
	include_once('../gui/LogInGUI.php');
	
	if(isset($_SESSION['user_id'])) {
		//redirect
		header('Location: ' . URL . 'domain/Overview.php');
		exit;
	
	} else if(isset($_POST['log_in'])) {
		$username = $_POST['username'];
		$password = $_POST['password'];
		$message = null;
		
		if($username == null || strlen($username) <= 0) {
			$message = new MessageBO('Das Feld "Benutzername" muss ausgefüllt werden.', MESSAGE_TYPE_DANGER);
			
		} else if($password == null || strlen($password) <= 0) {
			$message = new MessageBO('Das Feld "Passwort" muss ausgefüllt werden.', MESSAGE_TYPE_DANGER);
			
		} else {
			$message = logInUser(new LogInBO($username, $password));
		}
		
		if($message->getType() === MESSAGE_TYPE_SUCCESS) {
			header('Location: ' . URL . 'domain/Overview.php');
			exit;
			
		} else {
			showLogInGui(new LogInBO($username, null), $message);
		}
		
	} else {
		showLogInGui(null, null);
	}
?>