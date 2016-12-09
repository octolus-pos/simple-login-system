<?php
require_once("php/menu.php");

if(isset($_POST['username'], $_POST['password'], $_POST['passwordrep'], $_POST['email']))
{
	$user = new User;

	if($user->registerUser($_POST['username'], $_POST['password'], $_POST['passwordrep'], $_POST['email']))
	{
		echo 'success';
	}
	else
	{
		echo '
		<div class="container">
		<div class="alert alert-danger" role="alert">
		<b>An error occured during your registration - Could be one of the following reasons:</b>
		<br />
		<ul>
		<li>Username did not match our requirements or was already registered.</li>
		<li>Password did not match our requirements.</li>
		<li>Email is not valid, or is already registered.</li>
		</ul>
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
    <div class="row">
    	<div class="col-md-4 col-md-offset-4">
    		<div class="panel panel-default">
			  	<div class="panel-heading">
			    	<h3 class="panel-title">Register</h3>
			 	</div>
			  	<div class="panel-body">
			    	<form accept-charset="UTF-8" role="form" data-toggle="validator" method="POST">
                    <fieldset>
			    	  	<div class="form-group">
			    		    <input class="form-control" autofocus required data-toggle="tooltip" data-placement="top" title="Has to start with a character, at least 5 characters and max 31. Only numbers & characters." minlength="5" maxlength="31" pattern="^[A-Za-z][A-Za-z0-9]{4,31}$" placeholder="Username" name="username" type="text">
			    		</div>
			    		<div class="form-group">
			    			<input class="form-control" placeholder="Password" data-toggle="tooltip" data-match-error="The password you entered does not match our requirements." data-placement="left" title="(1) upper case letter, (1) lower case letter, (1) number or special character & (8) characters in length" required minlength="8" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" name="password" id="password" type="password">
			    		</div>
			    		<div class="form-group">
			    			<input class="form-control" placeholder="Repeat Password" data-match="#password" data-match-error="You need to repeat the exact password!" pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$"  required name="passwordrep" minlength="8" type="password">
			    			<div class="help-block with-errors"></div>

			    		</div>
			    		<div class="form-group">
			    			<input class="form-control" placeholder="Email" required name="email" type="email">
			    			<div class="help-block with-errors"></div>
			    		</div>


			    		<input class="btn btn-lg btn-success btn-block" type="submit" value="Register">
			    	</fieldset>
			      	</form>
			    </div>
			</div>
		</div>
	</div>
</div>

</body>
</html>