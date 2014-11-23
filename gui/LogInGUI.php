<?php

include('GeneralTags.php');

function showLogInGui($data, $message) {
	$username = '';
	
	if($data != null) {
		$username = $data->getUsername();
	}
	
?>
<html>
<head>
	<?php getHeadTags(); ?>
</head>
<body>
<div class="container">
	<h1 class="page-header">Anmelden</h1>
<?php
	if($message != null) {
?>
	<div class="<?php echo $message->getClassAlert(); ?>"><?php echo $message->getText(); ?></div>
<?php
	}
?>
	<form method="post" action="../domain/LogIn.php">
		<div class="form-inline">Benutzername: <input type="text" class="form-control" name="username" value="<?php echo $username; ?>" required/></div>
		<div class="form-inline">Passwort: <input type="password" class="form-control" name="password" value="" required/></div>
		<p><input type="submit" class="btn btn-default" name="log_in" value="Anmelden"/></p>
	</form>
</div>
</body>
<?php
}
?>