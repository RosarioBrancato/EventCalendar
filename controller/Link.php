<?php
	
	if (session_status() == PHP_SESSION_NONE) {
		session_start();
	}

	include_once('EventMain.php');

	$message = null;
	
	if(isset($_SESSION['user_id'])) {
		if(isset($_POST['link_new'])) {
			//NEW
			//event bo
			$event = new EventBO(intval($_POST['event_id']), $_POST['event_name'], null, null, null, null, null, null);
			//show gui
			showLinkAlterGui(MODE_NEW, null, null, $event);
			
		} else if(isset($_POST['link_edit'])) {
			//EDIT
			//event bo
			$event = new EventBO(intval($_POST['event_id']), $_POST['event_name'], null, null, null, null, null, null);
			//load link
			$data = getLink($_POST['link_id']);
			//show gui
			showLinkAlterGui(MODE_EDIT, $data, null, $event);
			
		} else if(isset($_POST['link_delete'])) {
			//DELETE
			//event bo
			$event = new EventBO(intval($_POST['event_id']), $_POST['event_name'], null, null, null, null, null, null);
			//load link
			$data = getLink($_POST['link_id']);
			//show gui
			showLinkAlterGui(MODE_DELETE, $data, null, $event);
			
		} else if(isset($_POST['link_save'])) {
			//SAVE
			//get values
			$mode = intval($_POST['mode']);
			$id = intval($_POST['link_id']);
			$name = $_POST['link_name'];
			$link = $_POST['link_link'];
			$event_id = intval($_POST['event_id']);
		
			//manipulate database
			switch($mode) {
				case MODE_NEW:
					$message = insertLink(new LinkBO($id, $name, $link, $event_id));
					break;
					
				case MODE_EDIT:
					$message = updateLink(new LinkBO($id, $name, $link, $event_id));
					break;
					
				case MODE_DELETE:
					$message = deleteLink($id);
					break;
			}
			
			//show event
			loadEventDetailView($message, $event_id);
			
		} else {
			//DEFAULT
			//show events
			loadDefaultEventView($message);
		}
		
	} else {
		//redirect
		header('Location: ' . URL . 'LogIn.php');
		exit;
	}
?>