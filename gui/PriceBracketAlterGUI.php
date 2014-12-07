<?php

include_once('GeneralTags.php');

function showPriceBracketAlterGui($mode, $data, $message) {
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
	<div class="row">
		<div class="col-sm-3">
			<?php getNavMenu(NAVBAR_SELECTION_PRICE_BRACKET); ?>
		</div>
		<div class="col-sm-9">
			<h1 class="page-header">Preisgruppen</h1>
<?php
	if($message != null) {
?>
			<div class="<?php echo $message->getClassAlert(); ?>"><?php echo $message->getText(); ?></div>
<?php
	}
?>
			<form method="post" action="../domain/PriceBracket.php">
				<input type="hidden" name="mode" value="<?php echo $mode; ?>" />
				<input type="hidden" name="id" value="<?php echo $id; ?>" />
				<div class="row">
					<div class="col-sm-4 col-sm-offset-2">
						* müssen ausgefüllt werden
					</div>
				</div>
				<div class="row">
					<div class="col-sm-2 div-to-block height-fixed">
						<p class="hidden-xs  p-text-vertical-center text-right">Name*</p>
						<p class="visible-xs p-text-vertical-center">Name*</p>
					</div>
					<div class="col-sm-4 height-fixed">
						<input type="text" class="form-control" name="name" value="<?php echo $name; ?>" required="required" maxlength="50" <?php if($mode === MODE_DELETE){ echo 'readonly="readonly"'; } ?> />
					</div>
				</div>
				<div class="row">
					<div class="col-sm-2 div-to-block height-fixed">
						<p class="hidden-xs  p-text-vertical-center text-right">Preis*</p>
						<p class="visible-xs p-text-vertical-center">Preis*</p>
					</div>
					<div class="col-sm-4 height-fixed">
						<input type="number" class="form-control" name="price" min="0" max="900" step="0.05" value="<?php echo $price; ?>" required="required" <?php if($mode === MODE_DELETE){ echo 'readonly="readonly"'; } ?> />
					</div>
				</div>
				<div class="row">
					<div class="col-sm-2 div-to-block height-fixed">
<?php			
					if($mode === MODE_DELETE){
?>				
						<p class="hidden-xs  p-text-vertical-center text-right">Wirklich löschen?</p>
						<p class="visible-xs p-text-vertical-center">Wirklich löschen?</p>
<?php
					} 
?>
					</div>
					<div class="col-sm-4 height-fixed">
						<p>
<?php 						
						if ($mode === MODE_NEW) {
?>
							<input type="submit" class="btn btn-success" name="price_bracket_save" value="Speichern"/>
							<a class="btn btn-danger" href="../domain/PriceBracket.php">Abbrechen</a>
<?php 						
						} else if($mode === MODE_EDIT) {
?>
							<input type="submit" class="btn btn-success" name="price_bracket_save" value="Speichern"/>
							<a class="btn btn-danger" href="../domain/PriceBracket.php">Abbrechen</a>
<?php
						} else if($mode === MODE_DELETE) {
?>
							<input type="submit" class="btn btn-success" name="price_bracket_save" value="Ja"/>
							<a class="btn btn-danger" href="../domain/PriceBracket.php">Nein</a>
<?php 						
						}
?>
						</p>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
</body>
<?php
	}
?>