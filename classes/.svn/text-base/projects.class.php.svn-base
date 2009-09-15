<?php
class Project extends arecord {
	

	function Project() {
		global $baseurl;
		
	}
	
	function area_name() {
		global $dba;
		$sql = "SELECT name from areas WHERE id = '".$this->area_id."'";
		return $dba->GetOne($sql);
	}
	
	function random() {
		global $dba;
		
		$sql = "SELECT id,rand() as rand from projects order by rand";
	
		$obj = $dba->GetAll($sql);

		$proj = new project();
		$proj = $proj->find($obj[0]['id']);
		return $proj;
	}
	
}
?>