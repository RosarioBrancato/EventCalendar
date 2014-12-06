<?php

include_once('GeneralTags.php');
include_once('../constant/Constants.php');

function showEventGui($data, $message) {
?>
<!DOCTYPE html>
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
			<form action="../domain/Event.php" method="post">
				<p><input type="submit" class="btn btn-success" name="event_new" value="Neue Veranstaltung erfassen" /></p>
			</form>
			
			<!--whole event row-->
			<div class="row">
				<div class="col-sm-12">
<?php
	if($data != null) {
		foreach($data as $bo) {
?>	
					<!--event name row-->
					<div class="row div-bordered-warning">
						<div class="col-sm-12">
							<h3><?php echo $bo->getName(); ?></h3>
						</div>
					</div>
					<!--event row-->
					<div class="row">
						<div class="col-sm-9">
							
<?php 
						if(strlen($bo->getCast()) > 0){ 
?>
							<!--cast row-->
							<div class="row">
								<div class="col-sm-3">
									Besetzung:
								</div>
								<div class="col-sm-9">
									<?php echo $bo->getCast(); ?>
								</div>
							</div>
<?php
						} 
?>
							<!--descrition row-->
							<div class="row">
								<div class="col-sm-3">
									Beschreibung:
								</div>
								<div class="col-sm-9">
									<?php echo $bo->getDescription(); ?>
								</div>
							</div>
							
							<!--descrition row-->
							<div class="row">
								<div class="col-sm-3">
									Dauer:
								</div>
								<div class="col-sm-9">
									<?php echo $bo->getDuration(); ?>
								</div>
							</div>
							
							<!--picture row-->
							<div class="row">
								<div class="col-sm-3">
									Bild:
								</div>
								<div class="col-sm-9">
									<!--TO-DO-->
								</div>
							</div>
<?php 
						if(strlen($bo->getPictureText()) > 0){ 
?>
							<!--picture text row-->
							<div class="row">
								<div class="col-sm-3">
									Bildbeschreibung:
								</div>
								<div class="col-sm-9">
									<?php echo $bo->getPictureText(); ?>
								</div>
							</div>
<?php
						} 
?>
							<!--genre row-->
							<div class="row">
								<div class="col-sm-3">
									Genre:
								</div>
								<div class="col-sm-9">
									<?php echo $bo->getGenre()->getName(); ?>
								</div>
							</div>
							
						</div>
						<div class="col-sm-3">
							<form action="../domain/Event.php" method="post" class="no-margin">
								<input type="hidden" name="id" value="<?php echo $bo->getId(); ?>" />
								<input type="submit" class="btn btn-info" name="event_edit" value="Bearbeiten" />
								<input type="submit" class="btn btn-danger" name="event_delete" value="Löschen" />
							</form>
						</div>
					</div>
					
					<!--link row-->
					<div class="row div-bordered">
						<div class="col-sm-9">
							<p>Name</p>
							<p>Link</p>
						</div>
						<div class="col-sm-3">
							<form action="../domain/Event.php" method="post" class="no-margin">
								<input type="hidden" name="id" value="<?php echo $bo->getId(); ?>" />
								<input type="submit" class="btn btn-info" name="event_edit" value="Bearbeiten" />
								<input type="submit" class="btn btn-danger" name="event_delete" value="Löschen" />
							</form>
						</div>
					</div>
					
					<!--price bracket row-->
					<div class="row div-bordered">
						<div class="col-sm-9">
							<p>Name</p>
							<p>Price</p>
						</div>
						<div class="col-sm-3">
							<form action="../domain/Event.php" method="post" class="no-margin">
								<input type="hidden" name="id" value="<?php echo $bo->getId(); ?>" />
								<input type="submit" class="btn btn-info" name="event_edit" value="Bearbeiten" />
								<input type="submit" class="btn btn-danger" name="event_delete" value="Löschen" />
							</form>
						</div>
					</div>
					
<?php
			}
		} else {
?>
				<div class="row">
					<div class="col-sm-11">Keine Einträge</div>
				</div>
<?php
		}
?>
				</div>
			</div>
		</div>
	</div>
</div>
</body>
</html>
<?php
}
?>