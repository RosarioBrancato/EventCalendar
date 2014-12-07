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
<?php getHeader(); ?>
<div class="container">
	<h1 class="page-header">Anmelden</h1>
<?php
	if($message != null) {
?>
	<div class="<?php echo $message->getClassAlert(); ?>"><?php echo $message->getText(); ?></div>
<?php
	}
?>
	<form action="Event.php" method="post">
		<div class="row">
			<div class="col-sm-2 div-to-block height-fixed">
				<p class="hidden-xs  p-text-vertical-center text-right">Benutzername</p>
				<p class="visible-xs p-text-vertical-center">Benutzername</p>
			</div>
			<div class="col-sm-4 height-fixed">
				<input type="text" class="form-control" name="username" value="<?php echo $username; ?>" maxlength="20" required/>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-2 div-to-block height-fixed">
				<p class="hidden-xs  p-text-vertical-center text-right">Passwort</p>
				<p class="visible-xs p-text-vertical-center">Passwort</p>
			</div>
			<div class="col-sm-4 height-fixed">
				<input type="password" class="form-control" name="password" value="" required maxlength="32"/>
			</div>
		</div>
		<div class="row">
			<div class="col-sm-4 height-fixed col-sm-offset-2">
				<input type="submit" class="btn btn-default" name="log_in" value="Anmelden"/>
			</div>
		</div>
	</form>
</div>
</body>
<?php
}
?>