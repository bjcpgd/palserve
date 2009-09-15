<?php
$_REQUEST['layout'] = 'main';

function publications_index() {
	
	render('list');
}

function publications_show() {
	global $pub;
	$pub = new publication();
	$pub = $pub->find($_GET['id']);
	
	
	
	render();
}

function publications_list() {
	global $pubs;
	$pubs = new publication();
	$pubs = $pubs->find();
	objSort($pubs,'getIndex','year');
	
	$pubs = array_reverse($pubs);
	
	render();
}

?>