<?php
$_REQUEST['layout'] = 'main';

function authors_show() {
	global $author;
	$author = new Authors();
	$author = $author->find($_GET['id']);
	
	render();
}

function authors_index() {
	
	render();
}

function authors_directory() {
	
	global $authors;
	
	$author = new Authors();
	$authors = $author->find("WHERE directory = '1'");
	
	global $staff;
	
	$staff = $author->find("WHERE directory = '2'");

	
	render();
}


?>