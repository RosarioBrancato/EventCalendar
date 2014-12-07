<?php
	
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	
	if(isset($_POST['log_in'])) {
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
			//load event view
			loadDefaultEventView($message);
			
		} else {
			showLogInGui(new LogInBO($username, null), $message);
		}
		
		//default view
	} else if(isset($_SESSION['user_id'])) {
		//log out
		if(isset($_POST['log_out']) && (session_status() == PHP_SESSION_ACTIVE)) {
		
			//destroy session
			session_unset();
			session_destroy();
			//show login gui
			showLogInGui(null, new MessageBO('Du wurdest erfolgreich abgemeldet.', MESSAGE_TYPE_SUCCESS));
			
		} else {
			//redirect
			header('Location: ' . URL . 'Event.php');
			exit;
		}
	
		//log in
	} else {
		showLogInGui(null, null);
	}
?>