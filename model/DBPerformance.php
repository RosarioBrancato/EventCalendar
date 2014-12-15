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
	
	
	function isPerformanceDateTimeFree($date, $time, $duration, $id) {
		$values = null;
		
		$connection = getConnection();
		
		$sql  = 'SELECT e.name, TIME_FORMAT(e.duration, "%H:%i"), p.id, DATE_FORMAT(p.date, "%d.%m.%Y"), TIME_FORMAT(p.time, "%H:%i")';
		$sql .= ' FROM tbl_performance p';
		$sql .= ' LEFT JOIN tbl_event e ON e.id = p.event_id';
		$sql .= ' WHERE p.date = ?'; 
		$sql .= ' AND ((? < p.time AND TIME(ADDTIME(?, ?)) > TIME(ADDTIME(p.time, e.duration)))';
		$sql .= ' OR ? BETWEEN p.time AND TIME(ADDTIME(p.time, e.duration))';
		$sql .= ' OR TIME(ADDTIME(?, ?)) BETWEEN p.time AND TIME(ADDTIME(p.time, e.duration)))';
		if($id > 0) {
			$sql .= ' AND p.id <> ?';
		}
		$sql .= ' ORDER BY p.date, p.time';
		
		$stmt = $connection->prepare($sql);
		if($stmt !== FALSE) {
			if($id > 0) {
				$stmt->bind_param('sssssssi', $date, 	$time, $time, $duration, 	$time, $time, $duration, 	$id);
			} else {
				$stmt->bind_param('sssssss', $date, 	$time, $time, $duration, 	$time, $time, $duration);
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
	
	function isChangeOfEventDurationPossible($event_id, $duration_new) {
		$values = null;
		
		$connection = getConnection();
		
		$sql  = 'SELECT ev.name, TIME_FORMAT(ev.duration, "%H:%i"), per.id, DATE_FORMAT(per.date, "%d.%m.%Y"), TIME_FORMAT(per.time, "%H:%i")';
		$sql .= ' FROM tbl_performance per';
		$sql .= ' LEFT JOIN tbl_event ev ON ev.id = per.event_id';
		
		$sql .= ' CROSS JOIN (';
		$sql .= ' SELECT p.id AS p_id, p.date AS p_date, p.time AS "start", ADDTIME(p.time, ?) AS "end"';
		$sql .= ' FROM tbl_event e';
		$sql .= ' INNER JOIN tbl_performance p ON p.event_id = e.id';
		$sql .= ' WHERE e.id = ?';
		$sql .= ' ORDER BY p.date, p.time) cj';
		
		$sql .= ' WHERE cj.p_date = per.date'; 
		$sql .= ' AND ((cj.start < per.time AND cj.end > TIME(ADDTIME(per.time, (CASE WHEN ev.id = ? THEN ? ELSE ev.duration END))))';
		$sql .= ' OR cj.start BETWEEN per.time AND TIME(ADDTIME(per.time,(CASE WHEN ev.id = ? THEN ? ELSE ev.duration END)))';
		$sql .= ' OR cj.end BETWEEN per.time AND TIME(ADDTIME(per.time, (CASE WHEN ev.id = ? THEN ? ELSE ev.duration END))))';
		$sql .= ' AND per.id <> cj.p_id';
		$sql .= ' ORDER BY per.date, per.time, ev.name';
		
		$stmt = $connection->prepare($sql);
		if($stmt !== FALSE) {
			$stmt->bind_param('siisisis', $duration_new, $event_id, 	$event_id, $duration_new,		$event_id, $duration_new,		$event_id, $duration_new);
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