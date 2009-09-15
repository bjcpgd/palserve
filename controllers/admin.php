<?php
$_REQUEST['layout'] = 'admin';

require_login('is_admin');

function admin_index() {
	
	render('dashboard');
}

function admin_dashboard() {
	render();
}

//Start News

function admin_news_list() {
	
	global $news;
	
	$news = new News();
	$news = $news->find('ORDER BY created_on DESC');
	
	render();
	
}

function admin_news_create() {
	
	
	if(isset($_REQUEST['create'])) {
		$news = new News();
		$news->title = $_REQUEST['title'];
		$news->content = $_REQUEST['content'];
		$news->tags = $_REQUEST['tags'];
		$news->protected = $_REQUEST['protected'];
			$news->custom_sidebar = $_POST['custom_sidebar'];
		
			if($_POST['start_date_check'] == 1) {
			$news->start_date = strtotime( $_POST['start_date']['year']."-".$_POST['start_date']['month']."-".$_POST['start_date']['day']."  ".str_pad($_POST['start_date']['hour'],2,"0",STR_PAD_LEFT).":".str_pad($_POST['start_date']['minute'],2,"0",STR_PAD_LEFT)."".$_POST['start_date']['meridiem']);
		} else {
			$news->start_date = 0;
		}

			if($_POST['end_date_check'] == 1) {
				$news->end_date = strtotime( $_POST['end_date']['year']."-".$_POST['end_date']['month']."-".$_POST['end_date']['day']."  ".str_pad($_POST['end_date']['hour'],2,"0",STR_PAD_LEFT).":".str_pad($_POST['end_date']['minute'],2,"0",STR_PAD_LEFT)."".$_POST['end_date']['meridiem']);
			} else {
				$news->end_date = 0;
			}

		
		
		
		$news->save();
		
			$news->created_on = date("Y-m-d H:i:s",strtotime($_POST['created_on']['year']."-".$_POST['created_on']['month']."-".$_POST['created_on']['day']."  ".str_pad($_POST['created_on']['hour'],2,"0",STR_PAD_LEFT).":".str_pad($_POST['created_on']['minute'],2,"0",STR_PAD_LEFT)."".$_POST['created_on']['meridiem']));
			
		$news->save();
			
		render('news_list');
		return true;
	}
	
	
	render();
}

function admin_news_delete() {
	$news = new News();

	
	
	$id = $_REQUEST['id'];
	$news = $news->find($id);
	$news->delete();
	
	
	
	render('news_list');
}

function admin_news_edit() {
	
	global $news;
	
	$news = new News();
	$news = $news->find($_REQUEST['id']);
	

	render();
}

function admin_news_update() {
	$news = new News();


	$news = $news->find($_REQUEST['id']);
	
	if($_POST['start_date_check'] == 1) {
	

	
	$news->start_date = strtotime( $_POST['start_date']['year']."-".$_POST['start_date']['month']."-".$_POST['start_date']['day']."  ".str_pad($_POST['start_date']['hour'],2,"0",STR_PAD_LEFT).":".str_pad($_POST['start_date']['minute'],2,"0",STR_PAD_LEFT)."".$_POST['start_date']['meridiem']);
	

	} else {
		$news->start_date = 0;
	}
	
	if($_POST['end_date_check'] == 1) {
		$news->end_date = strtotime( $_POST['end_date']['year']."-".$_POST['end_date']['month']."-".$_POST['end_date']['day']."  ".str_pad($_POST['end_date']['hour'],2,"0",STR_PAD_LEFT).":".str_pad($_POST['end_date']['minute'],2,"0",STR_PAD_LEFT)."".$_POST['end_date']['meridiem']);
	} else {
		$news->end_date = 0;
	}
	
	$news->created_on = date("Y-m-d H:i:s",strtotime($_POST['created_on']['year']."-".$_POST['created_on']['month']."-".$_POST['created_on']['day']."  ".str_pad($_POST['created_on']['hour'],2,"0",STR_PAD_LEFT).":".str_pad($_POST['created_on']['minute'],2,"0",STR_PAD_LEFT)."".$_POST['created_on']['meridiem']));

	$news->content = $_REQUEST['content'];
	$news->title = $_REQUEST['title'];
	$news->tags = $_REQUEST['tags'];
	$news->protected = $_REQUEST['protected'];
	$news->sidebar = $_POST['sidebar'];
	$news->custom_sidebar = $_POST['custom_sidebar'];

	global $dba;
	$news->save();
	render('news_edit',$news->id);

	
}

//Start Research

function admin_research_list() {
	global $projects;

	$projects = new Project();
	$projects = $projects->find();
	
	
	render();
}

function admin_research_create() {
	
	
	
	render();
}

function admin_research_delete() {
	$project = new Project();
	$project = $project->find($_GET['id']);
	$project->delete();
	
	render('research_list');
}

function admin_research_edit() {
	global $project;
	
	$project = new Project();
	$project = $project->find($_REQUEST['id']);
	
	
	render();
}

function admin_research_update() {




	$project = new Project();
	
	if(!empty($_REQUEST['id'])) {
		$project = $project->find($_REQUEST['id']);
	}
	

	if($_FILES['upload']) {
		
	
		//A file has been uploaded, lets do some checks.
		if (stristr($_FILES['upload']['name'],'.pdf') && $_FILES['upload']['type'] == 'application/binary')  {
			//Ok this is a PDF file
			
			
			move_uploaded_file($_FILES['upload']['tmp_name'],'pubs/'.$_FILES['upload']['name']);
			
			chmod('pubs/'.$_FILES['upload']['name'],0444);
			
			$project->monograph = 'pubs/'.$_FILES['upload']['name'];
			
			$project->save();
		
		}
		
	}
	

	
	if(isset($_POST['id']) && isset($_POST['title']) && isset($_POST['content'])) {
		if(!isset($project)) {
			$project = new Project();
			$project = $project->find($_REQUEST['id']);
		}
	
		
		$project->title = $_POST['title'];
		$project->abstract = $_POST['content'];
		$project->projectnumber = $_POST['projectnumber'];
		$project->year = $_POST['year'];
		$project->tags = $_POST['tags'];
		
		$project->save();
	}
	
	if(isset($_POST['person_id'])) {
				
		$project->person_id = $_POST['person_id'];
		
		$project->save();
		
	}
	
	if(isset($_POST['area_id'])) {
		$project->area_id = $_POST['area_id'];
		
		$project->save();
	}
	

	render('research_edit',$project->id);
}

function admin_research_area() {
	if(isset($_POST['delete'])) {
		
		$areas = new Areas;
		if($a = $areas->find($_POST['delete']['area_id'])) {
		$a->delete();
		}
	}
	
	
	if(isset($_POST['edit'])) {
			$areas = new Areas;
			if($a = $areas->find($_POST['edit']['area_id'])) {
				$a->name = $_POST['edit']['name'];
				$a->description = $_POST['edit']['description'];
				$a->display = $_POST['edit']['display'];
				$a->save();
			}
	}
	
	
	if(isset($_POST['new'])) {
		$a = new Areas();
		$a->name = $_POST['new']['name'];
		$a->description = $_POST['new']['description'];
		$a->display = $_POST['new']['display'];
		$a->save();
				
	}


	global $areas;
	$areas = new Areas();
	$areas = $areas->find();
	

	
	render();
}

function admin_research_authors() {
	
	global $authors;
	$authors = new Authors();
	$authors = $authors->find();
	
	render();
}

//End Research


//Publications

function admin_publication_list() {
	global $publications;

	$publications = new publication();
	$publications = $publications->find();
	
	
	render();
}

function admin_publication_create() {
	
	
	
	render();
}

function admin_publication_delete() {
	$publication = new publication();
	$publication = $publication->find($_GET['id']);
	$publication->delete();
	
	render('publication_list');
}

function admin_publication_edit() {
	global $publication;
	
	$publication = new publication();
	$publication = $publication->find($_REQUEST['id']);
	
	
	render();
}

function admin_publication_update() {


	

	$publication = new publication();
	
	if(!empty($_REQUEST['id'])) {
		$publication = $publication->find($_REQUEST['id']);
	}
	

	if($_FILES['upload']) {
		
	
		//A file has been uploaded, lets do some checks.
		if (stristr($_FILES['upload']['name'],'.pdf') && $_FILES['upload']['type'] == 'application/binary')  {
			//Ok this is a PDF file
			
			
			move_uploaded_file($_FILES['upload']['tmp_name'],'pubs/'.$_FILES['upload']['name']);
			
			chmod('pubs/'.$_FILES['upload']['name'],0444);
			
			$publication->monograph = 'pubs/'.$_FILES['upload']['name'];
			
			$publication->save();
		
		}
		
	}
	

	
	if(isset($_POST['id']) && isset($_POST['title']) && isset($_POST['content'])) {
		if(!isset($publication)) {
			$publication = new publication();
			$publication = $publication->find($_REQUEST['id']);
		}
	
		
		$publication->title = $_POST['title'];
		$publication->content = $_POST['content'];
		$publication->year = $_POST['year'];
		$publication->tags = $_POST['tags'];
		$publication->sync_project = $_POST['sync_project'];
		$publication->publisher = $_POST['publisher'];
		$publication->isbn = $_POST['isbn'];
		$publication->image = $_POST['image'];
		
		if(isset($_POST['make_project']) && empty($publication->project_id) ) {
			
			$mp = new Project();
			
				$mp->title = $publication->title;
				$mp->abstract = $publication->content;
				$mp->year = $publication->year;
				$mp->tags = $publication->tags;
				$mp->person_id = $_POST['person_id'];
				$mp->save();
				
				$publication->project_id = $mp->id;
		} else {
			if(!isset($_POST['make_project'])) {
				
				$mp = new Project();
				$mp = $mp->find($publication->project_id);
				if(!empty($mp)) {
					if(is_object($mp)) {
						$mp->delete();
					}
				}
				$publication->project_id = 0;
			} else {
				
				if($publication->sync_project == '1' && !empty($publication->project_id)) {
					$mp = new Project();
					$mp = $mp->find($publication->project_id);
					
						$mp->title = $publication->title;
						$mp->abstract = $publication->content;
						$mp->year = $publication->year;
						$mp->tags = $publication->tags;
						$mp->person_id = $_POST['person_id'];
						$mp->save();
				
				}
				
			}
		}
		
		$publication->save();
	}
	
	if(isset($_POST['person_id'])) {
				
		$publication->person_id = $_POST['person_id'];
		
		$publication->save();
		
	}
	
	if(isset($_POST['area_id'])) {
		$publication->area_id = $_POST['area_id'];
		
		$publication->save();
	}
	

	render('publication_edit',$publication->id);
}

//End Publications

//Start Events
function admin_events_list() {
	global $events;
	$events = new Event();
	$events = $events->find();
	render();
}

function admin_events_create() {

	
	render();
}

function admin_events_update() {
	
	
	if($_POST) {
		if($_POST['id']) {
			$event = new Event();
			$event = $event->find($_POST['id']);
		} else {
			
			$event = new Event();
		}
		$event->title = $_POST['title'];
		$event->content = $_POST['content'];
		$event->date = $_POST['date'];
		$event->tags = $_POST['tags'];
		$event->sidebar = $_POST['sidebar'];
		$event->enable_registration = $_POST['enable_registration'];
		$event->location = $_POST['location'];
		
		$event->custom_sidebar = $_POST['custom_sidebar'];
		
		$event->save();
	
		
		render('events_edit',$event->id);
	} else {
		render('events_list');
	}
	
}

function admin_events_edit() {
	
	global $event;
	$event = new Event();
	$event = $event->find($_GET['id']);
	
	render();
}

function admin_events_delete() {
	$event = new Event();
	$event = $event->find($_GET['id']);
	$event->delete();
	render('events_list');
}
//End Events

//Start Pages
function admin_pages_delete() {
	$page = new Page();
	$page = $page->find($_GET['id']);
	$page->delete();
	
	render('pages_list');
}

function admin_pages_create() {
	if(isset($_REQUEST['create'])) {
		$page = new Page();
		$page->name = $_REQUEST['name'];
		$page->protected = $_REQUEST['protected'];
		$page->content = $_REQUEST['content'];
		$page->save();
		render('pages_list');
		return true;
	}
	render();
}

function admin_pages_list() {
	global $pages;
	$pages = new Page();
	
	$pages = $pages->find();
	
	render();
}

function admin_pages_edit() {
	
	global $page;
	
	$page = new Page();
	$page = $page->find($_REQUEST['id']);
	
	render();
}

function admin_pages_update() {
	$page = new Page();

	
	$page = $page->find($_REQUEST['id']);

	
	$page->content = $_REQUEST['content'];
	$page->name = $_REQUEST['name'];
	$page->protected = $_REQUEST['protected'];
	$page->tags = $_REQUEST['tags'];
	$page->sidebar = $_REQUEST['sidebar'];
	$page->header = $_POST['header'];
	$page->custom_sidebar = $_POST['custom_sidebar'];
	
	$page->save();
	global $status;
	$status = "Page Saved!";
	render('pages_edit',$page->id);
}

//Start Users

function admin_users_printreview_excel() {
	$_REQUEST['layout'] = '';
	render();
}

function admin_users_sync() {
	

	
	render();
}

function admin_users_list() {
	global $users;
	$users = new User;
	$users=$users->find();
	
	render();
}

function admin_users_create() {
	
	if(isset($_POST['add'])) {
		$user = new User;
		
		//create the crypted password
		$salt = chr(rand(65,90)) .chr(rand(65,90)) .chr(rand(65,90)) .chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90));
		
		$salt = md5($salt);
		
		$password = md5($_POST['password'].$salt);
		
		$user->login = $_POST['login'];
		$user->email = $_POST['email'];
		$user->crypted_password = $password;
		$user->salt = $salt;
		$user->save();
		
		render('users_list');
	}
	
	render();
}

function admin_users_delete() {

	$user = new User;
	$user = $user->find($_REQUEST['id']);
	mc_remove($user);
	$user->delete();
	
	render('users_list');
}

function admin_users_edit() {
	global $user;
	$users = new User;
	$user = $users->find($_REQUEST['id']);
	
	if(isset($_POST['edit'])) {
	

			if(!empty($_POST['password'])) {
				$salt = chr(rand(65,90)) .chr(rand(65,90)) .chr(rand(65,90)) .chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90)) . chr(rand(65,90));

				$salt = md5($salt);

				$password = md5($_POST['password'].$salt);
				
				$user->crypted_password = $password;
				$user->salt = $salt;
			}
			
			foreach($_POST['update'] as $k=>$v) {
				$user->$k = $v;
			}
			
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
				
			$user->save();
			
	}
	
	render();
}

//Start Authors
function admin_authors_delete() {
	$author = new Authors();
	$author = $author->find($_GET['id']);
	$author->delete();
	
	render('research_authors');
}

function admin_authors_new() {
	$author = new Authors();
	
	
	
	if(isset($_POST['update'])) {
			foreach($_POST['update'] as $k=>$v) {

				$author->$k = $v;
			}
			$author->save();
			
			render('research_authors');
	}
	
	
	render();
}

function admin_authors_edit() {
	global $author;

	$author = new Authors();


	$author = $author->find($_REQUEST['id']);
	
	

	if(isset($_POST['update'])) {
		$author->profile = stripslashes($_POST['profile']);
		foreach($_POST['update'] as $k=>$v) {
			
			$author->$k = stripslashes($v);
		}
	
		$author->save();
		
		
		
	
		
	}
	render();
}


//Start Sidebars
function admin_sidebars_list() {
	global $sidebars;
	
	$sidebars = new Sidebar();
	$sidebars = $sidebars->find();
	render();
}

function admin_sidebars_edit() {
	global $sidebar;
	
	$sidebar = new Sidebar();
	$sidebar = $sidebar->find($_GET['id']);
	
			
		
	render();
}

function admin_sidebars_create() {
	
	render();
}

function admin_sidebars_update() {
	
global $dba;
	
	
	$sb = new Sidebar();
	if($_POST['id']) {
		$sb = $sb->find($_POST['id']);
	
	
	}
	

	$sb->title = $_POST['title'];

	$sb->data = array();
	//unset($sb->data['headings']);
		
	foreach($_POST['headings'] as $h) {
		
		$post_h = str_replace(" ","_",$h);
		
		$sb->data[$h] = $_POST['contents_'.$post_h];

	}
	

	$sb->save();
	
	
	render('sidebars_edit',$sb->id);
}

function admin_sidebars_delete() {
	
	$sb = new Sidebar();
	if($_GET['id']) {
		$sb = $sb->find($_GET['id']);
		$sb->delete();
	}
	
	render('sidebars_list');
}
?>
