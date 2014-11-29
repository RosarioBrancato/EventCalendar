<?php

include_once('GeneralTags.php');

function showEventAlterGui($mode, $data, $message, $genres) {
	$id = 0;
	$name = '';
	$cast = '';
	$description = '';
	$duration = null;
	$picture = '';
	$pictureText = '';
	$genre_id = 0;
	
	if($data != null) {
		$id = $data->getId();
		$name = $data->getName();
		$cast  = $data->getCast();
		$description = $data->getDescription();
		$duration = $data->getDuration();
		$picture = $data->getPicture();
		$pictureText = $data->getPictureText();
		$genre_id = $data->getGenreId();
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
			<?php getNavMenu(NAVBAR_SELECTION_EVENT); ?>
		</div>
		<div class="col-sm-9">
			<h1 class="page-header">Veranstaltungen</h1>
<?php
	if($message != null) {
?>
			<div class="<?php echo $message->getClassAlert(); ?>"><?php echo $message->getText(); ?></div>
<?php
	}
?>
			<form method="post" action="../domain/Event.php">
				<input type="hidden" name="mode" value="<?php echo $mode; ?>" />
				<input type="hidden" name="id" value="<?php echo $id; ?>" />
				<table class="table">
					<!--NAME-->
					<tr>
						<td class="col-sm-2 text-right no-border">
							Name:
						</td>
						<td class="col-sm-4 no-border">
							<input type="text" class="form-control" name="name" maxlength="100" required="required" value="<?php echo $name; ?>"  <?php if($mode === MODE_DELETE){ echo 'readonly="readonly"'; } ?> />
						</td>
						<td class="col-sm-6 no-border"></td>
					</tr>
					<!--CAST-->
					<tr>
						<td class="col-sm-2 text-right no-border">
							Besetzung:
						</td>
						<td class="col-sm-4 no-border">
							<input type="text" class="form-control" name="cast" maxlength="255" value="<?php echo $cast; ?>" <?php if($mode === MODE_DELETE){ echo 'readonly="readonly"'; } ?> />
						</td>
						<td class="col-sm-6 no-border"></td>
					</tr>
					<!--DESCRIPTION-->
					<tr>
						<td class="col-sm-2 text-right no-border">
							Beschreibung:
						</td>
						<td colspan="2" class="col-sm-10 no-border">
							<textarea class="form-control text-left" name="description" maxlength="1024" rows="5" required="required" <?php if($mode === MODE_DELETE){ echo 'readonly="readonly"'; } ?> ><?php echo $description; ?></textarea>
						</td>
					</tr>
					<!--DURATION-->
					<tr>
						<td class="col-sm-2 text-right no-border">
							Länge:
						</td>
						<td class="col-sm-4 no-border">
							<input type="time" class="form-control" name="duration" required="required" value="<?php echo $duration; ?>"  <?php if($mode === MODE_DELETE){ echo 'readonly="readonly"'; } ?> />
						</td>
						<td class="col-sm-6 no-border"></td>
					</tr>
					<!--PICTURE-->
					<tr>
						<td class="col-sm-2 text-right no-border">
							Bild:
						</td>
						<td class="col-sm-4 no-border">
							<input type="file" name="picture" accept="image/png" value="<?php echo $picture; ?>"  <?php if($mode === MODE_DELETE){ echo 'disabled="disabled"'; } ?> />							
						</td>
						<td class="col-sm-6 no-border"></td>
					</tr>
					<!--PICTURE TEXT-->
					<tr>
						<td class="col-sm-2 text-right no-border">
							Bildbeschreibung:
						</td>
						<td class="col-sm-4 no-border">
							<input type="text" class="form-control" name="picture_text" maxlength="255" value="<?php echo $pictureText; ?>" <?php if($mode === MODE_DELETE){ echo 'readonly="readonly"'; } ?> />
						</td>
						<td class="col-sm-6 no-border"></td>
					</tr><!--GENRE-->
					<tr>
						<td class="col-sm-2 text-right no-border">
							Genre:
						</td>
						<td class="col-sm-4 no-border">
							<select class="form-control" name="genre_id" required="required" <?php if($mode === MODE_DELETE){ echo 'disabled="disabled"'; } ?> />
<?php
						if($genres != null) {
							foreach($genres as $genre) {
?>
								<option value="<?php echo $genre->getId(); ?>" <?php if($genre_id == $genre->getId()){ echo 'selected'; } ?>><?php echo $genre->getName(); ?></option>
<?php
							}
						}
?>
							</select>
						</td>
						<td class="col-sm-6 no-border"></td>
					</tr>
					<!--BUTTONS-->
					<tr>
						<td class="col-sm-2 text-right no-border"><?php if($mode === MODE_DELETE){ echo 'Wirklich löschen?'; } ?></td>
						<td class="col-sm-4 no-border">
							<p>
<?php 						
							if ($mode === MODE_NEW) {
?>
								<input type="submit" class="btn btn-success" name="event_save" value="Speichern"/>
								<!--<input type="submit" class="btn btn-danger" name="price_bracket_cancel" value="Abbrechen"/>-->
								<a class="btn btn-danger" href="../domain/Event.php">Abbrechen</a>
<?php 						
							} else if($mode === MODE_EDIT) {
?>
								<input type="submit" class="btn btn-success" name="event_save" value="Speichern"/>
								<a class="btn btn-danger" href="../domain/Event.php">Abbrechen</a>
<?php
							} else if($mode === MODE_DELETE) {
?>
								<input type="submit" class="btn btn-success" name="event_save" value="Ja"/>
								<a class="btn btn-danger" href="../domain/Event.php">Nein</a>
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