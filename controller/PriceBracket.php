<?php
	
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	$message = null;
	
	if(isset($_SESSION['user_id'])) {
		if(isset($_POST['price_bracket_new'])) {
			//NEW
			//show gui
			showPriceBracketAlterGui(MODE_NEW, null, null);
			
		} else if(isset($_POST['price_bracket_edit'])) {
			//EDIT
			//load price bracket
			$data = getPriceBracket($_POST['id']);
			//show gui
			showPriceBracketAlterGui(MODE_EDIT, $data, null);
			
		} else if(isset($_POST['price_bracket_delete'])) {
			//DELETE
			//load price bracket
			$data = getPriceBracket($_POST['id']);
			//show gui
			showPriceBracketAlterGui(MODE_DELETE, $data, null);
			
		} else if(isset($_POST['price_bracket_save'])) {
			//SAVE
			//get values
			$mode = intval($_POST['mode']);
			$id = intval($_POST['id']);
			$name = $_POST['name'];
			$price = floatval($_POST['price']);
			
			
			$isOk = TRUE;
			$messageText = 'Einige Felder wurden inkorrekt ausgefüllt:';
			
			if(strlen($name) <= 0) {
				$isOk = false;
				$messageText .= '<br> - Das Feld "Name" wurde nicht ausgefüllt. Bitte gib einen Namen ein.';
			}
			
			if($price < 0) {
				$isOk = false;
				$messageText .= '<br> - Das Feld "Preis" wurde nicht korrekt ausgefüllt. Bitte gib einen positiven Preis ein.';
			}
			
			if($mode == MODE_DELETE || $isOk) {
				//manipulate database
				switch($mode) {
					case MODE_NEW:
						$message = insertPriceBracket(new PriceBracketBO($id, $name, $price));
						break;
						
					case MODE_EDIT:
						$message = updatePriceBracket(new PriceBracketBO($id, $name, $price));
						break;
						
					case MODE_DELETE:
						$message = deletePriceBracket($id);
						break;
				}
				
				//load data
				$data = getPriceBrackets();
				//show gui
				showPriceBracketGui($data, $message);
				
			} else {
				//message
				$message = new MessageBO($messageText, MESSAGE_TYPE_DANGER);
				//load price bracket
				$data = new PriceBracketBO($id, $name, $price);
				//show gui
				showPriceBracketAlterGui($mode, $data, $message);
			}
			
		} else {
			//DEFAULT
			//load data
			$data = getPriceBrackets();
			//show gui
			showPriceBracketGui($data, $message);
		}
		
	} else {
		//redirect
		header('Location: ' . URL . 'LogIn.php');
		exit;
	}
?>