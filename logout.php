<?php
/**
* go to this page to destroy the cookies that have been set by this site. And return you to a login prompt.
* @packge WebCheckout
*
*/
session_start();




session_destroy();

unset($_COOKIE['cookie']);
unset($_SESSION['custID']);
unset($_SESSION['RIT']);
unset($_SESSION['id']);
unset($_REQUEST['id']);
unset($_REQUEST['innerPage']);
setcookie("cookie[user]",'',time()-99999);
setcookie("cookie[token]",'',time()-99999);
setcookie("cookie[fqdn]",'',time()-99999);
setcookie("cookie[fullname]",'',time()-99999);
setcookie("db",'',time()-99999);
setcookie('beta','',time()-99999);
setcookie('CheckoutSESSION','',time()-99999);
	header("Location: /");


?>
