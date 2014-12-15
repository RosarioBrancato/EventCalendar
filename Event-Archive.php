<?php

	include_once('constant/Constants.php');
	
	//redirect to clean the url
	if(isset($_GET['genre_change']) && isset($_GET['genre_id'])) {
		if(is_numeric($_GET['genre_id']) && intval($_GET['genre_id']) > 0) {
			header('Location: ' . URL . 'Event-Archive.php?genre=' . $_GET['genre_id']);
		} else {
			header('Location: ' . URL . 'Event-Archive.php');
		}
	} 
	
	//include files
	include_once('utils/DateTimeUtils.php');
	include_once('bo/EventBO.php');
	include_once('bo/GenreBO.php');
	include_once('bo/LinkBO.php');
	include_once('bo/PerformanceBO.php');
	include_once('bo/PriceBracketBO.php');
	include_once('bo/MessageBO.php');
	include_once('model/DBEvent.php');
	include_once('model/DBGenre.php');
	include_once('model/DBPerformance.php');
	include_once('view/EventArchiveGUI.php');
	//to event controller
	include_once('controller/EventArchive.php');
	
?>