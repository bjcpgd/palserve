<?php 
class alert extends arecord {
	
	public $hasone = array('user');
	
	function Alert() {
		
		
	}
	
	function validate() {
		$host = new Host;
		$host = $host->find($this->host_id);
		
		if($host->get_port_status($this->port,true) == 1) {
			return false;
		} else {
			return true;
		}
		
		return true;
	}
	
}

?>