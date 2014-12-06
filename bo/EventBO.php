<?php

include_once('GenreBO.php');

class EventBO {

	private $id = 0;
	private $name = '';
	private $cast = '';
	private $description = '';
	private $duration = '';
	private $picture = '';
	private $pictureText = '';
	
	private $genre_id = 0;
	private $genre = null;
	
	private $links = null;
	private $priceBrackets = null;
	private $performances = null;
	
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
	
	
	//GENRE
	public function setGenre($genre) {
		if($genre != null) {
			$this->genre = $genre;
		}
	}
	
	public function getGenre() {
		return $this->genre;
	}
	
	
	//LINK
	public function addLink($link) {
		if($link != null) {
			if($this->links == null) {
				$this->array();
			}
			
			if($link->getId() > 0) {
				$this->links[$link->getId()] = $link;
			}
		}
	}
	
	//PERFORMANCE
	public function addPerformance($performance) {
		if($performance != null) {
			if($this->performances == null) {
				$this->performances = array();
			}
			
			if($performance->getId() > 0) {
				$this->performances[$performance->getId()] = $performance;
			}
		}
	}
	
	//PRICE BRACKET
	public function addPriceBracket($priceBracket) {
		if($priceBracket != null) {
			if($this->priceBrackets == null) {
				$this->priceBrackets = array();
			}
			
			if($priceBracket->getId() > 0) {
				$this->priceBrackets[$priceBracket->getId()] = $priceBracket;
			}
		}
	}
	
}

?>