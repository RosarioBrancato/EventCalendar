<?php

	include_once('DBConnection.php');
	
	function insertEventPrice($event_id, $price_bracket_id) {
		if($event_id <= 0 || $price_bracket_id <= 0) {
			return new MessageBO('Beim Speichern ist ein Fehler aufgetreten. Bitte versuche es erneut.', MESSAGE_TYPE_DANGER);
		}
	
		$message = eventPriceExists($event_id, $price_bracket_id);
		$success = FALSE;
		
		if($message == null) {
			
			$connection = getConnection();
			
			$stmt = $connection->prepare('INSERT INTO tbl_event_price (event_id, price_bracket_id) VALUES (?, ?)');
			if($stmt !== FALSE) {
				$stmt->bind_param('ii', $event_id, $price_bracket_id);
				$success = $stmt->execute();
				if($success) {
					$message = new MessageBO('Die Preisgruppe wurde erfolgreich zugewiesen!', MESSAGE_TYPE_SUCCESS);
				}
				$stmt->close();
			} else {
				$message = new MessageBO('Beim Speichern ist ein Fehler aufgetreten. Bitte versuche es erneut.', MESSAGE_TYPE_DANGER);
			}
			
			$connection->close();
		}
		
		return $message;	
	}
	
	function updateEventPrice($event_id, $price_bracket_id_old, $price_bracket_id_new) {
		if($event_id <= 0 || $price_bracket_id_old <= 0 || $price_bracket_id_new <= 0) {
			return new MessageBO('Beim Speichern ist ein Fehler aufgetreten. Bitte versuche es erneut.', MESSAGE_TYPE_DANGER);
		}
		
		$message = eventPriceExists($event_id, $price_bracket_id_new);
		$success = FALSE;
		
		if($message == null) {
			$connection = getConnection();
			
			$stmt = $connection->prepare('UPDATE tbl_event_price SET price_bracket_id = ? WHERE event_id = ? AND price_bracket_id = ?');
			if($stmt !== FALSE) {
				$stmt->bind_param('iii', $price_bracket_id_new, $event_id, $price_bracket_id_old);
				$success = $stmt->execute();
				if($success) {
					$message = new MessageBO('Die Preisgruppe wurde erfolgreich zugewiesen!', MESSAGE_TYPE_SUCCESS);
				}
				$stmt->close();
			} else {
				$message = new MessageBO('Beim Speichern ist ein Fehler aufgetreten. Bitte versuche es erneut.', MESSAGE_TYPE_DANGER);
			}
			
			$connection->close();
		}
		
		return $message;	
	}
	
	function deleteEventPrice($event_id, $price_bracket_id) {
		//is id invalid
		if($event_id <= 0 || $price_bracket_id <= 0) {
			return new MessageBO('Beim Löschen ist ein Fehler aufgetreten. Bitte versuche es erneut.', MESSAGE_TYPE_DANGER);
		}
		
		$message = null;
		$success = FALSE;
		
		$connection = getConnection();
		
		$stmt = $connection->prepare('DELETE FROM tbl_event_price WHERE event_id = ? AND price_bracket_id = ?');
		if($stmt !== FALSE) {
			$stmt->bind_param('ii', $event_id, $price_bracket_id);
			$success = $stmt->execute();
			if($success) {
				$message = new MessageBO('Die Preisgruppe wurde erfolgreich von der Veranstaltung getrennt!', MESSAGE_TYPE_SUCCESS);
			}
			$stmt->close();
		} else {
			$message = new MessageBO('Beim Löschen ist ein Fehler aufgetreten. Bitte versuche es erneut.', MESSAGE_TYPE_DANGER);
		}
		
		$connection->close();
		
		return $message;	
	}
	
	function eventPriceExists($event_id, $price_bracket_id) {
		//is id invalid
		if($event_id <= 0 || $price_bracket_id <= 0) {
			return new MessageBO('Beim Löschen ist ein Fehler aufgetreten. Bitte versuche es erneut.', MESSAGE_TYPE_DANGER);
		}
		
		$message = null;
		
		$connection = getConnection();
		
		$stmt = $connection->prepare('SELECT COUNT(event_id) FROM tbl_event_price WHERE event_id = ? AND price_bracket_id = ?');
		if($stmt !== FALSE) {
			$stmt->bind_param('ii', $event_id, $price_bracket_id);
			$stmt->execute();
			
			$count;
			
			$stmt->bind_result($count);
			$stmt->fetch();
			
			if($count > 0) {
				$message = new MessageBO('Die Preisgruppe wurde dieser Veranstaltung bereits zugewiesen.', MESSAGE_TYPE_WARNING);
			}
			
			$stmt->close();
			
		} else {
			$message = new MessageBO('Beim Speichern ist ein Fehler aufgetreten. Bitte versuche es erneut.', MESSAGE_TYPE_DANGER);
		}
		
		$connection->close();
		
		return $message;
	}

?>