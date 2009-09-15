<?php
function authenticate($username,$password) {

global $error;
sleep(1);
$server="ldap.rit.edu";    //RIT LDAP Server
$basedn="ou=people,dc=rit,dc=edu";    //Base DN
$script=$_SERVER['SCRIPT_NAME'];

			$filter = "(uid=$username)";

			//$filter="(&(|(!(displayname=Administrator*))(!(displayname=Admin*)))(uid=$username))";    //define an appropriate ldap search filter to find your users, and filter out accounts such as administrator(administrator should be renamed anyway!).

			$dn = "uid=$username, ";
                if (!($connect = ldap_connect($server))) {
                           return 0;
                }
				ini_set("display_errors","0");
                if (!($bind = ldap_bind($connect, "$dn" . $basedn, $password)) || empty($password)) {

			       
					$error = "You either have a wrong username or wrong password";
					
					return 0;

					
			    }

			ini_set("display_errors","1");
			  $sr = ldap_search($connect, $basedn,"$filter");
        $info = ldap_get_entries($connect, $sr);
        
			$_SESSION['accountUserName'] = $username;
			$_SESSION['accountFirstName'] = $info[0]['givenname'][0];       
			$_SESSION['accountLastName'] = $info[0]['sn'][0];
			$_SESSION['accountPhone'] = $info[0]['telephonenumber'][0];
			$_SESSION['accountEmail'] = $info[0]['mail'][0];
         	$_SESSION['accountType'] = $info[0]['riteduaccounttype'][0];


        return 1;
        
        
}
?>