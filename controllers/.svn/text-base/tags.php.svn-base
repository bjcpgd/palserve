<?php

$_REQUEST['layout'] = 'main';


function tags_index() {
	
	render('list');
}

function tags_list() {
	
	global $tags;
	
	$tags = new tags();
	$tags = $tags->find();
	
	ksort($tags);
	
	render();
}

function tags_show() {
	global $tag;
	global $objects;
	$tag = new tags();
	$objects = $tag->find($_GET['id']);
	
	render();
}

?>