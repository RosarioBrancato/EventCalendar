<?php

include_once('GeneralTags.php');

function showEventArchiveOverviewGui($data, $genres, $year, $selectedGenreId) {
	//genre filter selection
	$sel_genre_id = 0;
	if($selectedGenreId != null && $selectedGenreId > 0) {
		$sel_genre_id = $selectedGenreId;
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
			<?php getNavMenuCalendar($year); ?>
		</div>
		<div class="col-sm-9">
			<h1 class="page-header">Veranstaltungen - Archiv Jahr <?php echo $year; ?></h1>

			<!--genre row-->
			<div class="row">
				<form action="Event-Archive.php" method="get">
					<input type="hidden" name="year" value="<?php echo $year; ?>" />
					<div class="col-sm-2 div-to-block height-fixed">
						<p class="hidden-xs  p-text-vertical-center text-right">Genre:</p>
						<p class="visible-xs p-text-vertical-center">Genre</p>
					</div>
					<div class="col-sm-4">
						<p><select class="form-control" name="genre_id">
							<option value="" <?php if($sel_genre_id == 0){ echo 'selected="selected"'; } ?>>Alle Genres</option>
<?php
					if($genres != null) {
						foreach($genres as $g) {
?>
							<option value="<?php echo $g->getId(); ?>" <?php if($sel_genre_id == $g->getId()){ echo 'selected="selected"'; } ?>><?php echo $g->getName(); ?></option>
<?php
						}
					}
?>
						</select></p>
					</div>
					<div class="col-sm-3">
						<p><input type="submit" class="btn btn-info" name="genre_change" value="Aktualisieren" /></p>
					</div>
				</form>
			</div>

			
			<table class="table table-hover">
				<tr>
					<th class="col-sm-3">Name</th>
					<th class="col-sm-6">Beschreibung</th>
					<th class="col-sm-2"></th>
				</tr>
<?php
		if($data != null) {
			foreach($data as $bo) {
?>
				<tr>
					<td class="col-sm-3"><?php echo $bo->getName(); ?></td>
					<td class="col-sm-6"><?php echo $bo->getDescription(); ?></td>
					<td class="col-sm-2">
						<form action="Event-Archive.php" method="get" class="no-margin">
							<input type="hidden" name="event_id" value="<?php echo $bo->getId(); ?>" />
							<input type="hidden" name="year" value="<?php echo $year; ?>" />
							<input type="hidden" name="genre_id" value="<?php echo $sel_genre_id; ?>" />
							<input type="submit" class="btn btn-info" name="event_archive_detail" value="Details" />
						</form>
					</td>
				</tr>
<?php
			}
		} else {
?>
				<tr>
					<td class="col-sm-3">Keine Vorstellungen</td>
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