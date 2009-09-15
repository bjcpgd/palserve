<?php


function mc_add($user,$list='ereview') {
	global $mc_username;
	global $mc_password;
	global $listId;
	
	

	
	$ids=array('ereview'=>'a23c6fb80f','ipn'=>'414085dc7c','ip_rep'=>'0816d91a99');
	$fields=array(
		"ereview"=>array(
			"first"=>"FNAME",
			"last"=>"LNAME",
			"company"=>"COMPANY"
			),
		"ipn"=>array(
			"first"=>"FNAME",
			"last"=>"LNAME",
			"company"=>"COMPANY"
			),
		"printreview"=>array(
			"first"=>"FNAME",
			"last"=>"LNAME",
			"company"=>"COMPANY",
			"title"=>"TITLE",
			"address1"=>"ADDRESS1",
			"address2"=>"ADDRESS2",
			"city"=>"CITY",
			"state"=>"STATE",
			"zip"=>"ZIP",
			"country"=>"COUNTRY"
			),
		"ip_rep"=>array(
			"first"=>"FNAME",
			"last"=>"LNAME",
			"company"=>"COMPANY",
			"title"=>"TITLE",
			"address1"=>"ADDRESS1",
			"address2"=>"ADDRESS2",
			"city"=>"CITY",
			"state"=>"STATE",
			"zip"=>"ZIP",
			"country"=>"COUNTRY"
			)
		);
	$listId = $ids[$list];
	
	$api = new MCAPI($mc_username, $mc_password);
	if ($api->errorCode!=''){
		// an error occurred while logging in
		echo "code:".$api->errorCode."\n";
		echo "msg :".$api->errorMessage."\n";
		die();
	}


	//$merge_vars = array('FNAME'=>$user->first,'LNAME'=>$user->last,"INTERESTS"=>'');
	
	foreach($fields[$list] as $o=>$m) {
		
	//	if($o == "zip") {
	//		if($user->country != 'US') {
	//			$o = 'zip';
	//		}
	//	}
		
		$merge_vars[$m] = $user->$o;
		
	}


	$retval = $api->listSubscribe( $listId, $user->email, $merge_vars,'html',false,true,true);

	if (!$retval){
		echo "Unable to load listSubscribe()!\n";
		echo "\tCode=".$api->errorCode."\n";
		echo "\tMsg=".$api->errorMessage."\n";
	} else {
	    //echo "Returned: ".$retval."\n";
	}
	
	
}

function mc_remove($user,$list='ereview') {
	global $mc_username;
	global $mc_password;
	global $listId;
	
	$ids=array('ereview'=>'a23c6fb80f','ipn'=>'414085dc7c','ip_rep'=>'0816d91a99');
	
	$listId = $ids[$list];
	
	
	// Connect to the MailChimp server with the user's credentials.
	$api = new MCAPI($mc_username, $mc_password);
	if ($api->errorCode!=''){
		// an error occurred while logging in
		//echo "code:".$api->errorCode."\n";
	//	echo "msg :".$api->errorMessage."\n";
		die();
	}

	$retval = $api->listUnsubscribe( $listId,$user->email,false,false);
	if (!$retval){
	  //  echo "Unable to load listUnsubscribe()!\n";
	//	echo "\tCode=".$api->errorCode."\n";
	//	echo "\tMsg=".$api->errorMessage."\n";
	} else {
	  //  echo "Returned: ".$retval."\n";
	}
	
}


function sync_mailchimp() {
	
	$users = new User();
	$users = $users->find();
	
	foreach($users as $user) {
		
	set_time_limit(30);
	echo ' . ';
	ob_flush();
	flush();
			if($user->ereview == '1') {
				mc_add($user,'ereview');
			} else {
				mc_remove($user,'ereview');
			}
			if($user->ip_newsletter == '1') {
				mc_add($user,'ipn');
			} else {
				mc_remove($user,'ipn');
			}
		
			if($user->ip_rep == '1') {
				mc_add($user,'ip_rep');
			} else {
				mc_remove($user,'ip_rep');
			}
			
		
	}
	
}


function stylesheet($name,$type) {
	global $baseurl;
	
	$cssstring = '<link href="'.$baseurl."/stylesheets/$name.css?t=".time()."".'" media="'.$type.'" rel="Stylesheet" type="text/css" />';

	
	return $cssstring;
}

function start() {
	global $yield;
	
	$controller = $_GET['controller'];
	$action = $_GET['action'];
	
	//parse the REQUEST_URI
	//Add any varibles to the _GET variable
	
	$data = split("\?",$_SERVER['REQUEST_URI']);
	$pairs = split("&",$data[1]);
	
	foreach($pairs as $d) {
		$val = split("=",$d);
		$_GET[$val[0]] = $val[1];
	}
	
	
	if(empty($action)) { $action = 'index'; }
	include('controllers/'.$controller.".php");	
	
	$func = $controller."_".$action;
	
	
	$func();
	

}

function strip_slashes_recursive( $variable )
{
    if ( is_string( $variable ) ) {
		
        return stripslashes( $variable ) ;
	}
    if ( is_array( $variable ) ) {
        foreach( $variable as $i => $value ) {
			
            $variable[ $i ] = strip_slashes_recursive( $value ) ;
		}
   }
    return $variable ;
}

function link_to($txt,$options) {
	global $baseurl;
	
	if(isset($options['confirm'])) {
		$confirm = "onClick='return confirm(\"".$options['confirm']."\"); return false' ";
	} else {
		$confirm = "";
	}
	
	return "<a href='$baseurl".$options['controller']."/".$options['action']."/".urlencode(htmlspecialchars($options['id'],ENT_QUOTES))."' 	$confirm >$txt</a>";
	
}

function partial($file) {
	$file = str_replace("/","/_",$file);
	include("views/".$file.".php");
}

function render($action=null,$id=null) {

	global $layout;
	global $view;
	

	if(function_exists('prerender')) {
	
		prerender();
	}
	
	$rewrite = false;
	if($action != null) {
		$rewrite = true;
		$_GET['action'] = $action;
	}
	
	if($id != null) {
		$_GET['id'] = $id;
	}

	if($rewrite) {
		global $baseurl;
		header("Location: ".$baseurl.$_GET['controller']."/$action/$id");
	}
	
	if(empty($_REQUEST['layout'])) {
		$_REQUEST['layout'] = 'none';
 	}	
	
	include('views/'.$_REQUEST['layout'].".php");

}


function yield() {
	
	$controller = $_GET['controller'];
	$action = $_GET['action'];
	
	include('views/'.$controller.'/'.$action.'.php');
	
	
}

function pager($count) {
	global $perpage;
	
	if(empty($perpage)) {
		$perpage = 5;
	}
	
		$url = parse_url($_SERVER['SCRIPT_URI'].$_SERVER['REQUEST_URI']);
		parse_str($url['query'],$args);
	
	$pages = ceil($count/$perpage);
	

	
	if(isset($args['p'])) {
		$currentpage = $args['p'];
	} else {
		$currentpage = 1;
	}
	
	
	
	if($currentpage > 1) {
		
			$link = str_replace("p=$currentpage","p=".($currentpage-1),$_SERVER['REQUEST_URI']);

			if($currentpage == '') {
				if(stristr($link,'?')) {
					$link .= "&p=".($currentpage-1);
				} else {
					$link .="?p=".($currentpage-1);
				}
			}
		
		echo "<span><strong><a href='$link'>Previous<a/></strong></span>";
	}
	
	for($i=1;$i<=$pages;$i++) {

		
		
		$link = str_replace("p=$currentpage","p=$i",$_SERVER['REQUEST_URI']);
		
		
		if($currentpage == 1) {
			
			if(stristr($link,'?')) {
				$link .= "&p=$i";
			} else {
				$link .="?p=$i";
			}
		}
		
		if($i == $currentpage) {
		echo "<span> <strong>$i</strong> </span> ";
		} else {
			echo "<span> <a href='$link'>$i</a> </span> ";
		}
	}
	
	
	if($currentpage < $pages) {
		
			$link = str_replace("p=$currentpage","p=".($currentpage+1),$_SERVER['REQUEST_URI']);

			/*
				if(stristr($link,'?')) {
					$link .= "&p=".($currentpage+1);
				} else {
					$link .="?p=".($currentpage+1);
				}
		*/
		
		echo "<span><strong><a href='$link'>Next<a/></strong></span>";
	}
	
	echo "<h4>Page $currentpage of $pages</h4>";
	
	echo '</div>';
	
}

function chooseDate($timestamp = "",$prefix="date"){

    if($timestamp == "" || $timestamp == 0){
        $timestamp = time();
    }
    $months = array(null, 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
    unset($months[0]);
    
    $out = '<select name="'.$prefix.'[month]">';
    foreach($months as $key => $month){
        if($month == date('M', $timestamp)){
            $out .= '<option value="'.$key.'" selected="selected">'.$month.'</option>';
        }else{
            $out .= '<option value="'.$key.'">'.$month.'</option>';
        }
    }
    $out .= '</select><select name="'.$prefix.'[day]">';
    for($i = 1; $i <= 32; $i++){
        if($i == date('j', $timestamp)){
            $out .= '<option value="'.$i.'" selected="selected">'.$i.'</option>';
        }else{
            $out .= '<option value="'.$i.'">'.$i.'</option>';
        }
    }
    $out .= '</select><select name="'.$prefix.'[year]">';
    for($i = date('Y'); $i >= 1970; $i--){
        if($i == date('Y', $timestamp)){
            $out .= '<option value="'.$i.'" selected="selected">'.$i.'</option>';
        }else{
            $out .= '<option value="'.$i.'">'.$i.'</option>';
        }
    }
    $out .= "</select>";
	//Added by brad
	$out .= '</select> - <select name="'.$prefix.'[hour]">';
    for($i = 1; $i <= 12; $i++){
        if($i == date('h', $timestamp)){
            $out .= '<option value="'.$i.'" selected="selected">'.$i.'</option>';
        }else{
            $out .= '<option value="'.$i.'">'.$i.'</option>';
        }
    }
    $out .= "</select>";
	$out .= '</select>:<select name="'.$prefix.'[minute]">';
    for($i = 0; $i <= 60; $i++){
        if($i == date('i', $timestamp)){
            $out .= '<option value="'.$i.'" selected="selected">'.$i.'</option>';
        }else{
            $out .= '<option value="'.$i.'">'.$i.'</option>';
        }
    }
    $out .= "</select>";
	$out .= ':<select name="'.$prefix.'[meridiem]">';
	$ampm = array("AM","PM");
    foreach($ampm as $i) {
        if($i == date('A', $timestamp)){
            $out .= '<option value="'.$i.'" selected="selected">'.$i.'</option>';
        }else{
            $out .= '<option value="'.$i.'">'.$i.'</option>';
        }
    }
    $out .= "</select>";
    return $out;
}

function require_login($property=null) {
	global $baseurl;
	if(!isset($_SESSION['current_user']) || $_SESSION['current_user'] == "") {
		
			global $baseurl;
			$_SESSION['redirect_to'] = array($_REQUEST['controller'],$_REQUEST['action']);
			header("Location: ".$baseurl."/users/login/resource");
	
	} else {
			
			
		
			if($property != null) {
			
				if($_SESSION['current_user']->$property == 1) {
					return true;
				} else {
					header("Location: ".$baseurl."pages/unauthorized");
					return false;
				}
			}
			
			
			if( $_SESSION['current_user']->status != 'Partner') {
				header("Location: ".$baseurl."pages/unauthorized");
				return false;
			}
			
		return true;
	}
	
	exit();
}

function printTagCloud($tags,$max_size=32,$min_size=12) {
        // $tags is the array
       
   
   
       
        // largest and smallest array values
        $max_qty = max(array_values($tags));
        $min_qty = min(array_values($tags));
       
        // find the range of values
        $spread = $max_qty - $min_qty;
        if ($spread == 0) { // we don't want to divide by zero
                $spread = 1;
        }
       
        // set the font-size increment
        $step = ($max_size - $min_size) / ($spread);
       
        // loop through the tag array
	
        foreach ($tags as $key => $value) {
                // calculate font-size
                // find the $value in excess of $min_qty
                // multiply by the font-size increment ($size)
                // and add the $min_size set above
                $size = round($min_size + (($value - $min_qty) * $step));
       	
		 if($value > 1) {
          $mainTags[$key]['value'] = $value;
		  $mainTags[$key]['size'] = $size;
		} else {
          $subTags[$key]['value'] = $value;
		  $subTags[$key]['size'] = $size;
		}
			
        }
	
	return array("main"=>$mainTags,"sub"=>$subTags);
}



function send_message($template,$address_to,$arguments,$subject="RIT Printing Industry Center") {
	
	$contents = file_get_contents('views/'.$template.".eml");
	
	foreach($arguments as $key=>$value) {
		
		$contents = str_replace("$".$key,$value,$contents);
		
	}
	$headers = 'From: RIT Printing Industry Center <aswppr@rit.edu>' . "\r\n";
	mail($address_to,"RIT Printing Industry Center: ".$subject,$contents,$headers);
	
}

function convert_smart_quotes($string)
{
$search = array(chr(145),
chr(146),
chr(147),
chr(148),
"class=\"body_1214\"",
"class=body_1214");

$replace = array("'",
"'",
'"',
'"',
'-',
"",
"");

return str_replace($search, $replace, $string);
}

function objSort(&$objArray,$indexFunction,$field,$sort_flags=0) {
    $indices = array();
    foreach($objArray as $obj) {
        $indeces[] = $indexFunction($obj,$field);
    }
    return array_multisort($indeces,$objArray,$sort_flags);
}

function getIndex($obj,$field) {
    return $obj->$field;
}


function snippet($text,$length=64,$tail="...") {
    $text = trim($text);
    $txtl = strlen($text);
    if($txtl > $length) {
        for($i=1;$text[$length-$i]!=" ";$i++) {
            if($i == $length) {
                return substr($text,0,$length) . $tail;
            }
        }
        $text = substr($text,0,$length-$i+1) . $tail;
    }
    return $text;
}

function HideEmail($user, $host, $subject = '') {
    $MailLink = '<a href="mailto:' . $user . '@' . $host;
    if ($subject != '')
      $MailLink .= '?subject=' . urlencode($subject);
    $MailLink .= '">' . $user . '@' . $host . '</a>';
    
    $MailLetters = '';
    for ($i = 0; $i < strlen($MailLink); $i ++)
    {
    $l = substr($MailLink, $i, 1);
    if (strpos($MailLetters, $l) === false)
    {
        $p = rand(0, strlen($MailLetters));
        $MailLetters = substr($MailLetters, 0, $p) .
          $l . substr($MailLetters, $p, strlen($MailLetters));
    }
    }
    
    $MailLettersEnc = str_replace("\\", "\\\\", $MailLetters);
    $MailLettersEnc = str_replace("\"", "\\\"", $MailLettersEnc);

    $MailIndexes = '';
    for ($i = 0; $i < strlen($MailLink); $i ++)
    {
    $index = strpos($MailLetters, substr($MailLink, $i, 1));
    $index += 48;
    $MailIndexes .= chr($index);
    }
    $MailIndexes = str_replace("\\", "\\\\", $MailIndexes);
    $MailIndexes = str_replace("\"", "\\\"", $MailIndexes);
    
?><SCRIPT LANGUAGE="javascript"><!--
ML="<?= $MailLettersEnc ?>";
MI="<?= $MailIndexes ?>";
OT="";
for(j=0;j<MI.length;j++){
OT+=ML.charAt(MI.charCodeAt(j)-48);
}document.write(OT);
// --></SCRIPT><NOSCRIPT>Sorry, you need javascript to view this email address</noscript><?PHP
}

function HideEmailWithName($name, $user, $host) {
    print $name . " &lt;";
    HideEmail($user, $host);
    print "&gt;";
}


?>