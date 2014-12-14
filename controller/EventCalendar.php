<?php

	$selectedGenreId = 0;
	
	if(isset($_GET['genre']) && is_numeric($_GET['genre'])) {
		$selectedGenreId = intval($_GET['genre']);
	}

	//get db object
	$dbEvent = new DBEvent();
	//load data
	$data = $dbEvent->getEventsDetailsUpcoming($selectedGenreId);
	//get genres
	$genres = getGenres();
	//show gui
	showEventCalendarGui($data, $genres, $selectedGenreId);

?>