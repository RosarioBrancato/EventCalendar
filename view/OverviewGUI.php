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
<?php getHeader(); ?>
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
</div>
</body>
<?php
}
?>