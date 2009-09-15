<?php 
class Host extends arecord {
	

	public $hasmany = array('alert','user_alert_preference');
	
	function Host() {
		
	
	}
	
	function ports() {
		return split(",",$this->ports);
	}
	
	function last_updated() {
		
		
		if(file_exists($this->get_grep_file_name())){
			return date("F j, Y, g:i a",filemtime($this->get_grep_file_name()));
		} else {
			return 'not yet checked';
		}
		
	}
	
	function get_user_preference($host_id,$user_id,$port) {
		foreach($this->user_alert_preferences as $pref) {
			if($pref->host_id == $host_id && $pref->user_id == $user_id && $pref->port == $port) {
				return $pref->preference;
			}
		}
	}
	
	function get_port_status($port,$returnNum=false) {
		global $results_dir;
		
		
		//Lets read the Grep file for this host
		if(!file_exists($results_dir.$this->name.'.txt')) {
			if($returnNum) { 
				return -1;
			} else {
				return '<span class="subdued">UNKNOWN</span>'; 
			}
		}
		$file = file_get_contents($results_dir.$this->name.'.txt');

		if(preg_match("/$port\/([open]+)/",$file)) {
			if($returnNum) { 
				return 1;
			} else {
				return '<span class="success">OK</span>';
			}
		} elseif(preg_match("/$port\/([closed]+)/",$file)) {
			if($returnNum) { 
				return 0;
			} else {
				return '<span class="error">FAILURE</span>';
			}
		}

				if($returnNum) { 
					return -1;
				} else {
					return '<span class="subdued">UNKNOWN</span>'; 
				}
	}
	
	
	function get_os() {
		
		
		global $results_dir;
		//Lets read the Grep file for this host
		if(!file_exists($results_dir.$this->name.'.txt')) { return 'unknown'; }
		
		
		$file = file_get_contents($results_dir.$this->name.'.xml');

		if(stristr($file,"Apple")) {
			return 'apple';
		} elseif(stristr($file,"Windows")) {
			return 'windows';
		} elseif(stristr($file,"Linux")) {
			return "linux";
		}


		return 'unknown';
	}
	
	function get_xml_file_name() {
		global $results_dir;
		return $results_dir.$this->name.".xml";
	}
	
	function get_grep_file_name() {
		global $results_dir;
		
		return $results_dir.$this->name.".txt";
		
	}
	
}
?>