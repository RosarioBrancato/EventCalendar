<?php

include_once('GeneralTags.php');
include_once('../constant/Constants.php');

function showGenreGui($data, $message) {
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
			<form action="../domain/Genre.php" method="post">
				<p><input type="submit" class="btn btn-success" name="genre_new" value="Neues Genre erfassen" /></p>
			</form>
			<table class="table table-hover">
				<tr>
					<th class="col-sm-8">Name</th>
					<th class="col-sm-4">Funktionen</th>
				</tr>
<?php
		if($data != null) {
			foreach($data as $bo) {
?>
				<tr>
					<td class="col-sm-8"><?php echo $bo->getName(); ?></td>
					<td class="col-sm-4">
						<form action="../domain/Genre.php" method="post" class="no-margin">
							<input type="hidden" name="id" value="<?php echo $bo->getId(); ?>" />
							<input type="submit" class="btn btn-info" name="genre_edit" value="Bearbeiten" />
							<input type="submit" class="btn btn-danger" name="genre_delete" value="Löschen" />
						</form>
					</td>
				</tr>
<?php
			}
		} else {
?>
				<tr>
					<td class="col-sm-8">Keine Einträge</td>
					<td class="col-sm-4"></td>
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