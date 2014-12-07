<?php
	
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	
	include_once('constant/Constants.php');
	
	//login posts
	if(isset($_POST['log_in'])) {
	
		//to login access point
		include_once('LogIn.php');
	
	
	//session id must be set
	} else if(isset($_SESSION['user_id'])) {
	
			//performance posts
		if (isset($_POST['performance_save'])) {
			
			//to performance access point
			include_once('Performance.php');
			
			
			//link posts
		} else if(isset($_POST['link_save'])) {
			
			//to link access point
			include_once('Link.php');
			
			
			//event price posts
		} else if(isset($_POST['event_price_save'])) {
			
			//include file
			//include_once('controller/Event.php');
			
			
		//event posts
		} else {
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
			include_once('view/EventGUI_2.php');
			include_once('view/EventAlterGUI.php');
			//to event controller
			include_once('controller/Event.php');
		}
		
	} else {
		//redirect
		header('Location: ' . URL . 'LogIn.php');
		exit;
	}
?>