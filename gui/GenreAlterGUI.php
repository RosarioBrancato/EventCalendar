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
			<form method="post" action="../domain/Genre.php">
				<input type="hidden" name="mode" value="<?php echo $mode; ?>" />
				<input type="hidden" name="id" value="<?php echo $id; ?>" />
				<table class="table">
					<tr>
						<td class="col-sm-2 text-right no-border">
							Name:
						</td>
						<td class="col-sm-4 no-border">
							<input type="text" class="form-control" name="name" value="<?php echo $name; ?>" maxlength="50" required="required" <?php if($mode === MODE_DELETE){ echo 'readonly="readonly"'; } ?> />
						</td>
						<td class="col-sm-6 no-border"></td>
					</tr>
					<tr>
						<td class="col-sm-2 text-right no-border"><?php if($mode === MODE_DELETE){ echo 'Wirklich löschen?'; } ?></td>
						<td class="col-sm-4 no-border">
							<p>
<?php 						
							if ($mode === MODE_NEW) {
?>
								<input type="submit" class="btn btn-success" name="genre_save" value="Speichern"/>
								<a class="btn btn-danger" href="../domain/Genre.php">Abbrechen</a>
<?php 						
							} else if($mode === MODE_EDIT) {
?>
								<input type="submit" class="btn btn-success" name="genre_save" value="Speichern"/>
								<a class="btn btn-danger" href="../domain/Genre.php">Abbrechen</a>
<?php
							} else if($mode === MODE_DELETE) {
?>
								<input type="submit" class="btn btn-success" name="genre_save" value="Ja"/>
								<a class="btn btn-danger" href="../domain/Genre.php">Nein</a>
<?php 						
							}
?>
							</p>
						</td>
						<td class="col-sm-6 no-border"></td>
					</tr>
				</table>
			</form>
		</div>
	</div>
</div>
</body>
<?php
	}
?>