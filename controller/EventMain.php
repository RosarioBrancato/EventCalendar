<?php
	
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	include_once('constant/Constants.php');
	include_once('utils/DateTimeUtils.php');
	include_once('bo/EventBO.php');
	include_once('bo/GenreBO.php');
	include_once('bo/LinkBO.php');
	include_once('bo/PerformanceBO.php');
	include_once('bo/PriceBracketBO.php');
	include_once('bo/MessageBO.php');
	include_once('model/DBEvent.php');
	include_once('model/DBGenre.php');
	include_once('view/EventOverviewGUI.php');
	include_once('view/EventDetailGUI.php');
	include_once('view/EventAlterGUI.php');
	
	function loadDefaultEventView($message) {
		//save message in session
		if($message != null) {
			$_SESSION['message_text'] = $message->getText();
			$_SESSION['message_type'] = $message->getType();
		}
		//redirect to override posts
		header('Location: ' . URL . 'Event.php');
	}
	
	function loadEventDetailView($message, $event_id) {
		//save message in session
		if($message != null) {
			$_SESSION['message_text'] = $message->getText();
			$_SESSION['message_type'] = $message->getType();
		}
		//redirect to override posts
		header('Location: ' . URL . 'Event.php?e=' . $event_id);
	}
	
?>