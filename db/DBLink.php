<?php

	include_once('../constant/Constants.php');
	include_once('../bo/LinkBO.php');
	include_once('../bo/MessageBO.php');
	include_once('DBConnection.php');
	
	function getLink($id) {
		$bo = null;
		
		$connection = getConnection();
		
		$stmt = $connection->prepare('SELECT id, name, link, event_id FROM tbl_link WHERE id = ?');
		if($stmt !== FALSE) {
			$stmt->bind_param('i', $id);
			$stmt->execute();
			
			$id;
			$name;
			$link;
			$event_id;
			
			$stmt->bind_result($id, $name, $link, $event_id);
			
			while($stmt->fetch()) {
				$bo = new LinkBO($id, $name, $link, $event_id);
			}
			
			$stmt->close();
		}
		
		$connection->close();
		
		return $bo;	
	}
	
	function insertLink($bo) {
		if($bo == null || $bo->getId() > 0) {
			return new MessageBO('Beim Speichern ist ein Fehler aufgetreten. Bitte versuche es erneut.', MESSAGE_TYPE_DANGER);
		}
		
		$message = null;
		$success = FALSE;
		
		$connection = getConnection();
		
		$stmt = $connection->prepare('INSERT INTO tbl_link (name, link, event_id) VALUES ( ?, ?, ?)');
		if($stmt !== FALSE) {
			$stmt->bind_param('ssi', $bo->getName(), $bo->getLink(), $bo->getEventId());
			$success = $stmt->execute();
			if($success) {
				$message = new MessageBO('Der Link wurde erfolgreich gespeichert!', MESSAGE_TYPE_SUCCESS);
			}
			$stmt->close();
		} else {
			$message = new MessageBO('Beim Speichern ist ein Fehler aufgetreten. Bitte versuche es erneut.', MESSAGE_TYPE_DANGER);
		}
		
		$connection->close();
		
		return $message;	
	}
	
	function updateLink($bo) {
		if($bo == null || $bo->getId() <= 0) {
			return new MessageBO('Beim Speichern ist ein Fehler aufgetreten. Bitte versuche es erneut.', MESSAGE_TYPE_DANGER);
		}
		
		$message = null;
		$success = FALSE;
		
		$connection = getConnection();
		
		$stmt = $connection->prepare('UPDATE tbl_link SET name = ?, link = ? WHERE id = ?');
		if($stmt !== FALSE) {
			$stmt->bind_param('ssi', $bo->getName(), $bo->getLink(), $bo->getId());
			$success = $stmt->execute();
			if($success) {
				$message = new MessageBO('Der Link wurde erfolgreich gespeichert!', MESSAGE_TYPE_SUCCESS);
			}
			$stmt->close();
		} else {
			$message = new MessageBO('Beim Speichern ist ein Fehler aufgetreten. Bitte versuche es erneut.', MESSAGE_TYPE_DANGER);
		}
		
		$connection->close();
		
		return $message;	
	}
	
	function deleteLink($id) {
		$message = null;
		$success = FALSE;
		
		//is id invalid
		if($id <= 0) {
			return new MessageBO('Beim Löschen ist ein Fehler aufgetreten. Bitte versuche es erneut.', MESSAGE_TYPE_DANGER);
		}
		
		$connection = getConnection();
		
		$stmt = $connection->prepare('DELETE FROM tbl_link WHERE id = ?');
		if($stmt !== FALSE) {
			$stmt->bind_param('i', $id);
			$success = $stmt->execute();
			if($success) {
				$message = new MessageBO('Der Link wurde erfolgreich gelöscht!', MESSAGE_TYPE_SUCCESS);
			}
			$stmt->close();
		} else {
			$message = new MessageBO('Beim Löschen ist ein Fehler aufgetreten. Bitte versuche es erneut.', MESSAGE_TYPE_DANGER);
		}
		
		$connection->close();
		
		return $message;	
	}
	
?>