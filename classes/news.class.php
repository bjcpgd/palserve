<?php
class News extends arecord {
	
	var $tablename = 'news';
	
	function News() {
		
	}
	
	function active() {
		
	
		$now = time();
		$this->active = 0;
		
		//Are they both set to nothing?
		if($this->start_date == 0 && $this->end_date == 0 ) {
			$this->active = 1;
		}
		
		//Is only the start date set?
		if($this->start_date != 0 && $this->end_date == 0) {
			if($now > $this->start_date) {
				$this->active = 1;
			} else {
				$this->active = 0;
			}
		}
		
		//Is only the end date set?
		
		if($this->end_date != 0 && $this->start_date == 0) {
			if($now > $this->end_date) {
				$this->active = 0;
			} else {
				$this->active = 1;
			}
		}
		
		//Are both the dates set?
		if($this->end_date != 0 && $this->start_date != 0) {
			
			if($now > $this->start_date && $now < $this->end_date) {
				$this->active = 1;
			} else {
				$this->active = 0;
			}
		}
		


		//Before we return that this is active, lets make sure its not protected.
		if($this->protected && $this->active == 1) {
		
			//Ok this is protected, so lets make sure we are logged in
			if($_SESSION['current_user'] != "" && $_SESSION['current_user']->status == 'Partner') {
				return true;
			} else {
				return false;
			}
		} else {
			return $this->active;
		}
	}
	
}
?>
