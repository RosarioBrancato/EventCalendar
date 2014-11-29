<?php

class EventBO {

	private $id = 0;
	private $name = '';
	private $cast = '';
	private $description = '';
	private $duration = null;
	private $picture = '';
	private $pictureText = '';
	private $genre_id = 0;
	
	public function __construct($id, $name, $cast, $description, $duration, $picture, $pictureText, $genre_id) {
		$this->id = $id;
		$this->name = $name;
		$this->cast = $cast;
		$this->description = $description;
		$this->duration = $duration;
		$this->picture = $picture;
		$this->pictureText = $pictureText;
		$this->genre_id = $genre_id;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getCast() {
		return $this->cast;
	}
	
	public function getDescription() {
		return $this->description;
	}
	
	public function getDuration() {
		return $this->duration;
	}
	
	public function getPicture() {
		return $this->picture;
	}
	
	public function getPictureText() {
		return $this->pictureText;
	}
	
	public function getGenreId() {
		return $this->genre_id;
	}
	
}

?>