<?php

	include_once('../constant/Constants.php');
	
	class MessageBO {
	
		private $text = '';
		private $type = MESSAGE_TYPE_SUCCESS;
	
		public function __construct($text, $type) {
			if($text != null) {
				$this->text = $text;
			}
			if($type != null) {
				$this->type = $type;
			}
		}
		
		public function getText() {
			return $this->text;
		}
		
		public function getType() {
			return $this->type;
		}
		
		public function getClassAlert() {
			$class = 'well';
			
			switch($this->type) {
				case MESSAGE_TYPE_SUCCESS:
					$class = 'alert alert-success';
					break;
					
				case MESSAGE_TYPE_INFO:
					$class = 'alert alert-info';
					break;
					
				case MESSAGE_TYPE_WARNING:
					$class = 'alert alert-warning';
					break;
					
				case MESSAGE_TYPE_DANGER:
					$class = 'alert alert-danger';
					break;
			}
			
			return $class;
		}
	
	}
	
?>