<?php

include_once('GeneralTags.php');

function showEventArchiveGui($data, $genres, $selectedGenreId) {
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
			<?php getNavMenuCalendar(NAVBAR_SELECTION_ARCHIVE); ?>
		</div>
		<div class="col-sm-9">
			<h1 class="page-header">Veranstaltung</h1>
			
			<!--genre row-->
			<div class="row">
				<form action="Event-Archive.php" method="get">
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
<?php
	if($data != null && sizeof($data) > 0) {
		foreach($data as $bo) {
?>
			<!--whole event row-->
			<div class="row">
				<div class="col-sm-12">
	
					<!--event name row-->
					<div class="row div-bordered-warning">
						<div class="col-sm-9">
							<h3><?php echo $bo->getName(); ?></h3>
						</div>
						
						
					</div>
					<!--event row-->
					<div class="row">
						<div class="col-sm-12">
							
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
									<?php echo nl2br($bo->getDescription()); ?>
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
<?php 
						if(strlen($bo->getPicture()) > 0) { 
?>
							<!--picture row-->
							<div class="row">
								<div class="col-sm-3">
									Bild:
								</div>
								<div class="col-sm-9">
									<!--TO-DO-->
								</div>
							</div>
							
							<!--picture text row-->
							<div class="row">
								<div class="col-sm-3">
									Text zum Bild:
								</div>
								<div class="col-sm-9">
									<?php echo $bo->getPictureText(); ?>
								</div>
							</div>
<?php
						}
						
						if($bo->getGenre() != null) {
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
<?php
						}
?>							
						</div>
					</div>
					
<?php
				if(sizeof($bo->getLinks()) > 0) {
?>
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
						foreach($bo->getLinks() as $link) {
?>
							<div class="row">
								<div class="col-sm-3">
									<?php echo $link->getName(); ?>
								</div>
								<div class="col-sm-9">
									<a href="<?php echo $link->getLink(); ?>"><?php echo $link->getLink(); ?></a>
								</div>
							</div>
<?php
						}
?>
						</div>
					</div>				
<?php
				}
				
				if(sizeof($bo->getPriceBrackets()) > 0) {
?>
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
						foreach($bo->getPriceBrackets() as $priceBracket) {
?>
							<div class="row">
								<div class="col-sm-3">
									<?php echo $priceBracket->getName(); ?>
								</div>
								<div class="col-sm-9">
									<?php echo $priceBracket->getPrice(); ?> Fr.
								</div>
							</div>
<?php
						}
?>
						</div>
					</div>
<?php
				}
				
				if(sizeof($bo->getPerformances()) > 0) {
?>
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
						foreach($bo->getPerformances() as $performance) {
?>
							<div class="row">
								<div class="col-sm-3">
									<?php echo $performance->getDate(); ?>
								</div>
								<div class="col-sm-9">
									<?php echo $performance->getTime(); ?>
								</div>
							</div>
<?php
						}
?>
						</div>
					</div>
<?php
				}
?>
				</div>
			</div>
<?php
		}
	} else {
?>
			<div class="row">
				<div class="col-sm-12 text-center"><h3>Keine Vorstellungen</h3></div>
			</div>
<?php
	}
?>		
			<div class="row div-bordered-warning">
				<div class="col-sm-12 text-center"><a href="LogIn.php">Administration</a></div>
			</div>
		</div>
	</div>
</div>
</body>
</html>
<?php
}
?>