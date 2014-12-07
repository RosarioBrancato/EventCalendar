<?php

	include_once('../constant/Constants.php');
	include_once('../bo/PerformanceBO.php');
	include_once('../bo/MessageBO.php');
	include_once('DBConnection.php');
	
	function getPerformance($id) {
		$bo = null;
		
		$connection = getConnection();
		
		$stmt = $connection->prepare('SELECT id, DATE_FORMAT(date, "%d.%m.%Y"), TIME_FORMAT(time, "%H:%i"), event_id FROM tbl_performance WHERE id = ?');
		if($stmt !== FALSE) {
			$stmt->bind_param('i', $id);
			$stmt->execute();
			
			$id;
			$date;
			$time;
			$event_id;
			
			$stmt->bind_result($id, $date, $time, $event_id);
			
			while($stmt->fetch()) {
				$bo = new PerformanceBO($id, $date, $time, $event_id);
			}
			
			$stmt->close();
		}
		
		$connection->close();
		
		return $bo;	
	}
	
	function insertPerformance($bo) {
		if($bo == null || $bo->getId() > 0) {
			return new MessageBO('Beim Speichern ist ein Fehler aufgetreten. Bitte versuche es erneut.', MESSAGE_TYPE_DANGER);
		}
		
		$message = null;
		$success = FALSE;
		
		$connection = getConnection();
		
		$stmt = $connection->prepare('INSERT INTO tbl_performance (date, time, event_id) VALUES ( ?, ?, ?)');
		if($stmt !== FALSE) {
			$stmt->bind_param('ssi', $bo->getDate(), $bo->getTime(), $bo->getEventId());
			$success = $stmt->execute();
			if($success) {
				$message = new MessageBO('Die Vorstellung wurde erfolgreich gespeichert!', MESSAGE_TYPE_SUCCESS);
			}
			$stmt->close();
		} else {
			$message = new MessageBO('Beim Speichern ist ein Fehler aufgetreten. Bitte versuche es erneut.', MESSAGE_TYPE_DANGER);
		}
		
		$connection->close();
		
		return $message;	
	}
	
	function updatePerformance($bo) {
		if($bo == null || $bo->getId() <= 0) {
			return new MessageBO('Beim Speichern ist ein Fehler aufgetreten. Bitte versuche es erneut.', MESSAGE_TYPE_DANGER);
		}
		
		$message = null;
		$success = FALSE;
		
		$connection = getConnection();
		
		$stmt = $connection->prepare('UPDATE tbl_performance SET date = ?, time = ? WHERE id = ?');
		if($stmt !== FALSE) {
			$stmt->bind_param('ssi', $bo->getDate(), $bo->getTime(), $bo->getId());
			$success = $stmt->execute();
			if($success) {
				$message = new MessageBO('Die Vorstellung wurde erfolgreich gespeichert!', MESSAGE_TYPE_SUCCESS);
			}
			$stmt->close();
		} else {
			$message = new MessageBO('Beim Speichern ist ein Fehler aufgetreten. Bitte versuche es erneut.', MESSAGE_TYPE_DANGER);
		}
		
		$connection->close();
		
		return $message;	
	}
	
	function deletePerformance($id) {
		$message = null;
		$success = FALSE;
		
		//is id invalid
		if($id <= 0) {
			return new MessageBO('Beim Löschen ist ein Fehler aufgetreten. Bitte versuche es erneut.', MESSAGE_TYPE_DANGER);
		}
		
		$connection = getConnection();
		
		$stmt = $connection->prepare('DELETE FROM tbl_performance WHERE id = ?');
		if($stmt !== FALSE) {
			$stmt->bind_param('i', $id);
			$success = $stmt->execute();
			if($success) {
				$message = new MessageBO('Die Vorstellung wurde erfolgreich gelöscht!', MESSAGE_TYPE_SUCCESS);
			}
			$stmt->close();
		} else {
			$message = new MessageBO('Beim Löschen ist ein Fehler aufgetreten. Bitte versuche es erneut.', MESSAGE_TYPE_DANGER);
		}
		
		$connection->close();
		
		return $message;	
	}
	
?>