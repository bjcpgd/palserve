<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<?php
if($_GET['controller'] == 'pages') {
	global $page;

	$first = str_replace("_"," ",$page->name);
	$second = "";
	
	} elseif($_GET['controller'] == 'events' && $_GET['action'] == 'show') {
		global $event;

		$first = $event->title;
		$second = " :: ".$event->date;

		} elseif($_GET['controller'] == 'news' && $_GET['action'] == 'show') {
			
			global $news;

			$first = $news->title;
			$second = "";

	
	} else {
	$first = $_GET['controller'];
	$second = "::".$_GET['action'];
}
?>

<title>Printing Industry Center :: <?=@ucfirst($first)?> <?=@ucfirst($second)?></title>
<? global $baseurl?> 
<link rel="stylesheet" type="text/css" media="all" href="<?=$baseurl?>tablesort/style.css" />
<?=stylesheet('main','screen')?>
<?=stylesheet('styles','screen')?>

<script src="<?=$baseurl?>javascripts/AC_RunActiveContent.js" type="text/javascript"></script>
<script src="<?=$baseurl?>javascripts/prototype.js" type="text/javascript"></script>
<script src="<?=$baseurl?>javascripts/scriptaculous.js" type="text/javascript"></script>
<script src="<?=$baseurl?>javascripts/folder-tree-static.js" type="text/javascript"></script>

<script src="<?=$baseurl?>javascripts/table.js" type="text/javascript"></script>
<script src="<?=$baseurl?>javascripts/boxover.js" type="text/javascript"></script>


<script type="text/javascript" src="<?=$baseurl?>tablesort/fastinit.js"></script>
<script type="text/javascript" src="<?=$baseurl?>tablesort/tablesort.js"></script>

<link rel="alternate" type="application/rss+xml" title="Printing Industry Center: News" href="/news/rss"/>

<script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
</script>
<script type="text/javascript">
_uacct = "UA-74609-1";
urchinTracker();
</script>


<script type="text/javascript">

	function setCookie(c_name,value,expiredays)
	{
	var exdate=new Date();
	exdate.setDate(exdate.getDate()+expiredays);
	document.cookie=c_name+ "=" +escape(value)+
	((expiredays==null) ? "" : ";expires="+exdate.toGMTString());
	}
	
	function getCookie(c_name)
	{
	if (document.cookie.length>0)
	  {
	  c_start=document.cookie.indexOf(c_name + "=");
	  if (c_start!=-1)
	    {
	    c_start=c_start + c_name.length+1;
	    c_end=document.cookie.indexOf(";",c_start);
	    if (c_end==-1) c_end=document.cookie.length;
	    return unescape(document.cookie.substring(c_start,c_end));
	    }
	  }
	return "";
	}

	
	saveCookieBool = true;
	function saveNavigation() {
		//This mean no further saving of the currentDiv
		saveCookieBool = false;
	}


	var currentDiv = $('link-holder-about');
	var currentNav;
	
	
	function setNoDiv() {
		currentDiv.style.display = "none";
	}
	
	function setDefaultDiv()
	{	
	
		if($('page_id').value != "home") {	
			currentDiv = document.getElementById('link-holder-about');
			cookiediv = readCookie('currentDiv');
			show_link(cookiediv,this);
			currentDiv = document.getElementById(cookiediv);
			$(cookiediv+'-main').style.backgroundImage = 'url(/images/sub_nav_selected.gif)';
	
		} else {
					currentDiv = document.getElementById('link-holder-about');
					
					hide(currentDiv);
					show_link('empty',this);
				
			
		}
	}
	
	function show_link(theDiv,obj)
	{
		$('empty').style.display = 'none';
		divRef = document.getElementById(theDiv);
	
		divRef.style.display = "block";
	
		if(divRef != currentDiv)
		{
			//alert(currentDiv);
			if(currentDiv) {
			hide(currentDiv);
			}
			
		}
		
	
		currentDiv = divRef;
		if(saveCookieBool) {
			createCookie('currentDiv',divRef.id,1);
		}
	}
	
	function hide(theDiv)
	{
		//new Effect.BlindDown(theDiv, { duration: 1, scaleX: true, scaleY: false});
		$(theDiv).style.display = "none";
	}
	
	function createCookie(name,value,days) {
		if (days) {
			var date = new Date();
			date.setTime(date.getTime()+(days*24*60*60*1000));
			var expires = "; expires="+date.toGMTString();
		}
		else var expires = "";
		document.cookie = name+"="+value+expires+"; path=/";
	}

	function readCookie(name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		}
		return null;
	}

	function eraseCookie(name) {
		createCookie(name,"",-1);
	}
	
	
</script>
</head>

<body onload="setDefaultDiv();" >
	<div id="container">
		<div id="header">
			<div id='current_user'>
				<div id='login' style='display: none; padding: 10px; line-height: 20px'>
					<h1>Login</h1>
					<h2>Welcome to the Printing Industry Center</h2>
				<?php
				if(isset($_SESSION['current_user'])) {
					$u = $_SESSION['current_user'];
				
					?>
					Welcome <?=$u->login?> | <a href='<?=$baseurl?>users/profile'>Edit Profile</a> | <a href='<?=$baseurl?>/users/logout'>Logout</a>
					<?
				} else {
					
				
					?>
						<form method='POST' action='<?=$baseurl?>/users/login'>
						Username: <input type='text' id='username_form' name='username'><br/>
						Password: <input type='password' name='password'><br/>
						<p><input type='checkbox' name='remember_me' value='1'><label for='remember_me'>Keep me logged in on this computer</a></p>
						<input type='submit' name='login' value='Login'>
						</form>
					<?
					
				}
				?>
				<br/>
				</div>
				
				<div style='height: 20px'>
					<?php
						if(isset($_SESSION['current_user'])) {
							$u = $_SESSION['current_user'];
							?>
							Welcome <?=$u->login?> | <a href='<?=$baseurl?>users/profile'>Edit Profile</a> | <a href='<?=$baseurl?>/users/logout'>Logout</a>
							<?
						} else {
					?>
					<a href='#' onClick='$("username_form").focus(); new Effect.BlindDown("login"); '>Login</a>	
					<?php }?>
				</div>
			</div>
			
			<?php
			if($_GET['controller'] == 'news' || $_GET['controller'] == 'events') {
				$header_image = 'news.jpg';
			} elseif($_GET['controller'] == 'newsletters') {
				$header_image = 'newsletter.jpg';
				
			} elseif($_GET['controller'] == 'research' || $_GET['controller'] == 'publications') {
				$header_image = 'research.jpg';

			} elseif($_GET['controller'] == 'authors') {
				
				$header_image = 'about.jpg';
			
			} else {
				
				$header_image = 'main.jpg';
			}
			
			?>
			
			<img id='header_image' alt="Printing Industry Center" border="0" src="<?=$baseurl?>images/headers/<?=$header_image?>" usemap="#Map" />
	        <map name="Map" id="Map"><area shape="rect" coords="18,74,162,123" href="<?=$baseurl?>" />
	        </map>
		</div><!-- END HEADER DIV -->
		
	    <div id="main-nav">
	    	<div class="nav-item" id='link-holder-about-main'>
	        	<a onmouseover="show_link('link-holder-about');" href="<?=$baseurl?>About_the_Center/">ABOUT &amp; CONTACTS</a>
	        </div>
	        <div class="nav-item" id='link-holder-news-main'>
	        	<a onmouseover="show_link('link-holder-news');" href="<?=$baseurl?>news/">NEWS &amp; <br/>EVENTS</a>
	        </div>
	        <div class="nav-item" id='link-holder-industry-main'>
	        	<a onmouseover="show_link('link-holder-industry');" href="<?=$baseurl?>About_Program/">INDUSTRY PARTNERS</a>
	        </div>

	        <div class="nav-item" id='link-holder-education-main'>
	        	<a onmouseover="show_link('link-holder-education');" href="<?=$baseurl?>divisions/">DIVISIONS &amp; EDUCATION</a>
	        </div>
	        <div class="nav-item" id='link-holder-research-main'>
	        	<a onmouseover="show_link('link-holder-research');" href="<?=$baseurl?>research/areas/">Research &amp; Publications<br/></a>
	        </div>
	        <div class="nav-item" style="border: none;" id='link-holder-newsletter-main'>
	        	<a onmouseover="show_link('link-holder-newsletter');" href="<?=$baseurl?>newsletter_archive">NEWSLETTER &amp; RESOURCES</a>
	        </div>

	    </div><!-- END MAIN NAV DIV -->
	    <div class="clear-floats"><!-- --></div>
	    <div id="sub-nav">
			<div id='empty' style='display: none'>
				<a href='#'>&nbsp;</a>
				<div class="clear-floats"><!-- --></div>
			</div>
	    	<div id="link-holder-about" style='margin-left: 0'>		
				<a onClick='saveNavigation();' href="<?=$baseurl?>About_the_Center">About the Center</a>
				<a onClick='saveNavigation();' href="<?=$baseurl?>About_Industry">About the Industry</a>
				<a onClick='saveNavigation();' href="<?=$baseurl?>About_RIT">About RIT</a>
				<a onClick='saveNavigation();' href="<?=$baseurl?>FAQ">FAQ &amp; Search</a>
				<a onClick='saveNavigation();' href="<?=$baseurl?>authors/directory">Center Directory</a>
				<a onClick='saveNavigation();' href="<?=$baseurl?>Contact">Contact us</a>


	            <div class="clear-floats"><!-- --></div>
	        </div>
	        <div id="link-holder-news" style='margin-left: 40px'>
				<a onClick='saveNavigation();' href="<?=$baseurl?>news">Center News</a>
				<a onClick='saveNavigation();' href="<?=$baseurl?>events">Center Events</a>
				<a onClick='saveNavigation();' href="<?=$baseurl?>news/archive">News Archive</a>


	            <div class="clear-floats"><!-- --></div>
	        </div>
	        <div id="link-holder-industry" style='margin-left: 40px'>
				<a onClick='saveNavigation();' href="<?=$baseurl?>About_Program">About the Program</a>
				<a onClick='saveNavigation();' href="<?=$baseurl?>Current_Partners">Current Partners</a>
				<a onClick='saveNavigation();' href="<?=$baseurl?>Partner_Benefits">Industry Partner benefits</a>
				<a onClick='saveNavigation();' href="<?=$baseurl?>gateway">industry partner gateway</a>

	            <div class="clear-floats"><!-- --></div>
	        </div>
	        <div id="link-holder-education" style='margin-left: 270px'>
				<a onClick='saveNavigation();' href="<?=$baseurl?>divisions">Divisions</a>
				<a onClick='saveNavigation();' href="<?=$baseurl?>School_of_Printmedia">School of Print Media</a>
				<a onClick='saveNavigation();' href="<?=$baseurl?>Printing_Applications_Laboratory">Printing Applications Laboratory</a>
				

	            <div class="clear-floats"><!-- --></div>
	        </div>
	        <div id="link-holder-research" style='margin-left: 380px'>
				<a onClick='saveNavigation();' href="<?=$baseurl?>research/areas">Research Areas</a>
				<a onClick='saveNavigation();' href="<?=$baseurl?>research/index">Research Index</a>
				<a onClick='saveNavigation();' href="<?=$baseurl?>publications/list/">Publications</a>

	            <div class="clear-floats"><!-- --></div>
	        </div>
	        <div id="link-holder-newsletter" style='margin-left: 150px'>
	            <a onClick='saveNavigation();' href="<?=$baseurl?>newsletters/signup">Newsletter Sign-up</a>
				<a onClick='saveNavigation();' href="<?=$baseurl?>users/newsletter/">Affiliate Preferences</a>
	            <a onClick='saveNavigation();' href="<?=$baseurl?>newsletter_archive">Newsletter Archive</a>
	            <a onClick='saveNavigation();' href="<?=$baseurl?>Resources">Industry Resources</a>

	            <div class="clear-floats"><!-- --></div>
	        </div>
	    </div><!-- END SUB NAV DIV -->

   
	    <div id="left-column">
	
					<?if($_SESSION['current_user']->is_admin) {?>
						<div class="info-pod">
							<h1><img src='<?=$baseurl?>images/arrow.gif'> Admin Options</h1>
							<p>
							<?partial('admin/panel')?>
							</p>
							<h2><a href='<?=$baseurl?>/admin/'>&#x2192;Dashboard</a></h2>
						</div>
						<br/>
					<? } ?>
					

<div id='replace_customer_sidebar'>	
	
	    	<div class="info-pod">
	        	<h1><img src='<?=$baseurl?>images/arrow.gif'> Research Spotlight</h1>
	           	<?php
	           	$proj = new project();
				$proj = $proj->random();
		
	           	?>
	           	<h2><?=$proj->projectnumber?></h2>
				<p>
					<strong><a href='<?=$baseurl?>research/show/<?=$proj->id?>'><?=$proj->title?></a></strong>
				</p>
				<p style='font-align: justify'>
					<?=substr(strip_tags($proj->abstract),0,150);?>...<br/>(<a href='<?=$baseurl?>research/show/<?=$proj->id?>'>more</a>)
				</p>
	        </div>
			<?if($_GET['controller'] == 'research' && $_GET['action'] != 'index') { ?>
	 		<div id='research_areas' class='info-pod' stlye='display: none; visibility: none'>
	 			
					<h1><img src='<?=$baseurl?>images/arrow.gif'> <a href=<?=$baseurl?>research/areas>Research Areas</a></h1>
					<p>
					<?
					$areas = new Areas();
					$areas = $areas->find('WHERE display = 1');
					foreach($areas as $a) {?>
				
					<h2><a href='<?=$baseurl?>research/area/<?=$a->id?>'><?=$a->name?></a></h2>
				<?  } ?>
			
				</p>
				
	 		</div>
			<?	} ?>
			
			
	        <div id='research_related' class='info-pod' style='display: none; visibility: none'>
	        	<h1><img src='<?=$baseurl?>images/arrow.gif'> Related Research</h1>
				<p id='research_related_html'></p>
	
	        </div>
	        <div class="info-pod">
	        	<h1>
					<img src='<?=$baseurl?>images/arrow.gif'> <a href=<?=$baseurl?>news/list>Center News</a>
					<a href='<?=$baseurl?>news/rss'><img src='<?=$baseurl?>images/feed-icon-14x14.png'/></a>
				</h1>
	<?php
	//Get the last 2 news items
	$news = new News();
	$news = $news->find("ORDER BY created_on DESC");

	$i = 0;
	foreach($news as $new) {
	
		if($new->active() && $i < 2) {
	?>
		<h2><a href='<?=$baseurl?>news/show/<?=$new->id?>'><?=$new->title?></a></h2>
			<p><?=date("F j, Y, g:i a",strtotime($new->created_on))?></p>
	<? 
		$i++;
		}
	} ?>
		<br/>
	</div>
    
</div>    


	        <? if(!isset($_SESSION['current_user'])) {?>
			<div class="info-pod">
				<? 	if($_GET['action'] != 'login') { ?>
	        	<h1><img src='<?=$baseurl?>images/arrow.gif'> Gateway Login</h1>
	            <h2>Industry Partners</h2>
	            	<form method='POST' action='<?=$baseurl?>/users/login'>
					<h2><label for='username'>Username</label></h2>
					<input type='text' name='username'>
					<h2><label for='password'>Password</label></h2>
					<input type='password' name='password'>
					<h2><input type='checkbox' name='remember_me' value='1'><label for='remember_me'> Keep me logged in</h2>
					<input type='submit' name='login' value='Login'>
			
					</form>
					<? } ?>
	

	        </div>
			<?} else {?>
				<div class="info-pod">
					<h1><img src='<?=$baseurl?>images/arrow.gif'> Account Options</h1>
					<?php if($_SESSION['current_user']->status == 'Partner') { ?>
					<h2><a href='<?=$baseurl?>gateway'>IP Gateway</a></h2>
					<? } ?>
					<h2><a href='<?=$baseurl?>users/profile'>Edit Profile</a></h2>
					<h2><a href='<?=$baseurl?>users/reset_password'>Change Password</a></h2>
					<h2><a href='<?=$baseurl?>users/logout'>Logout</a></h2>
				
					<br/><br/>
				</div>
			
						
			
			<? } ?>
			
			
				<div id='page_tags' class='info-pod' style='display: none; visibility: none'>
					<h1><img src='<?=$baseurl?>images/arrow.gif'> <a href=<?=$baseurl?>tags>Page Tags</a></h1>
					<p id='page_tags_html'></p>
					<br/>
				</div>
					
	    </div><!-- END LEFT COLUMN DIV -->
    
		  <div id="right-column">
		
		
	
			<?php
			global $errors;
			if ($errors) { ?>
			
				<div id='flash_notice'>
						<div id='flash_notice_close'>[<a href="#" onClick='$("flash_notice").style.display = "none"'>close</a>]</div>
					<?=$errors;?>
			
				</div>
				<script>
				new Effect.Highlight('flash_notice', {duration: 5});
				</script>
			
			<?php } ?>

			
				<td width=100% valign='top'>
					<input type='hidden' id='page_id' name='page_id' value='<?=$_GET['id']?>'>
			
					<?=yield();?>
				</td>

	    </div>
	

	<!-- END RIGHT COLUMN DIV -->
    <div class="clear-floats"><!-- --></div>
</div><!-- END CONTAINER DIV -->
<div id="footer">
	<div id="footer-nav-holder">
        <div id="footer-nav">
            <p><a href="http://www.rit.edu">RIT HOME</a> |
            <a href="http://www.sloan.org/">ALFRED P. SLOAN FOUNDATION</a> |
            <a onClick='saveNavigation();' href="<?=$baseurl?>CONTACT/">CONTACT US</a> |
            <a onClick='saveNavigation();' href="<?=$baseurl?>FAQ/">FAQ &amp; SEARCH</a></p>
        </div>
    </div>
	<img src='<?=$baseurl?>images/dwd-logo.gif' class='logo' alt='Dumbwaiter Design'>
    <p class="copy">&copy; 2003 – <?=date('Y');?> Printing Industry Center at RIT + Rochester Institute of Technology. [<a href='<?=$baseurl?>/credits'>Credits</a>] [<a href='<?=$baseurl?>/disclaimer'>Disclaimer</a>]</p>
</div><!-- END FOOTER DIV -->

</body>
</html>

<?php return false; ?>
