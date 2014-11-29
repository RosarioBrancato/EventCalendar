<?php

	include_once('../constant/Constants.php');
	include_once('../bo/EventBO.php');
	include_once('../bo/MessageBO.php');
	include_once('DBConnection.php');

	function getEvents() {
		$values = array();
		
		$connection = getConnection();
		
		$stmt = $connection->prepare('SELECT id, name, cast, description, duration, picture, picture_text, genre_id FROM tbl_event ORDER BY name');
		if($stmt !== FALSE) {
			$stmt->execute();
			
			$id;
			$name;
			$cast;
			$description;
			$duration;
			$picture;
			$pictureText;
			$genre_id;
			
			$stmt->bind_result($id, $name, $cast, $description, $duration, $picture, $pictureText, $genre_id);
			
			while($stmt->fetch()) {
				$values[$id] = new EventBO($id, $name, $cast, $description, $duration, $picture, $pictureText, $genre_id);
			}
			
			$stmt->close();
		
		}
		
		$connection->close();
		
		return $values;
	}
	
	function getEvent($id) {
		$bo = null;
		
		$connection = getConnection();
		
		$stmt = $connection->prepare('SELECT id, name, cast, description, duration, picture, picture_text, genre_id FROM tbl_event WHERE id = ?');
		if($stmt !== FALSE) {
			$stmt->bind_param('i', $id);
			$stmt->execute();
			
			$id;
			$name;
			$cast;
			$description;
			$duration;
			$picture;
			$pictureText;
			$genre_id;
			
			$stmt->bind_result($id, $name, $cast, $description, $duration, $picture, $pictureText, $genre_id);
			
			while($stmt->fetch()) {
				$bo = new EventBO($id, $name, $cast, $description, $duration, $picture, $pictureText, $genre_id);
			}
			
			$stmt->close();
		}
		
		$connection->close();
		
		return $bo;	
	}
	
	function insertEvent($bo) {
		$message = new MessageBO('Beim Speichern ist ein Fehler aufgetreten. Bitte versuche es erneut.', MESSAGE_TYPE_DANGER);
		$success = FALSE;
		
		if($bo == null || $bo->getId() > 0) {
			return $message;
		}
		
		$connection = getConnection();
		
		$stmt = $connection->prepare('INSERT INTO tbl_event (name, cast, description, duration,  picture, picture_text, genre_id) VALUES ( ?, ?, ?, ?, ?, ?, ?)');
		if($stmt !== FALSE) {
			$stmt->bind_param('ssssssi', $bo->getName(), $bo->getCast(), $bo->getDescription(), $bo->getDuration(), $bo->getPicture(), $bo->getPictureText(), $bo->getGenreId());
			$success = $stmt->execute();
			if($success) {
				$message = new MessageBO('Die Veranstaltung wurde erfolgreich gespeichert!', MESSAGE_TYPE_SUCCESS);
			}
			$stmt->close();
		}
		
		$connection->close();
		
		return $message;	
	}
	
	function updateEvent($bo) {
		$message = new MessageBO('Beim Speichern ist ein Fehler aufgetreten. Bitte versuche es erneut.', MESSAGE_TYPE_DANGER);
		$success = FALSE;
		
		if($bo == null || $bo->getId() <= 0) {
			return $message;
		}
		
		$connection = getConnection();
		
		$stmt = $connection->prepare('UPDATE tbl_event SET name = ?, cast = ?, description = ?, duration = ?, picture = ?, picture_text = ?, genre_id = ? WHERE id = ?');
		if($stmt !== FALSE) {
			$stmt->bind_param('ssssssii', $bo->getName(), $bo->getCast(), $bo->getDescription(), $bo->getDuration(), $bo->getPicture(), $bo->getPictureText(), $bo->getGenreId(), $bo->getId());
			$success = $stmt->execute();
			if($success) {
				$message = new MessageBO('Die Veranstaltung wurde erfolgreich gespeichert!', MESSAGE_TYPE_SUCCESS);
			}
			$stmt->close();
		}
		
		$connection->close();
		
		return $message;	
	}
	
	function deleteEvent($id) {
		$message = new MessageBO('Beim Löschen ist ein Fehler aufgetreten. Bitte versuche es erneut.', MESSAGE_TYPE_DANGER);
		$success = FALSE;
		
		//is id invalid
		if($id <= 0) {
			return $message;
		}
		
		$connection = getConnection();
		
		//Cascade on tbl_event_price, tbl_link and tbl_performance
		$stmt = $connection->prepare('DELETE FROM tbl_event WHERE id = ?');
		if($stmt !== FALSE) {
			$stmt->bind_param('i', $id);
			$success = $stmt->execute();
			if($success) {
				$message = new MessageBO('Die Veranstaltung wurde erfolgreich gelöscht!', MESSAGE_TYPE_SUCCESS);
			}
			$stmt->close();
		}
		
		$connection->close();
		
		return $message;	
	}
	
?>