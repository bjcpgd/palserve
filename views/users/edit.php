<h2>Editing Record</h2>
<? global $user ?>
<?global $errors; echo $errors; ?>
<form method='POST'  class="f-wrap-1">
	<p>
	<label>Name</label><br/>
	<input type='text' name='name' value='<?=$user->name?>'>
	</p>

	<p>
	<label>Email</label><br/>
	<input type='text' name='email' value='<?=$user->email?>'>
	</p>	

	<p>
	<label>ScreenName</label><br/>
	<input type='text' name='screenname'value='<?=$user->screenname?>'>
	</p>
	
	<input type='submit' name='submit' value='Edit Record'>
</form>