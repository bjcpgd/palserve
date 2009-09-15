<?php
$_REQUEST['layout'] = 'main';


function pages_index() {
	
	if(!isset($_REQUEST['by_name'])) {
		$_REQUEST['by_name'] = 'home';
	}
	
	render();
		
}

function pages_by_name() {
	
	
	//First check to see if its a file
	if(empty($_GET['id'])) { $_GET['id'] = 'home'; }
	if(isset($_GET['arg1']) && $_GET['arg1'] != "")  {
		$_GET['id'] = $_GET['id']."/".$_GET['arg1'];
		//echo 'here';
	}
	
	
	if(is_file('views/pages/'.$_GET['id'].".php")) {
		render('pages',$_GET['id']);
	}
	
	$pages = new Page();

	$pages = $pages->find("WHERE name ='".$_GET['id']."'");
	
	if(empty($pages)) {
			$pages = new Page();
		$pages = $pages->find("WHERE name ='". str_replace(" ","_",$_GET['id']) ."'");
	}
	
	if(empty($pages)) {
		$pages = new Page();
		header("HTTP/1.0 404 Not Found");
		$pages = $pages->find("WHERE name='404'");
	}
 	$page = "";
	global $page;
	$page = array_pop($pages);

	if($page->protected) {
		require_login();
		render();
	} else {
		render();
	}
}

function pages_feedback_submit() {
	
	$from = $_POST['from_email'];
	$message = $_POST['message'];
	$subject = 'Feedback from print.rit.edu';
	
	if(strtolower($_POST['question']) == 'two' || $_POST['question'] == '2') {
		mail('bjcpgd@rit.edu',$subject,$message);
	} else {
		render('feedback_error');
		exit();
	}
	
	render('feedback');
}


function pages_feedback_error() {
	
	
	
	render();
}

function pages_feedback() {
	
	
	render();
}

function pages_unauthorized() {
	
	render();
}

function pages_admin() {
	
}


?>