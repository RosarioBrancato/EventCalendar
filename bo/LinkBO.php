<?php

class LinkBO {

	private $id = 0;
	private $name = '';
	private $link = '';
	private $event_id = 0;
	
	public function __construct($id, $name, $link, $event_id) {
		$this->id = $id;
		$this->name = $name;
		$this->link = $link;
		$this->event_id = $event_id;
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