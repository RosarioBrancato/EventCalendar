<?php

class GenreBO {

	private $id = 0;
	private $name = "";
	
	public function __construct($id, $name) {
		//id
		if($id != null && is_numeric($id) && $id > 0) {
			$this->id = $id;
		}
		//name
		if($name != null) {
			$this->name = $name;
		}
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getName() {
		return $this->name;
	}
}

?>