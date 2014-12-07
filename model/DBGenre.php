<?php

	include_once('DBConnection.php');

	function getGenres() {
		$values = array();
		
		$connection = getConnection();
		
		$stmt = $connection->prepare('SELECT id, name FROM tbl_genre ORDER BY name');
		if($stmt !== FALSE) {
			$stmt->execute();
			
			$id;
			$name;
			
			$stmt->bind_result($id, $name);
			
			while($stmt->fetch()) {
				$values[$id] = new GenreBO($id, $name);
			}
			
			$stmt->close();
		
		}
		
		$connection->close();
		
		return $values;
	}
	
	function getGenre($id) {
		$bo = null;
		
		$connection = getConnection();
		
		$stmt = $connection->prepare('SELECT id, name FROM tbl_genre WHERE id = ?');
		if($stmt !== FALSE) {
			$stmt->bind_param('i', $id);
			$stmt->execute();
			
			$id;
			$name;
			
			$stmt->bind_result($id, $name);
			
			while($stmt->fetch()) {
				$bo = new GenreBO($id, $name);
			}
			
			$stmt->close();
		}
		
		$connection->close();
		
		return $bo;	
	}
	
	function insertGenre($bo) {
		if($bo == null || $bo->getId() > 0) {
			return new MessageBO('Beim Speichern ist ein Fehler aufgetreten. Bitte versuche es erneut.', MESSAGE_TYPE_DANGER);
		}
		
		$message = null;
		$success = FALSE;
		
		$connection = getConnection();
		
		$stmt = $connection->prepare('INSERT INTO tbl_genre (name) VALUES (?)');
		if($stmt !== FALSE) {
			$stmt->bind_param('s', $bo->getName());
			$success = $stmt->execute();
			if($success) {
				$message = new MessageBO('Das Genre wurde erfolgreich gespeichert!', MESSAGE_TYPE_SUCCESS);
			}
			$stmt->close();
		} else {
			$message = new MessageBO('Beim Speichern ist ein Fehler aufgetreten. Bitte versuche es erneut.', MESSAGE_TYPE_DANGER);
		}
		
		$connection->close();
		
		return $message;	
	}
	
	function updateGenre($bo) {
		if($bo == null || $bo->getId() <= 0) {
			return new MessageBO('Beim Speichern ist ein Fehler aufgetreten. Bitte versuche es erneut.', MESSAGE_TYPE_DANGER);
		}
		
		$message = null;
		$success = FALSE;
		
		$connection = getConnection();
		
		$stmt = $connection->prepare('UPDATE tbl_genre SET name = ? WHERE id = ?');
		if($stmt !== FALSE) {
			$stmt->bind_param('si', $bo->getName(), $bo->getId());
			$success = $stmt->execute();
			if($success) {
				$message = new MessageBO('Das Genre wurde erfolgreich gespeichert!', MESSAGE_TYPE_SUCCESS);
			}
			$stmt->close();
		} else {
			$message = new MessageBO('Beim Speichern ist ein Fehler aufgetreten. Bitte versuche es erneut.', MESSAGE_TYPE_DANGER);
		}
		
		$connection->close();
		
		return $message;	
	}
	
	function deleteGenre($id) {
		$message = null;
		$success = FALSE;
		
		//is id invalid
		if($id <= 0) {
			return new MessageBO('Beim Löschen ist ein Fehler aufgetreten. Bitte versuche es erneut.', MESSAGE_TYPE_DANGER);
		}
		
		//is price bracket used
		$message = isGenreUsed($id);
		if($message != null) {
			return $message;
		}
		
		$connection = getConnection();
		
		$stmt = $connection->prepare('DELETE FROM tbl_genre WHERE id = ?');
		if($stmt !== FALSE) {
			$stmt->bind_param('i', $id);
			$success = $stmt->execute();
			if($success) {
				$message = new MessageBO('Das Genre wurde erfolgreich gelöscht!', MESSAGE_TYPE_SUCCESS);
			}
			$stmt->close();
		} else {
			$message = new MessageBO('Beim Löschen ist ein Fehler aufgetreten. Bitte versuche es erneut.', MESSAGE_TYPE_DANGER);
		}
		
		$connection->close();
		
		return $message;	
	}
	
	function isGenreUsed($id) {
		$message = null;
		
		$connection = getConnection();
		
		$stmt = $connection->prepare('SELECT COUNT(id) FROM tbl_event WHERE genre_id = ?');
		if($stmt !== FALSE) {
			$stmt->bind_param('i', $id);
			$stmt->execute();
			
			$count;
			
			$stmt->bind_result($count);
			$stmt->fetch();
			
			if($count > 0) {
				$message = new MessageBO('Das Genre ist an eine oder mehreren Veranstaltung/en gebunden und kann deshalb nicht gelöscht werden.', MESSAGE_TYPE_WARNING);
			}
			
			$stmt->close();
			
		} else {
			$message = new MessageBO('Beim Löschen ist ein Fehler aufgetreten. Bitte versuche es erneut.', MESSAGE_TYPE_DANGER);
		}
		
		$connection->close();
		
		return $message;
	}
?>