<?php

class LinkBO {

	private $id = 0;
	private $name = '';
	private $link = '';
	private $event_id = 0;
	
	public function __construct($id, $name, $link, $event_id) {
		//id
		if($id != null && is_numeric($id) && $id > 0) {
			$this->id = $id;
		}
		//name
		if($name != null) {
			$this->name = $name;
		}
		//link
		if($link != null) {
			$this->link = $link;
		}
		//event id
		if($event_id != null && is_numeric($event_id) && $event_id > 0) {
			$this->event_id = $event_id;
		}
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getName() {
		return $this->name;
	}
	
	public function getLink() {
		return $this->link;
	}
	
	public function getEventId() {
		return $this->event_id;
	}
}

?>