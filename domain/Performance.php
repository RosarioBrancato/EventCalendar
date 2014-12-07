<?php
	
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	include_once('../constant/Constants.php');
	include_once('../utils/DateTimeUtils.php');
	include_once('../bo/PerformanceBO.php');
	include_once('../bo/EventBO.php');
	include_once('../bo/MessageBO.php');
	include_once('../db/DBPerformance.php');
	include_once('../gui/PerformanceAlterGUI.php');

	include_once('EventMain.php');
	
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
			
			$messageText = 'Einige Felder wurden inkorrekt ausgefüllt:';
			
			//get values
			$mode = intval($_POST['mode']);
			$id = intval($_POST['performance_id']);
			$date = formatDate(trim($_POST['performance_date']));
			$time = formatTime(trim($_POST['performance_time']));
			$event_id = intval($_POST['event_id']);
			
			//TO-DO: Validation
		
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
			loadDefaultEventView($message);
			
		} else {
			//DEFAULT
			//show events
			loadDefaultEventView($message);
		}
		
	} else {
		//redirect
		header('Location: ' . URL . 'domain/LogIn.php');
		exit;
	}
?>