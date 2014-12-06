<?php

class PerformanceBO {

	private $id = 0;
	private $date = '';
	private $time = '';
	private $event_id = 0;
	
	public function __construct($id, $date, $time, $event_id) {
		//id
		if($id != null && is_numeric($id) && $id > 0) {
			$this->id = $id;
		}
		//date
		if($date != null) {
			$this->date = $date;
		}
		//time
		if($time != null) {
			$this->time = $time;
		}
		//event id
		if($event_id != null && is_numeric($event_id) && $event_id > 0) {
			$this->event_id = $event_id;
		}
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