<?php
	
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	include_once('../constant/Constants.php');
	include_once('../bo/PriceBracketBO.php');
	include_once('../bo/MessageBO.php');
	include_once('../db/DBPriceBracket.php');
	include_once('../gui/PriceBracketGUI.php');

	$message = null;
	
	if(isset($_SESSION['user_id'])) {
		if(isset($_POST['price_bracket_save'])) {
			$message = new MessageBO('Preisgruppe wurde gespeichert!', MESSAGE_TYPE_SUCCESS);
			
		} else if(isset($_POST['price_bracket_delete'])) {
			$message = new MessageBO('Preisgruppe wurde gelöscht!', MESSAGE_TYPE_WARNING);
		} 
		
		//load data
		$data = getPriceBrackets();
		//show gui
		showPriceBracketGui($data, $message);
		
	} else {
		//redirect
		header('Location: ' . URL . 'domain/LogIn.php');
		exit;
	}
?>