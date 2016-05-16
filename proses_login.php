<?php session_start();
	// Require class database
	require_once(__DIR__ . '/lib/db.class.php');
	$databaseClass = new DB();

	// Get post data
	$username = addslashes($_POST["username"]);
	$password = $_POST["password"];

	// Get salt
	$query = "SELECT salt FROM psb_users WHERE username = '$username'";
	$fetch = $databaseClass->query($query,'',PDO::FETCH_ASSOC);
	foreach ($fetch as $dt_salt) {
		$salt = $dt_salt['salt'];
	}

	// Set password
	$password_salted = hash("SHA512", $password.$salt);
	
	// Check psb_users
	$query = "SELECT * FROM psb_users WHERE psb_users.`username`='$username' AND psb_users.`password`='$password_salted' AND psb_users.`aktif`='yes'";
	$fetch = $databaseClass->query($query);

	// If data exists
	if ($fetch!=0) {
		// Fetch user data
		foreach ($fetch as $dt_user) {
			$username      = $dt_user['username'];
			$nama_depan    = $dt_user['nama_depan'];
			$nama_belakang = $dt_user['nama_belakang'];
			$level         = $dt_user['level'];
		}

		if ($level!="") {
			$_SESSION["psb_username"]      = $username;
			$_SESSION["psb_nama_depan"]    = $nama_depan;
			$_SESSION["psb_nama_belakang"] = $nama_belakang;
			$_SESSION["psb_level"]         = $level;

			// Dashboard
			$_SESSION["informasi_formulir"] = "Selamat Datang, $nama_depan $nama_belakang";
			header("Location: ./dashboard.php");
			die();
		}
		else {
			// Set informasi
			$_SESSION["informasi_formulir"] = "Proses login gagal. Harap periksa kembali username dan password anda.";
			header("Location: ./login.php");
			die();
		}
	}
	// No data found
	else {
		$_SESSION["informasi_formulir"] = "Username anda tidak terdaftar!";
		header("Location: ./login.php");
		die();
	}

?>