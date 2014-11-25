<?php

	include_once('../constant/Constants.php');
	include_once('../bo/PriceBracketBO.php');
	include_once('../bo/MessageBO.php');
	include_once('DBConnection.php');

	function getPriceBrackets() {
		$values = array();
		
		$connection = getConnection();
		
		$stmt = $connection->prepare('SELECT id, name, price FROM tbl_price_bracket ORDER BY name');
		if($stmt !== FALSE) {
			$stmt->execute();
			
			$id;
			$name;
			$price;
			
			$stmt->bind_result($id, $name, $price);
			
			while($stmt->fetch()) {
				$values[$id] = new PriceBracketBO($id, $name, $price);
			}
			
			$stmt->close();
		
		}
		
		$connection->close();
		
		return $values;
	}
	
	function getPriceBracket($id) {
		$bo = null;
		
		$connection = getConnection();
		
		$stmt = $connection->prepare('SELECT id, name, price FROM tbl_price_bracket WHERE id = ?');
		if($stmt !== FALSE) {
			$stmt->bind_param('i', $id);
			$stmt->execute();
			
			$id;
			$name;
			$price;
			
			$stmt->bind_result($id, $name, $price);
			
			while($stmt->fetch()) {
				$bo = new PriceBracketBO($id, $name, $price);
			}
			
			$stmt->close();
		}
		
		$connection->close();
		
		return $bo;	
	}
	
	function insertPriceBracket($bo) {
		if($bo == null || $bo->getId() > 0) {
			return new MessageBO('Beim Speichern ist ein Fehler aufgetreten. Bitte versuche es erneut.', MESSAGE_TYPE_DANGER);
		}
		
		$message = null;
		$success = FALSE;
		
		$connection = getConnection();
		
		$stmt = $connection->prepare('INSERT INTO tbl_price_bracket (name, price) VALUES ( ?, ?)');
		if($stmt !== FALSE) {
			$stmt->bind_param('ss', $bo->getName(), $bo->getPrice());
			$success = $stmt->execute();
			if($success) {
				$message = new MessageBO('Die Preisgruppe wurde erfolgreich gespeichert!', MESSAGE_TYPE_SUCCESS);
			}
			$stmt->close();
		} else {
			$message = new MessageBO('Beim Speichern ist ein Fehler aufgetreten. Bitte versuche es erneut.', MESSAGE_TYPE_DANGER);
		}
		
		$connection->close();
		
		return $message;	
	}
	
	function updatePriceBracket($bo) {
		if($bo == null || $bo->getId() <= 0) {
			return new MessageBO('Beim Speichern ist ein Fehler aufgetreten. Bitte versuche es erneut.', MESSAGE_TYPE_DANGER);
		}
		
		$message = null;
		$success = FALSE;
		
		$connection = getConnection();
		
		$stmt = $connection->prepare('UPDATE tbl_price_bracket SET name = ?, price = ? WHERE id = ?');
		if($stmt !== FALSE) {
			$stmt->bind_param('ssi', $bo->getName(), $bo->getPrice(), $bo->getId());
			$success = $stmt->execute();
			if($success) {
				$message = new MessageBO('Die Preisgruppe wurde erfolgreich gespeichert!', MESSAGE_TYPE_SUCCESS);
			}
			$stmt->close();
		} else {
			$message = new MessageBO('Beim Speichern ist ein Fehler aufgetreten. Bitte versuche es erneut.', MESSAGE_TYPE_DANGER);
		}
		
		$connection->close();
		
		return $message;	
	}
	
	function deletePriceBracket($id) {
		$message = null;
		$success = FALSE;
		
		//is id invalid
		if($id <= 0) {
			return new MessageBO('Beim Löschen ist ein Fehler aufgetreten. Bitte versuche es erneut.', MESSAGE_TYPE_DANGER);
		}
		
		//is price bracket used
		$message = isPriceBracketUsed($id);
		if($message != null) {
			return $message;
		}
		
		$connection = getConnection();
		
		$stmt = $connection->prepare('DELETE FROM tbl_price_bracket WHERE id = ?');
		if($stmt !== FALSE) {
			$stmt->bind_param('i', $id);
			$success = $stmt->execute();
			if($success) {
				$message = new MessageBO('Die Preisgruppe wurde erfolgreich gelöscht!', MESSAGE_TYPE_SUCCESS);
			}
			$stmt->close();
		} else {
			$message = new MessageBO('Beim Löschen ist ein Fehler aufgetreten. Bitte versuche es erneut.', MESSAGE_TYPE_DANGER);
		}
		
		$connection->close();
		
		return $message;	
	}
	
	function isPriceBracketUsed($id) {
		$message = null;
		
		$connection = getConnection();
		
		$stmt = $connection->prepare('SELECT COUNT(price_bracket_id) FROM tbl_event_price WHERE price_bracket_id = ?');
		if($stmt !== FALSE) {
			$stmt->bind_param('i', $id);
			$stmt->execute();
			
			$count;
			
			$stmt->bind_result($count);
			$stmt->fetch();
			
			if($count > 0) {
				$message = new MessageBO('Die Preisgruppe wird im moment gebraucht und kann deshalb nicht gelöscht werden.', MESSAGE_TYPE_WARNING);
			}
			
			$stmt->close();
			
		} else {
			$message = new MessageBO('Beim Löschen ist ein Fehler aufgetreten. Bitte versuche es erneut.', MESSAGE_TYPE_DANGER);
		}
		
		$connection->close();
		
		return $message;
	}
?>