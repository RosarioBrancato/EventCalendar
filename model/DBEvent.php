<?php

	include_once('DBConnection.php');

	function getEvents() {
		$values = array();
		
		$connection = getConnection();
		
		$sql  = 'SELECT e.id, e.name, e.cast, e.description, TIME_FORMAT(e.duration, "%H:%i"), e.picture, e.picture_text,';
		$sql .= ' g.id, g.name,';
		$sql .= ' l.id, l.name, l.link,';
		$sql .= ' p.id, DATE_FORMAT(p.date, "%d.%m.%Y"), TIME_FORMAT(p.time, "%H:%i"),';
		$sql .= ' pb.id, pb.name, pb.price';
		$sql .= ' FROM tbl_event e';
		$sql .= ' LEFT JOIN tbl_genre g ON g.id = e.genre_id';
		$sql .= ' LEFT JOIN tbl_link l ON l.event_id = e.id';
		$sql .= ' LEFT JOIN tbl_performance p ON p.event_id = e.id';
		$sql .= ' LEFT JOIN tbl_event_price ep ON ep.event_id = e.id';
		$sql .= ' LEFT JOIN tbl_price_bracket pb ON pb.id = ep.price_bracket_id';
		$sql .= ' ORDER BY e.name, p.date, p.time, pb.price';
		
		$stmt = $connection->prepare($sql);
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
			$genre_name;
			
			$link_id;
			$link_name;
			$link_link;
			
			$performance_id;
			$performance_date;
			$performance_time;
			
			$price_bracket_id;
			$price_bracket_name;
			$price_bracket_price;
			
			$stmt->bind_result($id, $name, $cast, $description, $duration, $picture, $pictureText, $genre_id, $genre_name, $link_id, $link_name, $link_link, $performance_id, $performance_date, $performance_time, $price_bracket_id, $price_bracket_name, $price_bracket_price);
			
			$currId = 0;
			$currBO = null;
			
			while($stmt->fetch()) {
				//set event and genre
				if($id != $currId) {
					$currId = $id;
					$currBO = new EventBO($id, $name, $cast, $description, $duration, $picture, $pictureText, $genre_id);
					$currBO->setGenre(new GenreBO($genre_id, $genre_name));
					
					$values[$id] = $currBO;
				}
				
				//set link, performance and price bracket
				if($currBO != null) {
					//link
					if($link_id != null && $link_id > 0) {
						$currBO->addLink(new LinkBO($link_id, $link_name, $link_link, $id));
					}
					
					//performance
					if($performance_id != null && $performance_id > 0) {
						$currBO->addPerformance(new PerformanceBO($performance_id, $performance_date, $performance_time, $id));
					}
					
					//price bracket
					if($price_bracket_id != null && $price_bracket_id > 0) {
						$currBO->addPriceBracket(new PriceBracketBO($price_bracket_id, $price_bracket_name, $price_bracket_price));
					}
				}
				
			}
			
			$stmt->close();
		
		}
		
		$connection->close();
		
		return $values;
	}
	
	function getEvent($id) {
	
		$connection = getConnection();
		
		$sql  = 'SELECT e.id, e.name, e.cast, e.description, TIME_FORMAT(e.duration, "%H:%i"), e.picture, e.picture_text,';
		$sql .= ' g.id, g.name,';
		$sql .= ' l.id, l.name, l.link,';
		$sql .= ' p.id, DATE_FORMAT(p.date, "%d.%m.%Y"), TIME_FORMAT(p.time, "%H:%i"),';
		$sql .= ' pb.id, pb.name, pb.price';
		$sql .= ' FROM tbl_event e';
		$sql .= ' LEFT JOIN tbl_genre g ON g.id = e.genre_id';
		$sql .= ' LEFT JOIN tbl_link l ON l.event_id = e.id';
		$sql .= ' LEFT JOIN tbl_performance p ON p.event_id = e.id';
		$sql .= ' LEFT JOIN tbl_event_price ep ON ep.event_id = e.id';
		$sql .= ' LEFT JOIN tbl_price_bracket pb ON pb.id = ep.price_bracket_id';
		$sql .= ' WHERE e.id = ?';
		$sql .= ' ORDER BY e.name, p.date, p.time, pb.price';
		
		$stmt = $connection->prepare($sql);
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
			$genre_name;
			
			$link_id;
			$link_name;
			$link_link;
			
			$performance_id;
			$performance_date;
			$performance_time;
			
			$price_bracket_id;
			$price_bracket_name;
			$price_bracket_price;
			
			$stmt->bind_result($id, $name, $cast, $description, $duration, $picture, $pictureText, $genre_id, $genre_name, $link_id, $link_name, $link_link, $performance_id, $performance_date, $performance_time, $price_bracket_id, $price_bracket_name, $price_bracket_price);
			
			$currId = 0;
			$currBO = null;
			
			while($stmt->fetch()) {
				//set event and genre
				if($id != $currId) {
					$currId = $id;
					$currBO = new EventBO($id, $name, $cast, $description, $duration, $picture, $pictureText, $genre_id);
					$currBO->setGenre(new GenreBO($genre_id, $genre_name));
					
					$values[$id] = $currBO;
				}
				
				//set link, performance and price bracket
				if($currBO != null) {
					//link
					if($link_id != null && $link_id > 0) {
						$currBO->addLink(new LinkBO($link_id, $link_name, $link_link, $id));
					}
					
					//performance
					if($performance_id != null && $performance_id > 0) {
						$currBO->addPerformance(new PerformanceBO($performance_id, $performance_date, $performance_time, $id));
					}
					
					//price bracket
					if($price_bracket_id != null && $price_bracket_id > 0) {
						$currBO->addPriceBracket(new PriceBracketBO($price_bracket_id, $price_bracket_name, $price_bracket_price));
					}
				}
				
			}
			
			$stmt->close();
		
		}
		
		$connection->close();
		
		return $currBO;
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
	
	function addPriceBracketToEvent($event_id, $price_bracket_id) {
	
	}
	
?>