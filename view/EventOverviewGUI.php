<?php

include_once('GeneralTags.php');

function showEventOverviewGui($data) {
	$message = null;
	
	if(isset($_SESSION['message_type']) && isset($_SESSION['message_text'])) {
		$message  = new MessageBO($_SESSION['message_text'], $_SESSION['message_type']);
		
		unset($_SESSION['message_type']);
		unset($_SESSION['message_text']);
	}

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
			<form action="Event.php" method="post">
				<p><input type="submit" class="btn btn-success" name="event_new" value="Neue Veranstaltung erfassen" /></p>
			</form>
			<table class="table table-hover">
				<tr>
					<th class="col-sm-3">Name</th>
					<th class="col-sm-6">Beschreibung</th>
					<th class="col-sm-2">Funktionen</th>
				</tr>
<?php
		if($data != null) {
			foreach($data as $bo) {
?>
				<tr>
					<td class="col-sm-3"><?php echo $bo->getName(); ?></td>
					<td class="col-sm-6"><?php if(strlen($bo->getDescription()) > 130) { echo substr($bo->getDescription(), 0, 130) . '...'; } else { echo $bo->getDescription(); } ?></td>
					<td class="col-sm-2">
						<form action="Event.php" method="get" class="no-margin">
							<input type="submit" class="btn btn-info" name="event_detail" value="Details" />
							<input type="hidden" name="e" value="<?php echo $bo->getId(); ?>" />
						</form>
					</td>
				</tr>
<?php
			}
		} else {
?>
				<tr>
					<td class="col-sm-3">Keine Einträge</td>
					<td class="col-sm-6"></td>
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