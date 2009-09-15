<?php
class tags extends Arecord {
	
	function tags() {
		
	}
	
	function count_all() {
		
		
		
	}
	
	function find($search=null) {
		
		if($search == null) {
			
			$tables = array("news","projects","pages");
			
			foreach($tables as $table) {
				$sql = "SELECT tags from $table";
				global $dba;
		
				$rs = $dba->CacheGetAll(3200,$sql);
		
				foreach($rs as $r) {
		
					$tags = split(",",$r['tags']);
			
					foreach($tags as $t) {
						$t = trim($t);
						if(!empty($t)) {
							$arr[$t] += 1;
						}
					}
			
				}
			}
		
			return $arr;
		} else {
			//return the specific news item for that tag
			$tables = array("News"=>"news","Project"=>"projects","Page"=>"pages");
			
			foreach($tables as $object=>$table) {
			$sql = "SELECT id from $table WHERE tags LIKE '%$search%'";
			
			global $dba;
			$rs = $dba->GetAll($sql);
			
			foreach($rs as $r) {
				
				$n = new $object();
				$arr[] = $n->find($r['id']);
				
			}
			
			}
			
			return $arr;
		}
	}
}


?>