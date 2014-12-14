<?php

	$selectedGenreId = 0;
	$year = 0;
	$event_id = 0;
	
	if(isset($_GET['genre']) && is_numeric($_GET['genre'])) {
		$selectedGenreId = intval($_GET['genre']);
	}
	
	if(isset($_GET['year']) && is_numeric($_GET['year'])) {
		$year = intval($_GET['year']);
	}
	
	if(isset($_GET['e']) && is_numeric($_GET['e'])) {
		$event_id = intval($_GET['e']);
	}

	//get db object
	$dbEvent = new DBEvent();
	
	if($event_id > 0) {
		//load data
		$data = $dbEvent->getEvent($event_id);
		//show gui
		showEventArchiveDetailGui($data, $year, $selectedGenreId);
	
	} else {
		//load data
		$data = $dbEvent->getEventsOfYear($selectedGenreId, $year);
		//get genres
		$genres = getGenres();
		//show gui
		showEventArchiveOverviewGui($data, $genres, $year, $selectedGenreId);
	}

?>