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
		<div class="header">
			<!--nav-->
			<nav class="navbar navbar-default navbar-custom navbar-fixed-top" role="navigation">
				<div class="container">
					<div class="navbar-header">
						<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						</button>
						<a class="navbar-brand" href="#">
							<img src="./assets/images/sclogo.png" height="40">
						</a>
					</div>
					<div class="collapse navbar-collapse">
						<ul class="nav navbar-nav navbar-right">
							<li><a class="nav-link" href="index.php">Beranda</a></li>
							<?php if (isset($_SESSION['psb_username']) && isset($_SESSION['psb_level']) && $_SESSION['psb_username']!="" && $_SESSION['psb_level']!=""): ?>
								<li><a class="nav-link" href="dashboard.php">Dashboard</a></li>
								<li><a class="nav-link" href="laporan.php">Laporan</a></li>
								<li class="dropdown">
									<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $_SESSION["psb_nama_depan"]." ".$_SESSION["psb_nama_belakang"]; ?> <span class="caret"></span></a>
									<ul class="dropdown-menu">
										<li><a href="pengguna.php">Pengaturan User</a></li>
										<li><a href="logout.php" onclick="return confirm('Yakin Keluar Sistem?')">Logout</a></li>
									</ul>
								</li>
							<?php endif ?>
						</ul>
					</div>
				</div>
			</nav>
		</div>

		<div style="padding-top: 60px;"></div>

		<div class="container document">
	    	<div class="row">
		    	<div class="col-md-12">
	    			<h3 class="text-center">
	    				Sistem PSB SMK PGRI 2 Cibinong
	    			</h3>
		    	</div>
	    	</div>
    	</div>
