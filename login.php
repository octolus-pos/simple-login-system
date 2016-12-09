<?php
require_once("php/menu.php");

if(isset($_POST['username'], $_POST['password']))
{
	$user = new User;

	if($user->AuthUser($_POST['username'], $_POST['password']))
	{
		header("Location: index.php");
		die();
	}
	else
	{
		echo '
		<div class="alert alert-danger" role="alert">
		<b>An error occured during your registration:</b>
		<br />
		<li>
		<ul>test</ul>
		</li>
		</div>
		';
	}

}

?>

<div class="container">
    <div class="row">
    	<div class="col-md-4 col-md-offset-4">
    		<div class="panel panel-default">
			  	<div class="panel-heading">
			    	<h3 class="panel-title">Login</h3>
			 	</div>
			  	<div class="panel-body">
			    	<form accept-charset="UTF-8" role="form" data-toggle="validator" method="POST">
                    <fieldset>
			    	  	<div class="form-group">
			    		    <input class="form-control" autofocus data-minlength="5"  maxlength="31" required  placeholder="Username" name="username" type="text">
			    		</div>
			    		<div class="form-group">
			    			<input class="form-control" placeholder="Password" data-match-error="The password you entered does not match our requirements." pattern="(?=^.{8,}$)((?=.*\d)|(?=.*\W+))(?![.\n])(?=.*[A-Z])(?=.*[a-z]).*$" required data-minlength="8" name="password" type="password">
			    		</div>
			    		<input class="btn btn-lg btn-success btn-block" type="submit" value="Login">
			    	</fieldset>
			      	</form>
			    </div>
			</div>
		</div>
	</div>
</div>

</body>
</html>