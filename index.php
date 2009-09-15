<?php
ini_set("display_errors",1);
ob_start();
session_start();
include('functions.php');

/*
* Set up Database connecetions
*
*/

include('adodb/adodb.inc.php');
$server = 'cias-sql.rit.edu';
$user = 'root';
$pwd = '';

//Testing Databaase
#$server = '10.0.2.2';
#$user = 'root';
#$pwd = 'Acces$';

$db = 'palserve';
$dba = NewADOConnection('mysql');
$dba->PConnect($server, $user, $pwd, $db);
$dba->SetFetchMode(ADODB_FETCH_ASSOC);

/* End DB Connection */

/* Include classes needed for this application */
include('classes/arecord.class.php');

include('classes/page.class.php');

include('classes/user.class.php');

include('Sajax.php');
/* End Class includes */


//Pre authentication
function users_pre_authenticate() {
	
	$user = new User();
	$user = $user->find('WHERE login_token = "'.$_COOKIE['remember_me'].'"');
	if(isset($user[0])) {
		$_SESSION['user_id'] = $user[0]->id;
		$_SESSION['current_user'] = $user[0];
	}
}

if(!isset($_SESSION['current_user']) && isset($_COOKIE['remember_me'])) {
	users_pre_authenticate();
}

if(!is_file('controllers/'.$_GET['controller'].".php")) {
	$_GET['arg1'] = str_replace('_'," ",$_GET['action']);
	$_GET['id'] = str_replace('_'," ",$_GET['controller']);
	$_GET['controller'] = 'pages';
	$_GET['action'] = 'by_name';

} else {

}
if(!isset($_GET['controller'])) { $_GET['controller'] = 'pages'; } 


if($_SERVER['HTTP_HOST'] == 'localhost' ) {
$baseurl = 'http://localhost/~bjcpgd/palserve/';
}elseif($_SERVER['HTTP_HOST'] == '192.168.1.116') {
	$baseurl = 'http://192.168.1.116/';

} else {
//$baseurl = 'http://print.rit.edu/';
}
$error = "";
$notice ="";



sajax_init();
//$sajax_debug_mode = 1;

start();

?>
