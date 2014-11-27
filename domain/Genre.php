<?php
	
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	include_once('../constant/Constants.php');
	include_once('../bo/GenreBO.php');
	include_once('../bo/MessageBO.php');
	include_once('../db/DBGenre.php');
	include_once('../gui/GenreGUI.php');
	include_once('../gui/GenreAlterGUI.php');

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
			//DEFAULT
			//load data
			$data = getGenres();
			//show gui
			showGenreGui($data, $message);
		}
		
	} else {
		//redirect
		header('Location: ' . URL . 'domain/LogIn.php');
		exit;
	}
?>