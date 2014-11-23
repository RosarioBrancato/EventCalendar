<?php

	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	include_once('../constant/Constants.php');
	include_once('../bo/LogInBO.php');
	include_once('../bo/MessageBO.php');
	include_once('DBConnection.php');
	
	function logInUser($data) {
		$username = $data->getUsername();
		$password = $data->getPassword();
		$success = FALSE;
		$message = null;
		
		$connection = getConnection();
		
		$stmt = $connection->prepare('SELECT id, username, password FROM tbl_user WHERE username = ? AND password = ?');
		if($stmt !== FALSE)  {
			$stmt->bind_param('ss', $username, $password);
			$stmt->execute();
			
			$db_user_id;
			$db_username;
			$db_password;
			
			$stmt->bind_result($db_user_id, $db_username, $db_password);
			$stmt->fetch();
			
			if($username === $db_username && $password === $db_password) {
				$_SESSION['db_user'] = 'root';
				$_SESSION['user_id'] =  $db_user_id;
				$_SESSION['username'] = $db_username;
				$_SESSION['password'] = $db_password;
				$success = TRUE;
				$message = new MessageBO('Anmeldung erfolgreich! Willkommen ' . $db_username . '!', MESSAGE_TYPE_SUCCESS);
			
			} else {
				$message = new MessageBO('Anmeldung fehlgeschlagen. Nickname und/oder Passwort sind falsch!', MESSAGE_TYPE_DANGER);
			}
			
			$stmt->close();
			
		} else {
			$success = FALSE;
			$message = new MessageBO('Ein Fehler ist beim Anmelden ist aufgetreten. Versuche es erneut!', MESSAGE_TYPE_DANGER);
		}
		
		$connection->close();
		
		if(!$success) {
			session_destroy();
		}

		return $message;
	}

?>