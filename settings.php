<?php
require_once("php/menu.php");

if(!$info)
{
	header("Location: logout.php");
	die();
}


if(isset($_POST['password'], $_POST['passwdrep']))
{
	if($user->ChangePassword($info['id'], $_POST['existingpw'], $_POST['password'], $_POST['passwdrep']))
	{
		echo '
		<div class="container">
		<div class="alert alert-success" role="alert">
		<b>Success:</b> ÿour password have now been updated.
		</div>
		</div>
		';
	}
	else
	{
		echo '
		<div class="container">
		<div class="alert alert-danger" role="alert">
		<b>Error:</b> we couldn\'t update your password, perhaps you entered invalid current password - or not meeting our requirements?
		</div>
		</div>
		';
	}
}
else
if(isset($_POST['email']))
{
	if($user->UpdateEmail($info['id'], $_POST['email']))
	{
		echo '
		<div class="container">
		<div class="alert alert-success" role="alert">
		<b>Success:</b> your email address have now been updated.
		</div>
		</div>
		';
		$info = $user->getData($_SESSION['id']);
	}
	else
	{
		echo '
		<div class="container">
		<div class="alert alert-danger" role="alert">
		<b>Error:</b> we could not update your email, perhaps someone else are using it - or it\'s invalid?
		</div>
		</div>
		';
	}
}

?>

<script>
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>


<div class="container">


<div class="container">
    <div class="row">
    	<div class="col-md-4 col-md-offset-4">
    		<div class="panel panel-default">
			  	<div class="panel-heading">
			    	<h3 class="panel-title">Change Email</h3>
			 	</div>
			  	<div class="panel-body">
			    	<form accept-charset="UTF-8" role="form" data-toggle="validator" method="POST">
                    <fieldset>
			    	  	<div class="form-group">
			    		    <input class="form-control" required name="email" placeholder="<?php echo htmlentities($info['email']); ?>" type="email">
			    		</div>
			    		<input class="btn btn-lg btn-success btn-block" type="submit" value="Change Email">
			    	</fieldset>
			      	</form>
			    </div>
			</div>
		</div>
	</div>


    <div class="row">
    	<div class="col-md-4 col-md-offset-4">
    		<div class="panel panel-default">
			  	<div class="panel-heading">
			    	<h3 class="panel-title">Change Password</h3>
			 	</div>
			  	<div class="panel-body">
			    	<form accept-charset="UTF-8" role="form" data-toggle="validator" method="POST">
                    <fieldset>

			    	  	<div class="form-group">
			    		    <input class="form-control" required minlength="8" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" name="existingpw" placeholder="Existing Password" type="password">
			    		</div>

			    	  	<div class="form-group">
			    		    <input class="form-control" required minlength="8" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" id="password" name="password" placeholder="New Password" type="password">
			    		</div>
			    	  	<div class="form-group">
			    		    <input class="form-control" required minlength="8" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" data-match="#password" name="passwdrep" placeholder="Repeat Password" type="password">
			    		</div>

			    		<input class="btn btn-lg btn-success btn-block" type="submit" value="Change Password">
			    	</fieldset>
			      	</form>
			    </div>
			</div>
		</div>
	</div>


</div>

</div>

</body>
</html>