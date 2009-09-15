<?php
global $page;
global $baseurl;

if($page->header != '') { 
?>
<script>
	$('header_image').src = '<?=$baseurl?>images/headers/<?=$page->header?>';
</script>
<?
}

if($page->sidebar == false && $page->custom_sidebar != 'null') {
?>
<script>
	$('replace_customer_sidebar').innerHTML = '';
</script>
	<?php
	
	$sb = new Sidebar();
	$sb = $sb->find($page->custom_sidebar);
	
	foreach($sb->data as $heading=>$content) {
		$content = str_replace("\n", "", $content);
		$content = str_replace("\r", "", $content);
		$content = str_replace('"',"'",$content);
		?>
		<script>
		$('replace_customer_sidebar').innerHTML += "<div id='<?=$heading?>_sidebar' class='info-pod'><h1><img src='<?=$baseurl?>images/arrow.gif'> <?=$heading?></h1><p><?=$content?></p></div>";
	</script>
		<?
	}
	
	?>
	
	

<?

	
} elseif($page->sidebar == false) {
		echo "<script>$('container').removeChild($('left-column'));
			$('right-column').style.position = 'relative';
			$('right-column').style.backgroundColor = '#FFF';
			$('right-column').style.width = '697px';
			
		</script>";		
}



?>	

<?if(!empty($page->tags)) {
	$tags = split(",",$page->tags);
	
	foreach($tags as $t) {

		$tagHTML[] = " <a style='color: #003333;' href='".$baseurl."tags/show/".str_replace(" ","_",trim($t))."'>".trim($t)."</a>";
		
	}
	
	$ihtml = implode(",",$tagHTML);
?>
	<script>
		$('page_tags_html').innerHTML = "<?=$ihtml?>";
		$('page_tags').style.display = 'block';
		$('page_tags').style.visibility = 'visible';
	</script>
<?
}?>

<?=$page->content?>

<?
//If this is the home page, lets display the recent news under it
if(strtolower($page->name) == 'home') {
	global $news;
	$news = new News();

	$news = $news->find('ORDER BY created_on DESC');
	$news = array_slice($news,0,5);
?>



<?include('views/news/list.php');?>

<?	
}
?>

<?
//If this is the home page, lets display the recent news under it
if(strtolower($page->name) == 'gateway') {
	global $news;
	$news = new News();
	$news = $news->find('WHERE protected = "1" ORDER BY created_on DESC ');
	$news = array_slice($news,0,5);
?>



<?include('views/news/list.php');?>

<?	
}
?>
