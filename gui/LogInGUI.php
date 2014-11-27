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
	<form action="../domain/LogIn.php" method="post">
		<table class="table">
			<tr>
					<td class="col-sm-2 text-right no-border">
						Benutzername:
					</td>
					<td class="col-sm-4 no-border">
						<input type="text" class="form-control" name="username" value="<?php echo $username; ?>" maxlength="20" required/>
					</td>
					<td class="col-sm-6 no-border"></td>
			</tr>
			<tr>
					<td class="col-sm-2 text-right no-border">
						Passwort:
					</td>
					<td class="col-sm-4 no-border">
						<input type="password" class="form-control" name="password" value="" required maxlength="32"/>
					</td>
					<td class="col-sm-6 no-border"></td>
			</tr>
			<tr>
					<td class="col-sm-2 no-border"></td>
					<td class="col-sm-4 no-border">
						<input type="submit" class="btn btn-default" name="log_in" value="Anmelden"/>
					</td>
					<td class="col-sm-6 no-border"></td>
			</tr>
		</table>
	</form>
	
</div>
</body>
<?php
}
?>