<?php function getHeadTags() { ?>
	<!--Meta-->
	<meta charset="utf-8">
	<meta name="author" content="Rosario Brancato" />
	
	<!--Google jQuery csn-->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap-theme.min.css">
	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	
	<!--Titel-->
	<title>Event-Kalender</title>
<?php } ?>

<?php
    function getHeader() {
?>
        <header class="container-fluid bg-primary">
            <div class="container row  center-block">
                <div class="col-sm-9">
                        <h2><a class="text-warning" href="../index.php"><strong>Event-Kalender</strong></a></h2> 
                </div>
                <div class="col-sm-3">
<?php
        if(isset($_SESSION['username'])) {
?>
                    <form method="post" action="../domain/LogOut.php" class="form-inline" role="form">
						<h3>Hallo <?php echo $_SESSION['username']; ?>
						<input type="submit" class="btn btn-warning" name="log_out" value="Abmelden"/></h3>
					</form>
<?php
        }
?>
                </div>
            </div>
        </header>
<?php  
    }
?>