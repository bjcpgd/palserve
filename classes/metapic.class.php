<?php
class Metapic extends arecord {
	
	function Metapic() {
		global $baseurl;
		
	}
	
	function image_path() {
		global $baseurl;
		if($this->MIME_Type != "image/x-raw") {
		return '/db_images'.$this->Directory."/".$this->File_Name;
		} else {
			return "/phpThumb/phpThumb.php?src=/".thumbnails."".$this->Directory."/".$this->File_Name.".jpg&h=1024";
		}
	}
	
	
	function thumbnail_path($full='',$size=128,$noprint=true) {
		global $baseurl;
		$file = $this->Directory."/".$this->File_Name;
		$ext = strtolower(substr($file,strlen($file)-3)); //get the extension of an image

		     /*   if ($ext == "jpg") {
					try {
						ini_set("display_errors",0);
						$image = exif_thumbnail($file, $width, $height, $type);
					} catch(Exception $e) {
						$image = false;
					}
				} else {
					$image = false;
				}
				*/
				$image = false;
			
			
	//	if($noprint)
		
		
	
		//echo "<div title=\"header=[$this->File_Name] body=[<strong>Size:</strong> $this->File_Size <br/> <strong>Keywords:</strong> $this->Keywords]\" 
		//		id='".$this->id."' style='text-align: center; overflow: none; margin: 2px; float: left; font-size: 12px; height: ".($size + 20)."px; width: ".($size + ($size/2))."px; border: 1px dotted #CCC;'>";
			
			if($this->MIME_Type == 'image/x-raw') {
					//echo link_to("<h3>".$this->File_Name."</h3>", array('controller'=>'metapic','action'=>'show'.$full,'id'=>$this->id));
					
					$img = "<img  src='".$baseurl."phpThumb/phpThumb.php?src=/".thumbnails.$file.".jpg&h=$size&w=".($size + ($size/2))."' />";
					$thumbnail = $baseurl."phpThumb/phpThumb.php?src=/".thumbnails.$file.".jpg&h=$size&w=".($size + ($size/2));
			} elseif($image === false) { 
					$img = "<img  src='".$baseurl."phpThumb/phpThumb.php?src=/".$file."&h=$size&w=".($size + ($size/2))."' />";
					$thumbnail =$baseurl."phpThumb/phpThumb.php?src=/".$file."&h=$size&w=".($size + ($size/2));
				//	echo link_to("<h3>".$this->File_Name."</h3>", array('controller'=>'metapic','action'=>'show'.$full,'id'=>$this->id));
			
			}
	 	/*
			if($noprint) {
			echo "<a id='".$this->id."_link' onMouseUp='window.location = \"".$baseurl."metapic/show".$full."/$this->id\"' style='cursor:pointer;'>";
			echo $img;
			echo "<br/>".$this->File_Name;
			
			echo "</a>";
			
			
		
		
			
		
			echo "<br/>";
			//echo $this->File_Name;
			echo "\n";
			
			echo "<script>
			
			new Draggable('$this->id',{revert: true, ghosting:false,
				starteffect: scrollStart,
				  endeffect: scrollEnd, 
				onStart:function(e) { document.getElementById('".$this->id."_link').onmouseup = drag_box; }, 
				onEnd:function(e) { document.getElementById('".$this->id."_link').onmouseup = function() { window.location = \"".$baseurl."metapic/show".$full."/$this->id\" } } } );
			</script>";
			
		
			
		echo "</div>";
		
		
		}
		*/
		return $thumbnail;
	}
	
}
?>