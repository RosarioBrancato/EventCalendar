<?php
	
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	include_once('../constant/Constants.php');
	include_once('../utils/DateTimeUtils.php');
	include_once('../bo/EventBO.php');
	include_once('../bo/MessageBO.php');
	include_once('../db/DBEvent.php');
	include_once('../db/DBGenre.php');
	include_once('../gui/EventGUI_2.php');
	include_once('../gui/EventAlterGUI.php');
	
	function loadDefaultEventView($message) {
		//load data
		$data = getEvents();
		//show gui
		showEventGui($data, $message);
	}
	
?>