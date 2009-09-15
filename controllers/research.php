<?php
$_REQUEST['layout'] = 'main';


function research_index() {
	if(empty($_GET['action'])) { $_GET['action'] = 'areas'; }
	
	global $dba;
	global $areas;
	global $items;
	
	$areas = new Areas();
	$areas = $areas->find();

global $areas_current;

        $areas_current = new Areas();
	        $areas_current = $areas_current->find('WHERE display = 1');

		        global $areas_prior;

			        $areas_prior = new Areas();
				        $areas_prior = $areas_prior->find('WHERE display = 0');

	
	//Ok, now lets see what we can do about searching and drilling down
	$items = new Project();

	if(!empty($_REQUEST['add_value'])) {
		if($_REQUEST['add_value'] == 'search') {
			$items = $items->find("WHERE title LIKE '%".$_REQUEST['search']."%' ORDER BY year + 0 DESC");
		} elseif($_REQUEST['add_value'] == "year") {
			$items = $items->find("WHERE year = '".$_REQUEST['year']."'  ORDER BY year + 0 DESC");
		} elseif($_REQUEST['add_value'] == "areas") {
			if(!empty($_REQUEST['areas'])) {
				$items = $items->find("WHERE area_id = '".$_REQUEST['areas']."'  ORDER BY year + 0 DESC");
			} else {
				$items = $items->find(" ORDER BY year + 0 DESC");
			}
		} else {
			$items = $items->find(" ORDER BY year + 0 DESC");
		}
	} else {
		$items = $items->find(" ORDER BY year + 0 DESC");
	}
	
	render();
		
}

function research_area() {
	global $area;
	global $projects;
	$areas = new Areas();
	$area = $areas->find($_REQUEST['id']);
	
	$projects = new Project();
	$projects = $projects->find("WHERE area_id = '".mysql_real_escape_string($_REQUEST['id'])."' ORDER BY year + 0 DESC");
	

	
	render();
	
}

function research_areas() {
	global $areas_current;
	
	$areas_current = new Areas();
	$areas_current = $areas_current->find('WHERE display = 1');
	
	global $areas_prior;
	
	$areas_prior = new Areas();
	$areas_prior = $areas_prior->find('WHERE display = 0');
	
	
	
	render();
}

function research_show() {
	
	global $project;
	global $area;
	$project = new Project();

	$project = $project->find($_REQUEST['id']);
	$areas = new Areas();
	$area = $areas->find($project->area_id);
	
	
	render();
}

function research_rss() {
	$_REQUEST['layout'] = '';
	
	global $projects;
	$projects = new Project();
	$projects = $projects->find();
	
	render();
}

function research_unauthorized() {
	
	render();
}

function research_admin() {
	
}


?>
