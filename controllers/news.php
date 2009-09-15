<?php
$_REQUEST['layout'] = 'main';
function news_index() {
	
	render('list');
}

function news_list() {
	global $news;
	$news = new News();


	if($_GET['id'] == 'protected') {
	
		$news = $news->find('WHERE protected = 1 ORDER BY created_on DESC');
		$news = array_slice($news,0,5);
		
	} else {
	
		$news = $news->find('ORDER BY created_on DESC');
		$news = array_slice($news,0,5);
	}
	render();
}


function news_show() {
	global $news_show;
	
	$news = new News();
	$news_show = $news->find($_GET['id']);
	
	render();
}

function news_archive() {
	global $news;
	$news = new News();
	
	if($_GET['id'] == 'protected') {
	
		$news = $news->find('WHERE protected = 1 ORDER BY created_on DESC');
		
	} else {
	
		$news = $news->find('ORDER BY created_on DESC');
	
	}
	render();
}

function news_rss() {
	global $news;
	$_REQUEST['layout'] = '';
	$news = new News();
	
	$news = $news->find('WHERE protected = 0 ORDER BY created_on DESC LIMIT 20');
	render();
	
}

?>