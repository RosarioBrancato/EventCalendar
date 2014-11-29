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
			<table class="table table-hover">
				<tr>
					<th class="col-sm-2">Name</th>
					<th class="col-sm-2">Besetzung</th>
					<th class="col-sm-5">Beschreibung</th>
					<th class="col-sm-3">Funktionen</th>
				</tr>
<?php
		if($data != null) {
			foreach($data as $bo) {
?>
				<tr>
					<td class="col-sm-2"><?php echo $bo->getName(); ?></td>
					<td class="col-sm-2"><?php echo $bo->getCast(); ?></td>
					<td class="col-sm-5"><?php echo $bo->getDescription(); ?></td>
					<td class="col-sm-3">
						<form action="../domain/Event.php" method="post" class="no-margin">
							<input type="hidden" name="id" value="<?php echo $bo->getId(); ?>" />
							<input type="submit" class="btn btn-info" name="event_edit" value="Bearbeiten" />
							<input type="submit" class="btn btn-danger" name="event_delete" value="Löschen" />
						</form>
					</td>
				</tr>
<?php
			}
		} else {
?>
				<tr>
					<td class="col-sm-2">Keine Einträge</td>
					<td class="col-sm-2"></td>
					<td class="col-sm-5"></td>
					<td class="col-sm-3"></td>
				</tr>
<?php
		}
?>
			</table>

		</div>
	</div>
</div>
</body>
</html>
<?php
}
?>