<?php
	
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	include_once('EventMain.php');

	$message = null;
	
	if(isset($_SESSION['user_id'])) {
		if(isset($_POST['event_price_new'])) {
			//NEW
			//values
			$event_id = intval($_POST['event_id']);
			$event_name = $_POST['event_name'];
			
			if(arePriceBracketsAvaible()) {
				//event bo
				$event = new EventBO($event_id, $event_name, null, null, null, null, null, null);
				//all price brackets
				$priceBrackets = getPriceBrackets();
				//show gui
				showEventPriceAlterGui(MODE_NEW, $priceBrackets, null, $event, 0);
			
			} else {
				//redirect to event detail
				$message = new MessageBO('Es wurden noch keine Preisgruppen erfasst! Um eine Preisgruppe zu zuteilen, muss eine Preisgruppe vorhanden sein.', MESSAGE_TYPE_WARNING);
				loadEventDetailView($message, $event_id);
			}
			
		} else if(isset($_POST['event_price_edit'])) {
			//EDIT
			//values
			$event_id = intval($_POST['event_id']);
			$event_name = $_POST['event_name'];
			$price_bracket_id = intval($_POST['price_bracket_id']);
			
			//event bo
			$event = new EventBO($event_id, $event_name, null, null, null, null, null, null);
			//all price brackets
			$priceBrackets = getPriceBrackets();
			//show gui
			showEventPriceAlterGui(MODE_EDIT, $priceBrackets, null, $event, $price_bracket_id);
			
		} else if(isset($_POST['event_price_delete'])) {
			//DELETE
			//values
			$event_id = intval($_POST['event_id']);
			$event_name = $_POST['event_name'];
			$price_bracket_id = intval($_POST['price_bracket_id']);
			
			//event bo
			$event = new EventBO($event_id, $event_name, null, null, null, null, null, null);
			//all price brackets
			$priceBrackets = getPriceBrackets();
			//show gui
			showEventPriceAlterGui(MODE_DELETE, $priceBrackets, null, $event, $price_bracket_id);
			
		} else if(isset($_POST['event_price_save'])) {
			//SAVE
			//get values
			//values
			$mode = intval($_POST['mode']);
			$event_id = intval($_POST['event_id']);
			$event_name = $_POST['event_name'];
			$price_bracket_id = intval($_POST['price_bracket_id']);
			$price_bracket_id_old = intval($_POST['price_bracket_id_old']);
		
			//manipulate database
			switch($mode) {
				case MODE_NEW:
					$message = insertEventPrice($event_id, $price_bracket_id);
					break;
					
				case MODE_EDIT:
					$message = updateEventPrice($event_id, $price_bracket_id_old, $price_bracket_id);
					break;
					
				case MODE_DELETE:
					$message = deleteEventPrice($event_id, $price_bracket_id);
					break;
			}
			
			if($message->getType() === MESSAGE_TYPE_SUCCESS) {
				//show event
				loadEventDetailView($message, $event_id);
				
				//error
			} else {
				//event bo
				$event = new EventBO($event_id, $event_name, null, null, null, null, null, null);
				//all price brackets
				$priceBrackets = getPriceBrackets();
				//show gui
				showEventPriceAlterGui($mode, $priceBrackets, $message, $event, $price_bracket_id_old);
			}
			
		} else {
			//DEFAULT
			//show events
			loadDefaultEventView($message);
		}
		
	} else {
		//redirect
		header('Location: ' . URL . 'LogIn.php');
		exit;
	}
?>