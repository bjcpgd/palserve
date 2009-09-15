<?php
class Page extends arecord {
	
	function Page() {
		global $baseurl;
		
	}
	
	
	function __get($prop) {
	
			$this->name = str_replace(" ","_",$this->name);
		
		
	}
}
?>