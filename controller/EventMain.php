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
	include_once('view/EventGUI.php');
	include_once('view/EventGUI_2.php');
	include_once('view/EventAlterGUI.php');
	
	function loadDefaultEventView($message) {
		//load data
		$data = getEvents();
		//show gui
		showEventOverviewGui($data, $message);
	}
	
	function loadEventDetailView($message, $event_id) {
		//load data
		$data = getEvent($event_id);
		//show gui
		showEventGui($data, $message);
	}
	
?>