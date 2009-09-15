<?php
$_REQUEST['layout'] = 'main';


function events_index() {
	
	render('list');
}

function events_list() {
	global $events;
	$events = new Event();
	$events = $events->find();
	
	render();
	
}

function events_show() {
	global $event;
	$event = new Event();
	$event = $event->find($_GET['id']);
	
	render();
}
?>