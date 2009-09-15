<?php 
$_REQUEST['layout'] = 'main';



function users_index() {
	
	users_list();
	
}

function users_logout() {
	
	setcookie("print_remember_me","",time()-999999,"/");
	session_destroy();
	
	render('login');
	
}

function users_login() {
	global $errors;
	
	if($_POST) {
	
	
		if(authenticate($_POST['username'],$_POST['password'])) {
			
			
			
		
			$user = new User;
			$user = $user->find('WHERE login = "'.$_POST['username'].'"');
			print_r($user);
			if(isset($_POST['remember_me']) && $_POST['remember_me'] == 1) {
				//Here we are going to set a cookie on the browser, expire it really far in the future, and store a random hash in the database
				$hash = md5(time());
				setcookie("print_remember_me", $hash, time()+30758400,'/');
				$user[0]->login_token = $hash;
				$user[0]->save();
			}
			
			$_SESSION['user_id'] = $user[0]->id;
			$_SESSION['current_user'] = $user[0];
			global $baseurl;
			
			$_SESSION['redirect_to'] = array($_SESSION['old_controller'],$_SESSION['old_action']);
			//print_r($_SESSION);
			
			
			if($_POST['password'] == 'picsloan') {
				//Change from the default PASSWORD!!
			//	$_SESSION['redirect_to'] = array($_REQUEST['old_controller'],$_REQUEST['old_action']);
			
				
				header('Location: '.$baseurl.'users/reset_password/?a=default');
				exit();
			}
			
			if(isset($_SESSION['redirect_to'])) {
			
				$location = 'Location: '.$baseurl.$_SESSION['redirect_to'][0]."/".$_SESSION['redirect_to'][1];
				$_SESSION['redirect_to'] = "";
				
			
				header($location);
			} else {
				header('Location: '.$baseurl);
			}
		} else {
			$errors = 'There was an error in your login';
		}
 	}
	
	if($_GET['id'] == 'resource') {
		$errors = "The resource you were trying to access has been protected. Please login to gain access.";
	}
	
	render();
}


function users_list() {
	$_GET['action'] = 'list';
	global $users;
	$user = new User;
	$users = $user->find();
	
   	render();
}

function users_new() {

	if($_POST) {
		$user = new User;
		$user->save($_POST);
		
		render('show',$user->id);
		
	}	
	
	render();
}


function users_show() {
	
	global $user;
	$user = new User;
	$user = $user->find($_GET['id']);
	
	
	render();
}


function users_profile() {
	global $user;

	if($_POST){
		$user->save($_POST);
	
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
		if($user->printreview == '1') {
			mc_add($user,'printreview');
		} else {
			mc_remove($user,'printreview');
		}
	}
	
	render();
}


function users_edit() {
	
	global $user;
	$user = new User;
	$user = $user->find($_GET['id']);
	
	if($_POST) {
	
		if($user->save($_POST)) {
			
			//We need to update the bash script
			
	
			
			render('show',$_GET['id']);
		}
	}
	
	render();
}



function users_delete() {
	global $user;
	$user = new User;
	$user = $user->find($_GET['id']);
	
	if($user->delete()) {
		render('list');
	}
}

function users_forgot_password() {
	
	if($_POST['email']) {
		$user = new User;
		$user = $user->find('WHERE email = "'.$_POST['email'].'"');
		
		if($user) {
			//Ok, we have a legit user.
			$user = $user[0];
		
			$user->remember_token = md5(time());
			$user->remember_token_expires_at = time() + 24 * 60 * 60;
		
			$arr_email['displayname'] = $user->first." ".$user->last;
			$arr_email['token'] = $user->remember_token;
 			$arr_email['login'] = $user->login;
			send_message('users/forgot_password',$user->email,$arr_email,"Password Reset request");
			
			$user->save();
			
			render('password_email_sent');
		} else {
			global $errors;
			$errors = "That email address is not in our system";
			render();
		}
	
	
	} else {
		render();
	}
}

function users_password_email_sent() {
	render();
}

function users_reset_password() {
	global $baseurl;

	
	if($_POST['password1']) {
		
			$users = new User();
			$users = $users->find('WHERE remember_token = "'.$_GET['id'].'"');
			
			if($_SESSION['current_user']) {
				//Already logged in
				$users[0] = $_SESSION['current_user'];
			}
			
			if($users) {
				//
				//Lets set the new password
				$user = $users[0];
				$salt = chr(rand(65,90)) .chr(rand(65,90)) .chr(rand(65,90)) .chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90));

				$salt = md5($salt);
				$user->salt = $salt;
				$user->crypted_password = md5($_POST['password1'].$salt);
				$user->remember_token = "";
				$user->remember_token_expires_at = "";
				$user->save();
				
				if($_SESSION['redirect_to']) {
					$location = 'Location: '.$baseurl.$_SESSION['redirect_to'][0]."/".$_SESSION['redirect_to'][1];
					header("Location: $location");
				}
				
				render('password_done');
				
			}
		
	} else {
		
		$users = new User();
		$users = $users->find('WHERE remember_token = "'.$_GET['id'].'"');
		
		if($users) {
			global $user;
			$user = $users[0];
			render();
		}
	}
}

function users_newsletter() {
	global $news_user;
	
	
	
	if(isset($_GET['email']) && !empty($_GET['email'])) {
		
		$news_user = new User();
		$news_user = $news_user->find('WHERE email = "'.trim(urldecode($_GET['email'])).'"');
		$news_user = $news_user[0];
		if(empty($news_user)) {
			global $error;
			$error = 'No valid email address';
		}
		if($_POST && isset($_POST['ereview'])) {
			$news_user->ip_newsletter = $_POST['ip_newsletter'];
			$news_user->ereview = $_POST['ereview'];
				if($news_user->ereview == '1') {
					mc_add($news_user,'ereview');
				} else {
					mc_remove($news_user,'ereview');
				}
					if($news_user->ip_newsletter == '1') {
						mc_add($news_user,'ipn');
					} else {
						mc_remove($news_user,'ipn');
					}
			$news_user->save();
			global $error;
			$error = 'Your preferences have been saved!';
		}
		
	}	
	render();
}

function users_password_done() {
	render();
}
function authenticate($user,$password) {
	//First we need find if this user even exists
	
	$users = new User();
	$users = $users->find('WHERE login = "'.$user.'"');
	

	
	if(count($users) == 1) {
				
		if(md5($password.$users[0]->salt) == $users[0]->crypted_password) {
			return true;
		} else {
			return false;
		}
	} else {
		return false;
	}
}



?>
