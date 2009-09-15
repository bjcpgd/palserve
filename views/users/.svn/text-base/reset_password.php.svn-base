<?
global $user;
global $errors; 
?>

<script language="javascript">
function passwordChanged() {
var strength = document.getElementById('strength');
var strongRegex = new RegExp("^(?=.{8,})(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9])(?=.*\\W).*$", "g");
var mediumRegex = new RegExp("^(?=.{7,})(((?=.*[A-Z])(?=.*[a-z]))|((?=.*[A-Z])(?=.*[0-9]))|((?=.*[a-z])(?=.*[0-9]))).*$", "g");
var enoughRegex = new RegExp("(?=.{6,}).*", "g");
var pwd = document.getElementById("password1");
if (pwd.value.length==0) {
strength.innerHTML = 'Type Password';
} else if (false == enoughRegex.test(pwd.value)) {
strength.innerHTML = 'More Characters';
} else if (strongRegex.test(pwd.value)) {
strength.innerHTML = '<span style="color:green">Strong!</span>';
} else if (mediumRegex.test(pwd.value)) {
strength.innerHTML = '<span style="color:orange">Medium!</span>';
} else {
strength.innerHTML = '<span style="color:red">Weak!</span>';
}
}

function passwordMatch() {
	if(document.getElementById('password1').value != document.getElementById('password2').value) {
		document.getElementById('match').innerHTML = "<span style='color: red'>Passwords do not match</span>";
	} else {
		document.getElementById('match').innerHTML = "<span style='color: green'>Passwords match!</span>";
	}
}
</script>

<h1>Password Reset</h1>
<hr/>
<p>
<form method="POST" accept-charset="utf-8">

<?php
if($_GET['a'] == 'default') {
	echo "
	You have logged in with the default site password<br/>
	<strong>Please change your password now!</strong><br/><br/>";
}

?>
	
<p>
	<label><strong>Password</strong></label><br/>
	<input type='password' id='password1' name='password1' onkeyup="return passwordChanged();"/> <span id="strength">Type Password</span>
</p>

<p>	
	<label><strong>Password (again)</strong></label><br/>
	<input type='password' id='password2' name='password2' onkeyup="return passwordMatch();"> <span id='match'></span>
</p>
	<p><input type="submit" value="Reset Password"></p>
</form>

</p>