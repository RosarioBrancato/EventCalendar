<?php
	
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	$message = null;
	
	if(isset($_SESSION['user_id'])) {
		if(isset($_POST['genre_new'])) {
			//NEW
			//show gui
			showGenreAlterGui(MODE_NEW, null, null);
			
		} else if(isset($_POST['genre_edit'])) {
			//EDIT
			//load price bracket
			$data = getGenre($_POST['id']);
			//show gui
			showGenreAlterGui(MODE_EDIT, $data, null);
			
		} else if(isset($_POST['genre_delete'])) {
			//DELETE
			//load price bracket
			$data = getGenre($_POST['id']);
			//show gui
			showGenreAlterGui(MODE_DELETE, $data, null);
			
		} else if(isset($_POST['genre_save'])) {
			//SAVE
			//get values
			$mode = intval($_POST['mode']);
			$id = intval($_POST['id']);
			$name = $_POST['name'];
			
			$isOk = true;
			$messageText = 'Einige Felder wurden inkorrekt ausgefüllt:';
			
			if(strlen($name) <= 0) {
				$isOk = false;
				$messageText .= '<br> - Das Feld "Name" wurde nicht ausgefüllt. Bitte gib einen Namen ein.';
			}
			
			if($mode == MODE_DELETE || $isOk) {
				//manipulate database
				switch($mode) {
					case MODE_NEW:
						$message = insertGenre(new GenreBO($id, $name));
						break;
						
					case MODE_EDIT:
						$message = updateGenre(new GenreBO($id, $name));
						break;
						
					case MODE_DELETE:
						$message = deleteGenre($id);
						break;
				}
				
				//load data
				$data = getGenres();
				//show gui
				showGenreGui($data, $message);
			
			} else {
				//message
				$message = new MessageBO($messageText, MESSAGE_TYPE_DANGER);
				//load price bracket
				$data = new GenreBO($id, $name);
				//show gui
				showGenreAlterGui($mode, $data, $message);
			}
			
		} else {
			//DEFAULT
			//load data
			$data = getGenres();
			//show gui
			showGenreGui($data, $message);
		}
		
	} else {
		//redirect
		header('Location: ' . URL . 'LogIn.php');
		exit;
	}
?>