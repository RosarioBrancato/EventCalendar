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
			<form method="post" action="Event.php">
				<input type="hidden" name="mode" value="<?php echo $mode; ?>" />
				<input type="hidden" name="id" value="<?php echo $id; ?>" />
				<div class="row">
					<div class="col-sm-4 col-sm-offset-2">
						* müssen ausgefüllt werden
					</div>
				</div>
				<!--NAME-->
				<div class="row">
					<div class="col-sm-2 div-to-block height-fixed">
						<p class="hidden-xs  p-text-vertical-center text-right">Name*</p>
						<p class="visible-xs p-text-vertical-center">Name*</p>
					</div>
					<div class="col-sm-4 height-fixed">
						<input type="text" class="form-control" name="name" maxlength="100" required="required" value="<?php echo $name; ?>"  <?php if($mode === MODE_DELETE){ echo 'readonly="readonly"'; } ?> />
					</div>
				</div>
				<!--CAST-->
				<div class="row">
					<div class="col-sm-2 div-to-block height-fixed">
						<p class="hidden-xs  p-text-vertical-center text-right">Besetzung</p>
						<p class="visible-xs p-text-vertical-center">Besetzung</p>
					</div>
					<div class="col-sm-4 height-fixed">
						<input type="text" class="form-control" name="cast" maxlength="255" value="<?php echo $cast; ?>" <?php if($mode === MODE_DELETE){ echo 'readonly="readonly"'; } ?> />
					</div>
				</div>
				<!--DESCRIPTION-->
				<div class="row">
					<div class="col-sm-2 div-to-block height-fixed">
						<p class="hidden-xs  p-text-vertical-center text-right">Beschreibung*</p>
						<p class="visible-xs p-text-vertical-center">Beschreibung*</p>
					</div>
					<div class="col-sm-4">
						<textarea class="form-control" name="description" maxlength="1024" rows="3" required="required" <?php if($mode === MODE_DELETE){ echo 'readonly="readonly"'; } ?> ><?php echo $description; ?></textarea>
					</div>
				</div>
				<!--DURATION-->
				<div class="row">
					<div class="col-sm-2 div-to-block height-fixed">
						<p class="hidden-xs  p-text-vertical-center text-right">Dauer (HH:MM)*</p>
						<p class="visible-xs p-text-vertical-center">Dauer (HH:MM)*</p>
					</div>
					<div class="col-sm-4 height-fixed">
						<input type="time" class="form-control" name="duration" required="required" value="<?php echo $duration; ?>"  <?php if($mode === MODE_DELETE){ echo 'readonly="readonly"'; } ?> />
					</div>
				</div>
				<!--PICTURE-->
				<div class="row">
					<div class="col-sm-2 div-to-block height-fixed">
						<p class="hidden-xs  p-text-vertical-center text-right">Bild</p>
						<p class="visible-xs p-text-vertical-center">Bild</p>
					</div>
					<div class="col-sm-4 height-fixed">
						<input type="file" name="picture" accept="image/png" value="<?php echo $picture; ?>"  <?php if($mode === MODE_DELETE){ echo 'disabled="disabled"'; } ?> />							
					</div>
				</div>
				<!--PICTURE TEXT-->
				<div class="row">
					<div class="col-sm-2 div-to-block height-fixed">
						<p class="hidden-xs  p-text-vertical-center text-right">Bildbeschreibung</p>
						<p class="visible-xs p-text-vertical-center">Bildbeschreibung</p>
					</div>
					<div class="col-sm-4 height-fixed">
						<input type="text" class="form-control" name="picture_text" maxlength="255" value="<?php echo $pictureText; ?>" <?php if($mode === MODE_DELETE){ echo 'readonly="readonly"'; } ?> />
					</div>
				</div>
				<!--GENRE-->
				<div class="row">
					<div class="col-sm-2 div-to-block height-fixed">
						<p class="hidden-xs  p-text-vertical-center text-right">Genre*</p>
						<p class="visible-xs p-text-vertical-center">Genre*</p>
					</div>
					<div class="col-sm-4 height-fixed">
						<select class="form-control" name="genre_id" required="required" <?php if($mode === MODE_DELETE){ echo 'readonly="readonly"'; } ?> />
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
					</div>
				</div>
				<!--BUTTONS-->
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
							<input type="submit" class="btn btn-success" name="event_save" value="Speichern"/>
							<a class="btn btn-danger" href="Event.php">Abbrechen</a>
<?php 						
						} else if($mode === MODE_EDIT) {
?>
							<input type="submit" class="btn btn-success" name="event_save" value="Speichern"/>
							<a class="btn btn-danger" href="Event.php">Abbrechen</a>
<?php
						} else if($mode === MODE_DELETE) {
?>
							<input type="submit" class="btn btn-success" name="event_save" value="Ja"/>
							<a class="btn btn-danger" href="Event.php">Nein</a>
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