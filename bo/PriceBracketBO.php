<?php

class PriceBracketBO {

	private $id = 0;
	private $name = "";
	private $price = 0;
	
	public function __construct($id, $name, $price) {
		//id
		if($id != null && is_numeric($id) && $id > 0) {
			$this->id = $id;
		}
		//name
		if($name != null) {
			$this->name = $name;
		}
		//price
		if($price != null && is_numeric($price) && $price >= 0) {
			$this->price = $price;
		}
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getPrice() {
		return $this->price;
	}
}

?>