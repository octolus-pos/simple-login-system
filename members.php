<?php
require_once("php/menu.php");
$user = new User;
$info = $user->getData($_SESSION['id']);

if(!$info)
{
	header("Location: logout.php");
	die();
}

?>

<script>
$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>


<div class="container">
<h1>Welcome, <?php echo $info['username']; ?>!</h1>
</div>

</body>
</html>