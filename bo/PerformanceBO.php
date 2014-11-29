<?php

class PerformanceBO {

	private $id = 0;
	private $date = '';
	private $time = '';
	private $event_id = 0;
	
	public function __construct($id, $date, $time, $event_id) {
		$this->id = $id;
		$this->date = $date;
		$this->time = $time;
		$this->event_id = $event_id;
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function getDate() {
		return $this->date;
	}
	
	public function getTime() {
		return $this->time;
	}
	
	public function getEventId() {
		return $this->event_id;
	}
}

?>