<?php
	
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	include_once('../constant/Constants.php');
	include_once('../bo/PriceBracketBO.php');
	include_once('../bo/MessageBO.php');
	include_once('../db/DBPriceBracket.php');
	include_once('../gui/PriceBracketGUI.php');
	include_once('../gui/PriceBracketAlterGUI.php');

	$message = null;
	
	if(isset($_SESSION['user_id'])) {
		if(isset($_POST['price_bracket_new'])) {
			//NEW
			//show gui
			showPriceBracketAlterGui(MODUS_NEW, null, null);
			
		} else if(isset($_POST['price_bracket_edit'])) {
			//EDIT
			//load price bracket
			$data = getPriceBracket($_POST['id']);
			//show gui
			showPriceBracketAlterGui(MODUS_EDIT, $data, null);
			
		} else if(isset($_POST['price_bracket_delete'])) {
			//DELETE
			//load price bracket
			$data = getPriceBracket($_POST['id']);
			//show gui
			showPriceBracketAlterGui(MODUS_DELETE, $data, null);
			
		} else if(isset($_POST['price_bracket_save'])) {
			//SAVE
			//message
			$message = new MessageBO('Preisgruppe gespeichert!', MESSAGE_TYPE_SUCCESS);
			//load data
			$data = getPriceBrackets();
			//show gui
			showPriceBracketGui($data, $message);
			
		} else if(isset($_POST['price_bracket_cancel'])) {
			//CANCEL
			//message
			$message = new MessageBO('Bearbeitung abgebrochen.', MESSAGE_TYPE_INFO);
			//load data
			$data = getPriceBrackets();
			//show gui
			showPriceBracketGui($data, $message);
			
		} else {
			//DEFAULT
			//load data
			$data = getPriceBrackets();
			//show gui
			showPriceBracketGui($data, $message);
		}
		
	} else {
		//redirect
		header('Location: ' . URL . 'domain/LogIn.php');
		exit;
	}
?>