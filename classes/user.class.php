<?php

global $login_required;
$login_required = array(
	'hosts' => '*',
	'users' => array('list','edit','delete','show','new','profile')
	);

//Init current user if it exists
if(isset($_SESSION['user_id'])) {
	$user = new User;
	$user = $user->find($_SESSION['user_id']);
	
	$_SESSION['current_user'] = $user;	
}

class User extends arecord {
	
//	public $hasmany = array("user_alert_preference");
	
	function user() {
		
	}
	
}

function users_web_hook() {
	
	if($_GET['secret'] == '324lkjsdfglu209340109ajkfakjhdfskjlgh') {
		if($_POST) {
			if($_POST['type'] == 'unsubscribe') {
				
				//Update the user in the database
				$ids=array('a23c6fb80f'=>'ereview','414085dc7c'=>'ip_newsletter','0816d91a99'=>'ip_rep');
				
				$user = new User();
				$user = $user->find("WHERE email = '".$_POST['data']['email']."'");
				$user = $user[0];
				
				$attr = $ids[$_POST['data']['list_id']];
				if(!empty($user) && !empty($attr)) {
					$user->$attr = 0;
					$user->save();
				}
			
				
			}
			
		}
		
	}
	
	
	
}

function prerender() {

	global $login_required;
	global $current_user;
	

	if(!$_SESSION['user_id'] > 0) {
	
		$gotologin = false;
		
		
		if( $login_required[ $_GET['controller'] ] == '*' ) { $gotologin = true; }
		
		if( is_array ($login_required[ $_GET['controller'] ] ) && in_array( $_GET['action'],$login_required[ $_GET['controller'] ] ) )  { $gotologin = true; }
				
		if($gotologin) {
			
			$_SESSION['old_controller'] = $_GET['controller'];
			$_SESSION['old_action'] = $_GET['action'];
		
			global $baseurl;
			
			header('Location: '.$baseurl."users/login/");
			
			global $errors;
			$errors = "You must login to get to this screen";
			
		}
	} else {
		//User is set, if old_controller and such exist
		global $errors;
		global $current_user;
		
		$current_user = new User;
		$current_user = $current_user->find($_SESSION['user_id']);
	
		
		if(isset($_SESSION['old_controller'])) {
			$old_action = $_SESSION['old_action'];
			$old_controller = $_SESSION['old_controller'];
		
			unset($_SESSION['old_action']);
			unset($_SESSION['old_controller']);
			
			global $baseurl;
			header("Location: ".$baseurl."".$old_controller."/".$old_action);
		}
	}
	
	
}

?>