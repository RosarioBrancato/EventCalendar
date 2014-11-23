<?php

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}

include('GeneralTags.php');

function showOverviewGui($message) {
	
?>
<html>
<head>
	<?php getHeadTags(); ?>
</head>
<body>
<div class="container">
	<h1 class="page-header">Übersicht - Verwaltung</h1>
<?php
	if($message != null) {
?>
	<div class="<?php echo $message->getClassAlert(); ?>"><?php echo $message->getText(); ?></div>
<?php
	}
?>
	<a href="#">Veranstaltungen</a>
	<a href="../domain/PriceBracket.php">Preisgruppen</a>
	<a href="#">Genres</a>

	<form action="../domain/LogOut.php" method="post">
		<input type="submit" class="btn btn-default" name="log_out" value="Abmelden" />
	</form>
</div>
</body>
<?php
}
?>