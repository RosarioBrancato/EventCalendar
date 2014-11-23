<?php
	
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	
	include_once('../constant/Constants.php');
	
	if(isset($_POST['log_out']) && (session_status() == PHP_SESSION_ACTIVE)) {
		session_destroy();
	}
	
	//redirect
	header('Location: ' . URL . 'domain/LogIn.php');
	exit;
	
?>