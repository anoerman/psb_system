<?php session_start();

// Jika user sudah sign in
if (isset($_SESSION['username']) && isset($_SESSION['level']) && $_SESSION['username']!="" && $_SESSION['level']!="") {
	// Redirect dashboard
	header("Location: ./index.php");
	die();
}
else {
	?>
	<!DOCTYPE html>
	<html>
	<head>
		<title>
			Data PSB
		</title>
		<!-- Styling -->
		<link rel="stylesheet" type="text/css" href="./assets/css/site-default.min.css">
		<link rel="stylesheet" type="text/css" href="./assets/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="./assets/plugins/pace/pace.css">
		<link rel="icon" href="./assets/images/favicon.ico">
	</head>
	<body background="./assets/images/backgrounds/symphony.png">
		<div style="padding-top: 60px;"></div>
		<div class="container document">
	    	<div class="row">
		    	<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	    			<h3 class="text-center">
	    				Login Sistem
	    			</h3>
		    	</div>
	    	</div>
    	</div>
		<div class="container document">
	    	<div class="row">
		    	<div class="col-lg-6 col-lg-offset-3 col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2 col-xs-12">
		    		<?php // Tampilkan informasi jika ada!
		    		if (isset($_SESSION["informasi_formulir"])) {
		    			echo "<div class='alert alert-info'>".$_SESSION["informasi_formulir"]."</div>";
		    			unset($_SESSION["informasi_formulir"]);
		    		}
		    		?>
		    		<form class="form" action="proses_login.php" method="post">
		    			<div class="panel panel-default">
		    				<div class="panel-body">
		    					<div class="form-group">
		    						<label class="control-label" for="username">
		    							Username
		    						</label>
	    							<input type="text" class="form-control" name="username" id="username" autofocus="">
		    					</div>
		    					<div class="form-group">
		    						<label class="control-label" for="password">
		    							Password
		    						</label>
	    							<input type="password" class="form-control" name="password" id="password">
		    					</div>
		    				</div>
		    				<div class="panel-footer">
		    					<div class="text-center">
		    						<button type="submit" class="btn btn-primary">Login</button>
		    						<a href="index.php" class="btn btn-default">Kembali</a>
		    					</div>
		    				</div>
		    			</div>
		    		</form>
		    	</div>
	    	</div>
		</div>
	</body>
	</html>
	<?php
}

?>