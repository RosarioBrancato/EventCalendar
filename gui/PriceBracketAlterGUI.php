<?php

include('GeneralTags.php');

function showPriceBracketGui($data, $message) {
	$id = 0;
	$name = '';
	$price = 0;
	
	if($data != null) {
		$id = $data->getId();
		$name = $data->getName();
		$price  = $data->getPrice();
	}
?>
<html>
<head>
	<?php getHeadTags(); ?>
</head>
<body>
<?php getHeader(); ?>
<div class="container">
	<h1 class="page-header">Preisgruppen</h1>
<?php
	if($message != null) {
?>
	<div class="<?php echo $message->getClassAlert(); ?>"><?php echo $message->getText(); ?></div>
<?php
	}
?>
	<form method="post" action="../domain/PriceBracket.php">
		<input type="hidden" name="id" value="<?php echo $id; ?>" />
		<div class="form-inline">Name: <input type="text" class="form-control" name="name" value="<?php echo $name; ?>"/></div>
		<div class="form-inline">Preis: <input type="number" class="form-control" name="price" value="<?php echo $price; ?>"/></div>
		<p><input type="submit" class="btn btn-default" name="price_bracket_save" value="Speichern"/></p>
		<p><input type="submit" class="btn btn-default" name="price_bracket_delete" value="Löschen"/></p>
	</form>
</div>
</body>
<?php
	}
?>