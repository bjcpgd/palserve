<h2>Displaying User</h2>
<? global $user ?>

<p>
	<form class="f-wrap-1">
<fieldset>	
<strong>Username:</strong> <?=$user->username?><br/>
<strong>Name:</strong> <?=$user->name?><Br/>
<strong>Email:</strong> <?=$user->email?><br/>
<strong>ScreenName:</strong> <?=$user->screenname?><Br/>
<?=link_to('List Users', array('controller'=>'users','action'=>'list'));?> | 
<?=link_to('Edit this User', array('controller'=>'users','action'=>'edit','id'=>$user->id));?> | 
<?=link_to('Delete this User', array('controller'=>'users','action'=>'delete','id'=>$user->id))?>
</fieldset>
</form>
</p>

