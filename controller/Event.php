<?php
	
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}
	
	$message = null;
	
	if(isset($_SESSION['user_id'])) {
	
		//get db object
		$dbEvent = new DBEvent();
		
		if(isset($_GET['e'])) {
			//load data
			$data = $dbEvent->getEvent($_GET['e']);
			//show gui
			showEventGui($data);
		
		} else if(isset($_POST['event_new'])) {
			//NEW
			//show gui
			//get genres for dropdown
			$genres = getGenres();
			if($genres != null) {
				showEventAlterGui(MODE_NEW, null, null, $genres);
			} else {
				$message = new MessageBO('Es wurden noch keine Genres erfasst! Um eine neue Veranstaltung zu erfassen, muss ein Genre vorhanden sein.', MESSAGE_TYPE_WARNING);
				//TO DEFAULT VIEW
				loadDefaultEventView($message);
			}
			
		} else if(isset($_POST['event_edit'])) {
			//EDIT
			//get genres for dropdown
			$genres = getGenres();
			//load event
			$data = $dbEvent->getEvent($_POST['id']);
			//show gui
			showEventAlterGui(MODE_EDIT, $data, null, $genres);
			
		} else if(isset($_POST['event_delete'])) {
			//DELETE
			//get genres for dropdown
			$genres = getGenres();
			//load event
			$data = $dbEvent->getEvent($_POST['id']);
			//show gui
			showEventAlterGui(MODE_DELETE, $data, null, $genres);
			
		} else if(isset($_POST['event_save'])) {
			//SAVE
			//var
			$id = 0;
			$name = '';
			$cast = '';
			$description = '';
			$duration = '00:00';
			$picture = '';
			$pictureText = '';
			$genre_id = 0;
			
			$messageText = 'Einige Felder wurden inkorrekt ausgefüllt:';
			
			//validation
			$isOk = true;
			//critical errors
			$modeError = false;
			$idError = false;
			//checking post values
			if(isset($_POST['mode'])) {
				$mode = intval($_POST['mode']);
			} else {
				$isOk = false;
				$modeError = true;
			}
			if(isset($_POST['id']) && is_numeric($_POST['id'])) {
				$id = intval($_POST['id']);
			} else {
				$isOk = false;
				$idError = true;
			}
			if(isset($_POST['name']) && strlen(trim($_POST['name'])) > 0) {
				$name = trim($_POST['name']);
			} else {
				$isOk = false;
				$messageText .= '<br> - Das Feld "Name" darf nicht leer sein.';
			}
			if(isset($_POST['cast'])) {
				$cast = trim($_POST['cast']);
			} else {
				$isOk = false;
				$messageText .= '<br> - Das Feld "Besetzung" konnte nicht ausgelesen werden. Bitte versuchen sie es erneut.';
			}
			if(isset($_POST['description']) && strlen(trim($_POST['description'])) > 0) {
				$description = trim($_POST['description']);
			} else {
				$isOk = false;
				$messageText .= '<br> - Das Feld "Beschreibung" darf nicht leer sein.';
			}
			
			if(isset($_POST['duration']) && strlen(trim($_POST['duration'])) > 0) {
				$duration = formatTime(trim($_POST['duration']));
				//if the formatTime-method returned an empty string, the time was not valid.
				if(strlen($duration) <= 0) {
					$isOk = false;
					$messageText .= '<br> - Das Feld "Länge" wurde inkorrekt ausgefüllt. Bitte geben Sie die Länge im Format HH:MM an.';
					
				} else if($mode == MODE_EDIT) {
					//if the duration does not overlap with other events the returned value is null or else it returns the list of events.
					$values = isChangeOfEventDurationPossible($id, $duration);
					if($values != null) {
						$isOk = false;
						$messageText .= '<br> - Die Dauer überschneidet sich nun mit andere Veranstaltung/en:';
						foreach($values as $row) {
							$messageText .= '<br>';
							$messageText .= '<br> --- Name:  ' . $row['event_name'];
							$messageText .= '<br> --- Datum: ' . $row['performance_date'];
							$messageText .= '<br> --- Uhrzeit: ' . $row['performance_time'];
							$messageText .= '<br> --- Akt. Dauer: ' . $row['event_duration'];
						}
					}
				}
			} else {
				$isOk = false;
				$messageText .= '<br> - Das Feld "Länge" darf nicht leer sein.';
			}
			
			
			if(isset($_POST['picture_text'])) {
				$pictureText = trim($_POST['picture_text']);
			} else {
				$isOk = false;
				$messageText .= '<br> - Das Feld "Bildbeschreibung" konnte nicht ausgelesen werden. Bitte versuchen sie es erneut.';
			}
			if(isset($_POST['genre_id']) && is_numeric($_POST['genre_id'])) {
				$genre_id = $_POST['genre_id'];
			} else {
				$isOk = false;
				$messageText .= '<br> - Das Feld "Genre" konnte nicht ausgelesen werden. Bitte versuchen sie es erneut.';
			}
			
			//get values
			//$picture = $_POST['picture'];		TO-DO: File-Upload
			
			if($isOk) {
				//manipulate database
				switch($mode) {
					case MODE_NEW:
						$message = $dbEvent->insertEvent(new EventBO($id, $name, $cast, $description, $duration, $picture, $pictureText, $genre_id));
						$inserted_id = $dbEvent->getLastUsedId();
						if($inserted_id > 0) {
							//show event
							loadEventDetailView($message, $dbEvent->getLastUsedId());
							
						} else {
							//show all events
							loadDefaultEventView($message);
						}
						break;
						
					case MODE_EDIT:
						$message = $dbEvent->updateEvent(new EventBO($id, $name, $cast, $description, $duration, $picture, $pictureText, $genre_id));
						//show event
						loadEventDetailView($message, $id);
						break;
						
					case MODE_DELETE:
						$message = $dbEvent->deleteEvent($id);
						//show all events
						loadDefaultEventView($message);
						break;
					default:
						//show all events
						loadDefaultEventView($message);
						break;
				}
			
			} else {
				if($modeError) {
					//Critical error: Post missed the mode type.
					$message = new MessageBO('Es ist beim Absenden des Formulars ein schwerer Fehler aufgetreten. Bitte versuche es erneut!', MESSAGE_TYPE_DANGER);
					//show gui
					loadDefaultEventView($message);
					
				} else if($mode == MODE_EDIT && $idError) {
					//Critical error: Post missed the id of the edited event
					$message = new MessageBO('Es ist beim Absenden des Formulars ein schwerer Fehler aufgetreten. Bitte versuche es erneut!', MESSAGE_TYPE_DANGER);
					//show gui
					loadDefaultEventView($message);
					
				} else {
					//Error: Some unimportant fields were not filled correctly. Let the user retry.
					$message = new MessageBO($messageText, MESSAGE_TYPE_DANGER);
					//reset values
					$data = new EventBO($id, $name, $cast, $description, $duration, $picture, $pictureText, $genre_id);
					//get genres for dropdown
					$genres = getGenres();
					//show gui
					showEventAlterGUI($mode, $data, $message, $genres);
				}
			}
			
		} else if(isset($_POST['event_cancel'])) {
			//message
			$message = new MessageBO('Bearbeitung abgebrochen.', MESSAGE_TYPE_INFO);
			//show gui
			loadEventDetailView($message, $_POST['id']);
			
			//show event detail view
		} else if(isset($_POST['event_detail'])) {
			//show gui
			loadEventDetailView($message, $_POST['id']);
			
		
			//if the event is called from outsinde, the default view is
			//handled from there.
		} else {
			//load data
			$data = $dbEvent->getEvents();
			//show gui
			showEventOverviewGui($data);
		}
		
	} else {
		//redirect
		header('Location: ' . URL . 'LogIn.php');
		exit;
	}
?>