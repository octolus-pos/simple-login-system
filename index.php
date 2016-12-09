<?php
require_once("php/menu.php");

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