<?php
class arecord {
	
	function __construct($id=null) {
			if(is_numeric($id)) {
				$this->id = $id;
				$this->find($id);
			}
	}
	

	
	function count_all() {
		global $dba;
			$this->get_table();
		
		$sql = "SELECT count(`id`) FROM ".$this->tablename;
		if($dba->debug || $dba->file_debug) {
			file_put_contents('logs/sql.log',"\n[".date('m/d/y h:i:s A')."] - ".$sql,FILE_APPEND);
		}
		return $dba->GetOne($sql);
	}
	
	function find($id=null,$page=null,$perpage=null) {
		global $dba;		
		if(is_numeric($id)) {
			$cond = "WHERE id = $id";
			$returnsingle = true;
		} elseif(is_array($id)) {
			$final = array();
		
			foreach($id as $i) {
			
			  array_push($final,$this->find($i));
			}
	
			return $final;
		} else {
			$cond = $id;
		}
		
		$this->get_table();
		
		if($page != null && $perpage != null) {
			$limit = " LIMIT ".$page.",".$perpage;
		} else {
			$limit = "";
		}
		
			
		$sql = "SELECT * from ".$this->tablename." $cond $limit ";
	
		$sqlcount = "SELECT count(id) from ".$this->tablename." $cond";
		

		
		$rscount = $dba->GetOne($sqlcount);
		
		$this->last_find_count = $rscount;
	
	
		if($dba->debug || $dba->file_debug) {
			file_put_contents('logs/sql.log',"\n[".date('m/d/y h:i:s A')."] - ".$sql,FILE_APPEND);
		}
		$rs = $dba->GetAll($sql);
		
		
		
		$this->get_object_type();
		
		$obj_return = array();
		if(is_array($rs)) {
	
			foreach($rs as $record) {
				$obj = new $this->obj_type;
				
				foreach($record as $key=>$value) {
					$key = str_replace(" ","_",$key);
				
					$obj->$key = convert_smart_quotes(urldecode(stripslashes($value)));
					
				
					
					if(substr($obj->$key,0,2) == 'a:') {
					
					
					
						$obj->$key = unserialize($obj->$key);
						
						$obj->$key = strip_slashes_recursive($obj->$key);
						
					}
					
				}
				
				$obj->get_associated();
				$obj_return[] = $obj;
			
			}
			
		} else {
			return false;
		}
		
		if($returnsingle) {
			
			return $obj_return[0];
		}
	
		
		return $obj_return;
	}
	
	function save($params=NULL) {
		global $dba;
		$this->get_table();
		
		if(is_array($params)) {
			//this is a new record
			
			foreach($params as $key=>$value) {
				$this->$key = $value;
			}
			
			$this->id = $this->save();
			
		} else {
			//This is an update of an existing object
			$sql_columns = "SHOW COLUMNS from ".$this->tablename;
			if($dba->debug || $dba->file_debug) {
				file_put_contents('logs/sql.log',"\n[".date('m/d/y h:i:s A')."] - ".$sql_columns,FILE_APPEND);
			}
			$rs = $dba->Execute($sql_columns);
		
		
			
			if($this->id) {
				foreach($rs as $col) {
					/* Create an update script */
					if(is_array($this->$col['Field'])) {
						$this->$col['Field'] = addslashes(serialize($this->$col['Field']));
					}
					$strs[] = "".$col['Field']." = '".addslashes($this->$col['Field'])."'";
				
				}
					
				//Final SQL command
				$sql = "UPDATE ".$this->tablename." SET ".implode(" , ",$strs)." WHERE id = ".$this->id;
				
				if($dba->debug || $dba->file_debug) {
					file_put_contents('logs/sql.log',"\n[".date('m/d/y h:i:s A')."] - ".$sql,FILE_APPEND);
				}
				$result = $dba->Execute($sql);
			
				return result;
				
			} else {
				
				
				
				foreach($rs as $col) {
					/*Create an insert script */
						
						if($col['Field'] == 'created_on') { 
							
							$fields[] = 'created_on';
							$values[] = 'NOW()';
						
						} elseif($col['Field'] == 'updated_on') { 

								$fields[] = 'updated_on';
								$values[] = 'NOW()';
							
						} else {
						
							
						
							$fields[] = "`".$col['Field']."`";
							
								if(is_array($this->$col['Field'])) {
									$this->$col['Field'] = serialize($this->col['Field']);
								}
							
							$values[] = "'".$this->$col['Field']."'"; 
						}
				}
				//Final SQL command
				
				$fields = implode(',',$fields);
				$values = implode(',',$values);
				
				$sql = "INSERT into ".$this->tablename." ($fields) VALUES ($values)";
				if($dba->debug || $dba->file_debug) {
					file_put_contents('logs/sql.log',"\n[".date('m/d/y h:i:s A')."] - ".$sql,FILE_APPEND);
				}
				$dba->Execute($sql);
				$result = $dba->Insert_ID();
				
				$this->id = $result;
				return $result;
				
			}
			
		
		}
		return true;
		
	}
	
	
	function delete() {
		global $dba;
			$this->get_table();
		$sql = "DELETE from ".$this->tablename." WHERE id = ".$this->id;
		if($dba->debug || $dba->file_debug) {
			file_put_contents('logs/sql.log',"\n[".date('m/d/y h:i:s A')."] - ".$sql,FILE_APPEND);
		}
		if($dba->Execute($sql)) {
			return true;
		} else {
			return false;
		}
	}
	
	function get_table() {
			$args = get_class_methods($this);
			if(!isset($this->tablename)) {
	 			$this->tablename = strtolower($args[0])."s";
			} else {
				$this->tablename = strtolower($this->tablename);
			}
	}
	
	function get_object_type() {
		$args = get_class_methods($this);
		$this->obj_type = $args[0];
		return $this->obj_type;
	}
	
	function search_on_all($word,$ommit=array()) {
			$this->get_table();
			global $dba;
				
			if(!stristr($word,"and") && !stristr($word,'or'))			
				$word = preg_replace("/\s/"," or ",$word);
			
			
		
			$terms = preg_split("/and|or/",$word);
	
			preg_match_all("(and|or)",$word,$operators);
			
			$sql_columns = "SHOW COLUMNS from ".$this->tablename;
			
			foreach($terms as $term) {
				$strs = array();
				
			$rs = $dba->Execute($sql_columns);
			
				$term=trim($term);
				if(!empty($term)) {
							
					foreach($rs as $col) {
						/* Create an update script */
						if(!in_array($col['Field'],$ommit)) {
							$strs[] = "`".$col['Field']."` LIKE '%".$term."%'";
						}
					}
				
					$str[] = (implode(" OR ",$strs));
				}
			}
			
			$i = 0;
			foreach($str as $line) {
				
				if(isset($operators[0][$i])) {
					$op = $operators[0][$i];
				} else { 
					$op = "";
				}
				
				$sqlline .= "( $line ) \n$op\n";
				
				$i++;
			}
		
		//	echo $sqlline;
			
			//return $this->find("WHERE ".implode(" OR ",$strs));
			
			return $this->find("WHERE $sqlline");
	}
	
	
	function get_associated() {
		
		
		if($this->hasmany) {
			foreach($this->hasmany as $model) {
				$model = new $model;
				
				$rs = $model->find("WHERE ".strtolower($this->get_object_type())."_id = ".$this->id);
				
				$mtbl = $model->tablename;
				
				$this->$mtbl = $rs;
				
				
			}
		}
		
		if($this->hasone) {
			foreach($this->hasone as $model) {
				
				$m = new $model;
				$txt = $model."_id";
				
			
				$obj = $m->find($this->$txt);
				
					$mtbl = $m->obj_type;

					$this->$mtbl = $obj;
			}
		}
		
	}
	
	function distinct_values($field) {
		$this->get_table();
		global $dba;
		
		$sql_values = "SELECT DISTINCT `".$field."` FROM `".$this->tablename."` ORDER by `".$field."`";
		
			if($dba->debug || $dba->file_debug) {
				file_put_contents('logs/sql.log',"\n[".date('m/d/y h:i:s A')."] - ".$sql_values,FILE_APPEND);
			}
		
		return $dba->GetAll($sql_values);
	}
	
	function get_fields() {
		$this->get_table();
		global $dba;
		
		$sql_columns = "SHOW COLUMNS from ".$this->tablename;
		if($dba->debug || $dba->file_debug) {
			file_put_contents('logs/sql.log',"\n[".date('m/d/y h:i:s A')."] - ".$sql_columns,FILE_APPEND);
		}
		return $dba->GetAll($sql_columns);
	}
	
}

?>
