<?php
	
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	include_once('../constant/Constants.php');
	include_once('../bo/EventBO.php');
	include_once('../bo/MessageBO.php');
	include_once('../db/DBEvent.php');
	include_once('../db/DBGenre.php');
	include_once('../gui/EventGUI.php');
	include_once('../gui/EventAlterGUI.php');

	$message = null;
	
	if(isset($_SESSION['user_id'])) {
		if(isset($_POST['event_new'])) {
			//NEW
			//get genres for dropdown
			$genres = getGenres();
			//show gui
			if($genres != null) {
				showEventAlterGui(MODE_NEW, null, null, $genres);
			} else {
				$message = new MessageBO('Es wurden noch keine Genres erfasst! Um eine neue Veranstaltung zu erfassen, muss ein Genre vorhanden sein.', MESSAGE_TYPE_WARNING);
				//TO DEFAULT VIEW
				//load data
				$data = getEvents();
				//show gui
				showEventGui($data, $message);
			}
			
		} else if(isset($_POST['event_edit'])) {
			//EDIT
			//get genres for dropdown
			$genres = getGenres();
			//load price bracket
			$data = getEvent($_POST['id']);
			//show gui
			showEventAlterGui(MODE_EDIT, $data, null, $genres);
			
		} else if(isset($_POST['event_delete'])) {
			//DELETE
			//get genres for dropdown
			$genres = getGenres();
			//load price bracket
			$data = getEvent($_POST['id']);
			//show gui
			showEventAlterGui(MODE_DELETE, $data, null, $genres);
			
		} else if(isset($_POST['event_save'])) {
			//SAVE
			//get values
			$mode = intval($_POST['mode']);
			$id = intval($_POST['id']);
			$name = $_POST['name'];
			$cast = $_POST['cast'];
			$description = $_POST['description'];
			$duration = $_POST['duration'];
			//$picture = $_POST['picture'];		TO-DO: File-Upload
			$picture = '';
			$pictureText = $_POST['picture_text'];
			$genre_id = intval($_POST['genre_id']);
		
			//manipulate database
			switch($mode) {
				case MODE_NEW:
					$message = insertEvent(new EventBO($id, $name, $cast, $description, $duration, $picture, $pictureText, $genre_id));
					break;
					
				case MODE_EDIT:
					$message = updateEvent(new EventBO($id, $name, $cast, $description, $duration, $picture, $pictureText, $genre_id));
					break;
					
				case MODE_DELETE:
					$message = deleteEvent($id);
					break;
			}
			
			//load data
			$data = getEvents();
			//show gui
			showEventGui($data, $message);
			
		} else {
			//DEFAULT
			//load data
			$data = getEvents();
			//show gui
			showEventGui($data, $message);
		}
		
	} else {
		//redirect
		header('Location: ' . URL . 'domain/LogIn.php');
		exit;
	}
?>