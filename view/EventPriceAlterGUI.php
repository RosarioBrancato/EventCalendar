<?php

include_once('GeneralTags.php');

function showEventPriceAlterGui($mode, $priceBrackets, $message, $event, $priceBracketId) {
	$event_id = 0;
	$event_name = '';
	
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
			<h1 class="page-header">Preis</h1>
<?php
	if($message != null) {
?>
			<div class="<?php echo $message->getClassAlert(); ?>"><?php echo $message->getText(); ?></div>
<?php
	}
?>
			<form method="post" action="Event.php">
				<input type="hidden" name="mode" value="<?php echo $mode; ?>" />
				<input type="hidden" name="event_id" value="<?php echo $event_id; ?>" />
				<input type="hidden" name="event_name" value="<?php echo $event_name; ?>" />
				<input type="hidden" name="price_bracket_id_old" value="<?php echo $priceBracketId; ?>" />
				<div class="row">
					<div class="col-sm-2 div-to-block height-fixed">
						<p class="hidden-xs  p-text-vertical-center text-right"><strong>Veranstaltung</strong></p>
						<p class="visible-xs p-text-vertical-center"><strong>Veranstaltung</strong></p>
					</div>
					<div class="col-sm-4 div-to-block height-fixed">
						<p class="p-text-vertical-center"><strong><?php echo $event_name; ?></strong></p>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-2 div-to-block height-fixed">
						<p class="hidden-xs  p-text-vertical-center text-right">Preisgruppe</p>
						<p class="visible-xs p-text-vertical-center">Preisgruppe</p>
					</div>
					<div class="col-sm-5 height-fixed">
						<select class="form-control" name="price_bracket_id" <?php if($mode === MODE_DELETE){ echo 'readonly="readonly"'; } ?>>
<?php
				if($priceBrackets != null) {
					foreach($priceBrackets as $bo) {
?>
						<option value="<?php echo $bo->getId(); ?>" <?php if($bo->getId() == $priceBracketId) { echo 'selected="selected"'; } ?>><?php echo $bo->getName() . ' - ' . $bo->getPrice() . ' Fr.'; ?></option>
<?php
					}
				}
?>						
						</select>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-2 div-to-block height-fixed">
<?php			
					if($mode === MODE_DELETE){
?>				
						<p class="hidden-xs  p-text-vertical-center text-right">Wirklich entfernen?</p>
						<p class="visible-xs p-text-vertical-center">Wirklich entfernen?</p>
<?php
					} 
?>
					</div>
					<div class="col-sm-4 height-fixed">
						<p>
<?php 						
						if ($mode === MODE_NEW) {
?>
							<input type="submit" class="btn btn-success" name="event_price_save" value="Speichern"/>
							<a class="btn btn-danger" href="Event.php?e=<?php echo $event_id; ?>">Abbrechen</a>
<?php 						
						} else if($mode === MODE_EDIT) {
?>
							<input type="submit" class="btn btn-success" name="event_price_save" value="Speichern"/>
							<a class="btn btn-danger" href="Event.php?e=<?php echo $event_id; ?>">Abbrechen</a>
<?php
						} else if($mode === MODE_DELETE) {
?>
							<input type="submit" class="btn btn-success" name="event_price_save" value="Ja"/>
							<a class="btn btn-danger" href="Event.php?e=<?php echo $event_id; ?>">Nein</a>
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