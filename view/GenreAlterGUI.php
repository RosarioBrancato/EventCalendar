<?php

include_once('GeneralTags.php');

function showGenreAlterGui($mode, $data, $message) {
	$id = 0;
	$name = '';
	
	if($data != null) {
		$id = $data->getId();
		$name = $data->getName();
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
			<?php getNavMenu(NAVBAR_SELECTION_GENRE); ?>
		</div>
		<div class="col-sm-9">
			<h1 class="page-header">Genre</h1>
<?php
	if($message != null) {
?>
			<div class="<?php echo $message->getClassAlert(); ?>"><?php echo $message->getText(); ?></div>
<?php
	}
?>
			<form method="post" action="Genre.php">
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
						<input type="text" class="form-control" name="name" value="<?php echo $name; ?>" maxlength="50" required="required" <?php if($mode === MODE_DELETE){ echo 'readonly="readonly"'; } ?> />
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
							<input type="submit" class="btn btn-success" name="genre_save" value="Speichern"/>
							<a class="btn btn-danger" href="Genre.php">Abbrechen</a>
<?php 						
						} else if($mode === MODE_EDIT) {
?>
							<input type="submit" class="btn btn-success" name="genre_save" value="Speichern"/>
							<a class="btn btn-danger" href="Genre.php">Abbrechen</a>
<?php
						} else if($mode === MODE_DELETE) {
?>
							<input type="submit" class="btn btn-success" name="genre_save" value="Ja"/>
							<a class="btn btn-danger" href="Genre.php">Nein</a>
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