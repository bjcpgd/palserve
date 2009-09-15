<?php 
$_REQUEST['layout'] = 'main';



function newsletters_index() {
	
	
	render('signup');
}


function newsletters_done() {
	
	render();
}

function newsletters_signup() {

	if($_SESSION['current_user']) {
		$_GET['controller'] = 'users';
		render('profile');
	}
	
	if($_POST) {
		
		include_once("submitTroughImage.class.php");
          $sti = new submitTroughImage();
		
			if($sti->checkPost() === true) {
			//if(true) {
				//We are going to create a 'USER' for this newsletter signup, their username will be their email address
			
				
				$user = new User();
				$user->login = $_POST['email'];
				$user->email = $_POST['email'];
				$user->is_admin = 0;
				$user->displayname = $_POST['firstname']." ".$_POST['lastname'];
				$user->first = $_POST['firstname'];
				$user->last = $_POST['lastname'];
				$user->company = $_POST['company'];
				$user->title = $_POST['title'];
				$user->address1 = $_POST['address1'];
				$user->address2 = $_POST['address2'];
				if($_POST['geography'] == 'US') {
					$user->postal = $_POST['zip'];
					$user->country = 'US';
					$user->state = $_POST['state'];
				} else {
					$user->postal = $_POST['postal'];
					$user->country = $_POST['country'];
					$user->province = $_POST['province'];
				}
				
				if($_POST['alumnus'] == 'yes') {
					$user->alumni = 1;
					$user->year = $_POST['year'];
				}
				
				if($_POST['e_review'] == 'on') {
					$user->ereview = '1';
				}
				
				if($_POST['print_review'] == 'on') {
					$user->print_review = '1';
				}
				
				$user->partner = 0;
				$user->status = 'Newsletter';
				
				
			
			
				
				if($user->ereview == '1') {
					mc_add($user);
				} else {
					mc_remove($user);
				}
				
 				
				$user->save();
				render('done');
				
			} else {
				$error = 'Please try the captcha again';
			}
		
		

	}
	
	render();
}
?>