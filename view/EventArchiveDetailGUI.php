<?php

include_once('GeneralTags.php');

function showEventArchiveDetailGui($data, $year, $genre) {

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
			<h1 class="page-header">Veranstaltung</h1>

			<div class="row">
				<div class="col-sm-3">
					<p><a href="<?php echo 'Event-Archive.php?genre=' . $genre . '&year=' . $year; ?>" class="btn btn-info">Zurück zur Übersicht</a></p>
				</div>
			</div>
			
			<!--whole event row-->
			<div class="row">
				<div class="col-sm-12">
<?php
				if($data != null) {
?>	
					<!--event name row-->
					<div class="row div-bordered-warning">
						<div class="col-sm-9">
							<h3><?php echo $data->getName(); ?></h3>
						</div>
						
						
					</div>
					<!--event row-->
					<div class="row">
						<div class="col-sm-12">
							
<?php 
						if(strlen($data->getCast()) > 0){ 
?>
							<!--cast row-->
							<div class="row">
								<div class="col-sm-3">
									Besetzung:
								</div>
								<div class="col-sm-9">
									<?php echo $data->getCast(); ?>
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
									<?php echo nl2br($data->getDescription()); ?>
								</div>
							</div>
							
							<!--descrition row-->
							<div class="row">
								<div class="col-sm-3">
									Dauer:
								</div>
								<div class="col-sm-9">
									<?php echo $data->getDuration(); ?>
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
						if(strlen($data->getPictureText()) > 0){ 
?>
							<!--picture text row-->
							<div class="row">
								<div class="col-sm-3">
									Text zum Bild:
								</div>
								<div class="col-sm-9">
									<?php echo $data->getPictureText(); ?>
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
									<?php echo $data->getGenre()->getName(); ?>
								</div>
							</div>
							
						</div>
					</div>
					
					<!--link row-->
					<div class="row div-bordered">
						<div class="col-sm-12">
							
							<!--title-->
							<div class="row">
								<div class="col-sm-12">
									<h4>Links</h4>
								</div>
							</div>
<?php
						foreach($data->getLinks() as $link) {
?>
							<div class="row">
								<div class="col-sm-3">
									<?php echo $link->getName(); ?>
								</div>
								<div class="col-sm-6">
									<a href="<?php echo $link->getLink(); ?>"><?php echo $link->getLink(); ?></a>
								</div>
							</div>
<?php
						}
?>
						
						</div>
					</div>
					
					<!--price bracket row-->
					<div class="row div-bordered">
						<div class="col-sm-12">
						
							<!--title-->
							<div class="row">
								<div class="col-sm-12">
									<h4>Preise</h4>
								</div>
							</div>
<?php
						foreach($data->getPriceBrackets() as $priceBracket) {
?>
							<div class="row">
								<div class="col-sm-3">
									<?php echo $priceBracket->getName(); ?>
								</div>
								<div class="col-sm-6">
									<?php echo $priceBracket->getPrice(); ?> Fr.
								</div>
							</div>
<?php
						}
?>
						
						</div>
					</div>

					<!--performance row-->
					<div class="row div-bordered">
						<div class="col-sm-12">
							
							<!--title-->
							<div class="row">
								<div class="col-sm-12">
									<h4>Vorstellungen</h4>
								</div>
							</div>
<?php
						foreach($data->getPerformances() as $performance) {
?>
							<div class="row">
								<div class="col-sm-3">
									<?php echo $performance->getDate(); ?>
								</div>
								<div class="col-sm-6">
									<?php echo $performance->getTime(); ?>
								</div>
							</div>
<?php
						}
?>
						
						</div>
					</div>
					
<?php
		
				} else {
?>
					<div class="row">
						<div class="col-sm-11">Keine Einträge</div>
					</div>
<?php
				}
?>
					<div class="row div-bordered-warning"></div>
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