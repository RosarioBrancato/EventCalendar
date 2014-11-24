<?php

include_once('GeneralTags.php');
include_once('../constant/Constants.php');

function showPriceBracketGui($data, $message) {
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
			<?php getNavMenu(NAVBAR_SELECTION_PRICE_BRACKET); ?>
		</div>
		<div class="col-sm-9">
			<h1 class="page-header">Preisgruppen</h1>
<?php
		if($message != null) {
?>
			<div class="<?php echo $message->getClassAlert(); ?>"><?php echo $message->getText(); ?></div>
<?php
		}
?>
			<form action="../domain/PriceBracketAlter.php" method="post">
				<p><input type="submit" class="btn btn-success" name="price_bracket_new" value="Neue Preisgruppe erfassen" /></p>
			</form>
			<table class="table table-hover">
				<tr>
					<th>Name</th>
					<th class="text-right">Preis</th>
					<th></th>
					<th>Funktionen</th>
				</tr>
<?php
		if($data != null) {
			foreach($data as $bo) {
?>
				<tr>
					<td class="col-sm-3"><?php echo $bo->getName(); ?></td>
					<td class="col-sm-2 text-right"><?php echo $bo->getPrice(); ?></td>
					<td class="col-sm-3"></td>
					<td class="col-sm-4">
						<form action="../domain/PriceBracketAlter.php" method="post" class="no-margin">
							<input type="hidden" name="id" value="<?php echo $bo->getId(); ?>" />
							<input type="submit" class="btn btn-info" name="price_bracket_edit" value="Bearbeiten" />
							<input type="submit" class="btn btn-danger" name="price_bracket_delete" value="Löschen" />
						</form>
					</td>
				</tr>
<?php
			}
		} else {
?>
				<tr>
					<td class="col-sm-3">Keine Einträge</td>
					<td class="col-sm-2"></td>
					<td class="col-sm-3"></td>
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