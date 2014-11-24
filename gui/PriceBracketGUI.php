<?php

include_once('GeneralTags.php');

function showPriceBracketGui($data, $message) {
	
?>
<html>
<head>
	<?php getHeadTags(); ?>
</head>
<body>
<?php getHeader(); ?>
<div class="container">
	<h1 class="page-header">Preisgruppen</h1>
<?php
	if($message != null) {
?>
	<div class="<?php echo $message->getClassAlert(); ?>"><?php echo $message->getText(); ?></div>
<?php
	}
?>
	<table class="table table-hover">
		<tr>
			<th>Name</th>
			<th>Preis</th>
		</tr>
<?php
	if($data != null) {
		foreach($data as $bo) {
			echo '<tr>';
			echo '	<td>' . $bo->getName() . '</td>';
			echo '	<td>' . $bo->getPrice() . '</td>';
			echo '</tr>';
		}
	} else {
		echo '<tr>';
		echo '	<td>Keine Einträge</td>';
		echo '	<td></td>';
		echo '</tr>';
	}
?>
	</table>
	
</div>
</body>
</html>
<?php
}
?>