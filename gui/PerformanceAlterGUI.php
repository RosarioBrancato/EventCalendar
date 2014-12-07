<?php

include_once('GeneralTags.php');

function showPerformanceAlterGui($mode, $data, $message, $event) {
	$id = 0;
	$date = '';
	$time = '';
	
	$event_id = 0;
	$event_name = '';
	
	if($data != null) {
		$id = $data->getId();
		$date = $data->getDate();
		$time  = $data->getTime();
		$event_id = $data->getEventId();
	}
	
	if($event != null) {
		$event_id = $event->getId();
		$event_name = $event->getName();
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
			<h1 class="page-header">Vorstellung</h1>
<?php
	if($message != null) {
?>
			<div class="<?php echo $message->getClassAlert(); ?>"><?php echo $message->getText(); ?></div>
<?php
	}
?>
			<form method="post" action="../domain/Performance.php">
				<input type="hidden" name="mode" value="<?php echo $mode; ?>" />
				<input type="hidden" name="performance_id" value="<?php echo $id; ?>" />
				<input type="hidden" name="event_id" value="<?php echo $event_id; ?>" />
				<div class="row">
					<div class="col-sm-3 div-to-block height-fixed">
						<p class="hidden-xs  p-text-vertical-center text-right"><strong>Veranstaltung</strong></p>
						<p class="visible-xs p-text-vertical-center"><strong>Veranstaltung</strong></p>
					</div>
					<div class="col-sm-9 div-to-block height-fixed">
						<p class="p-text-vertical-center"><strong><?php echo $event_name; ?></strong></p>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4 col-sm-offset-3 div-to-block">
						<p class="p-text-vertical-center">* müssen ausgefüllt werden</p>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3 div-to-block height-fixed">
						<p class="hidden-xs  p-text-vertical-center text-right">Datum (DD.MM.YYYY)*</p>
						<p class="visible-xs p-text-vertical-center">Datum (DD.MM.YYYY)*</p>
					</div>
					<div class="col-sm-3 height-fixed">
						<input type="date" class="form-control" name="performance_date" value="<?php echo $date; ?>" maxlength="50" <?php if($mode === MODE_DELETE){ echo 'readonly="readonly"'; } ?> />
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3 div-to-block height-fixed">
						<p class="hidden-xs  p-text-vertical-center text-right">Zeit (HH:MM)*</p>
						<p class="visible-xs p-text-vertical-center">Zeit (HH:MM)*</p>
					</div>
					<div class="col-sm-3 height-fixed">
						<input type="time" class="form-control" name="performance_time" value="<?php echo $time; ?>" required="required" <?php if($mode === MODE_DELETE){ echo 'readonly="readonly"'; } ?> />
					</div>
				</div>
				<div class="row">
					<div class="col-sm-3 div-to-block height-fixed">
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
							<input type="submit" class="btn btn-success" name="performance_save" value="Speichern"/>
							<a class="btn btn-danger" href="../domain/Event.php">Abbrechen</a>
<?php 						
						} else if($mode === MODE_EDIT) {
?>
							<input type="submit" class="btn btn-success" name="performance_save" value="Speichern"/>
							<a class="btn btn-danger" href="../domain/Event.php">Abbrechen</a>
<?php
						} else if($mode === MODE_DELETE) {
?>
							<input type="submit" class="btn btn-success" name="performance_save" value="Ja"/>
							<a class="btn btn-danger" href="../domain/Event.php">Nein</a>
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