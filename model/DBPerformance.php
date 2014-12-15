<?php

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
	
	function getYearsOfEvents() {
		$values = array();
		
		$connection = getConnection();
		
		$stmt = $connection->prepare('SELECT DISTINCT DATE_FORMAT(date, "%Y") FROM tbl_performance WHERE date <= CURDATE() ORDER BY date DESC');
		if($stmt !== FALSE) {
			$stmt->execute();
			
			$year;
			
			$stmt->bind_result($year);
			
			while($stmt->fetch()) {
				$values[$year] = $year;
			}
			
			$stmt->close();
		}
		
		$connection->close();
		
		return $values;
	}
	
	function isPerformanceDateTimeFree($date, $time, $duration, $id) {
		$values = null;
		
		$connection = getConnection();
		
		$sql  = 'SELECT e.name, TIME_FORMAT(e.duration, "%H:%i"), p.id, DATE_FORMAT(p.date, "%d.%m.%Y"), TIME_FORMAT(p.time, "%H:%i")';
		$sql .= ' FROM tbl_performance p';
		$sql .= ' LEFT JOIN tbl_event e ON e.id = p.event_id';
		$sql .= ' WHERE ? = p.date'; 
		$sql .= ' AND (? BETWEEN p.time AND ADDTIME(p.time, e.duration)';
		$sql .= ' OR ADDTIME(?, ?) BETWEEN p.time AND ADDTIME(p.time, e.duration))';
		if($id > 0) {
			$sql .= ' AND p.id <> ?';
		}
		$sql .= ' ORDER BY p.date, p.time';
		
		$stmt = $connection->prepare($sql);
		if($stmt !== FALSE) {
			if($id > 0) {
				$stmt->bind_param('ssssi', $date, $time, $time, $duration, $id);
			} else {
				$stmt->bind_param('ssss', $date, $time, $time, $duration);
			}
			$stmt->execute();
			
			$event_name;
			$event_duration;
			$performance_id;
			$performance_date;
			$performance_time;
			
			$stmt->bind_result($event_name, $event_duration, $performance_id, $performance_date, $performance_time);
			
			while($stmt->fetch()) {
				if($values == null) {
					$values = array();
				}
				
				$values[$performance_id] = array('event_name'=>$event_name, 
													'event_duration'=>$event_duration, 
													'performance_date'=>$performance_date, 
													'performance_time'=>$performance_time);
			}
			
			$stmt->close();
		}
		
		$connection->close();
		
		return $values;	
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