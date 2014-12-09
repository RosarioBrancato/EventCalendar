<?php
	
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	
	$message = null;
	
	if(isset($_SESSION['user_id'])) {
		if(isset($_POST['performance_new'])) {
			//NEW
			//event bo
			$event = new EventBO(intval($_POST['event_id']), $_POST['event_name'], null, null, null, null, null, null);
			//show gui
			showPerformanceAlterGui(MODE_NEW, null, null, $event);
			
		} else if(isset($_POST['performance_edit'])) {
			//EDIT
			//event bo
			$event = new EventBO(intval($_POST['event_id']), $_POST['event_name'], null, null, null, null, null, null);
			//load performance
			$data = getPerformance($_POST['performance_id']);
			//show gui
			showPerformanceAlterGui(MODE_EDIT, $data, null, $event);
			
		} else if(isset($_POST['performance_delete'])) {
			//DELETE
			//event bo
			$event = new EventBO(intval($_POST['event_id']), $_POST['event_name'], null, null, null, null, null, null);
			//load performance
			$data = getPerformance($_POST['performance_id']);
			//show gui
			showPerformanceAlterGui(MODE_DELETE, $data, null, $event);
			
		} else if(isset($_POST['performance_save'])) {
			//SAVE
			//var
			$id = 0;
			$date = '0000-00-00';
			$time = '00:00';
			$event_id = 0;
			
			$isOk = TRUE;
			$messageText = 'Einige Felder wurden inkorrekt ausgefüllt:';
			
			//get values
			$mode = intval($_POST['mode']);
			$id = intval($_POST['performance_id']);
			$date = formatDate(trim($_POST['performance_date']));
			$time = formatTime(trim($_POST['performance_time']));
			$event_id = intval($_POST['event_id']);
			$event_name = $_POST['event_name'];
			
			//TO-DO: Validation
			if(isset($_POST['performance_date']) && strlen(trim($_POST['performance_date'])) > 0) {
				$date = formatDate(trim($_POST['performance_date']));
				//if the formatTime-method returned an empty string, the time was not valid.
				if(strlen($date) <= 0) {
					$isOk = false;
					$messageText .= '<br> - Das Feld "Datum" wurde inkorrekt ausgefüllt. Bitte geben Sie das Datum im Format DD.MM.YYYY an.';
				}
			}
			if(isset($_POST['performance_time']) && strlen(trim($_POST['performance_time'])) > 0) {
				$time = formatTime(trim($_POST['performance_time']));
				//if the formatTime-method returned an empty string, the time was not valid.
				if(strlen($time) <= 0) {
					$isOk = false;
					$messageText .= '<br> - Das Feld "Uhrzeit" wurde inkorrekt ausgefüllt. Bitte geben Sie die Uhrzeit im Format HH:MM an.';
				}
			}
		
			if($isOk) {
				//manipulate database
				switch($mode) {
					case MODE_NEW:
						$message = insertPerformance(new PerformanceBO($id, $date, $time, $event_id));
						break;
						
					case MODE_EDIT:
						$message = updatePerformance(new PerformanceBO($id, $date, $time, $event_id));
						break;
						
					case MODE_DELETE:
						$message = deletePerformance($id);
						break;
				}
				
				//show events
				loadEventDetailView($message, $event_id);
			
			} else {
				//message
				$message = new MessageBO($messageText, MESSAGE_TYPE_DANGER);
				//event bo
				$event = new EventBO($event_id, $event_name, null, null, null, null, null, null);
				//load performance
				$data = new PerformanceBO($id, $date, $time, $event_id);
				//show gui
				showPerformanceAlterGui($mode, $data, $message, $event);
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