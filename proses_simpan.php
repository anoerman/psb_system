<?php session_start();
	// Require class database
	require_once(__DIR__ . '/lib/db.class.php');
	$databaseClass = new DB();

	// Ambil aksi yang dijalankan
	$aksi = $_POST["aksi"];

	/**
	*	Proses simpan dan kirim email
	*	Data calon siswa diisikan oleh pihak luar (orang tua calon siswa)
	*	Disimpan ke database sesuai dengan tahun ajaran yang berlaku saat ini.
	*	Kemudian informasi dikirimkan kepada admin yang melakukan pengawasan
	*	terhadap sistem PSB ini.
	*	
	*/
	if ($aksi == "simpan_calon_siswa") {
		// Jika captcha sesuai
		if ($_SESSION["Captcha"] == $_POST["captcha"]){
			// Tentukan variabel dari data posting formulir
			$nama_orang_tua_wali       = addslashes($_POST["nama_orang_tua_wali"]);
			$pekerjaan_orang_tua_wali  = addslashes($_POST["pekerjaan_orang_tua_wali"]);
			$alamat_orang_tua_wali     = addslashes($_POST["alamat_orang_tua_wali"]);
			$email_orang_tua_wali      = addslashes($_POST["email_orang_tua_wali"]);
			$telepon_orang_tua_wali    = addslashes($_POST["telepon_orang_tua_wali"]);
			$nama_calon_siswa          = addslashes($_POST["nama_calon_siswa"]);
			$asal_sekolah              = addslashes($_POST["asal_sekolah"]);
			$tempat_lahir_calon_siswa  = addslashes($_POST["tempat_lahir_calon_siswa"]);
			$tanggal_lahir_calon_siswa = $_POST["tanggal_lahir_calon_siswa"];
			$ta_id                     = $_POST["ta_id"];
			$client_ip                 = get_ip();

			// Jika data tidak ada dalam database = simpan data
			$q_cek_data  = "SELECT data_id FROM psb_data_siswa WHERE nama_orang_tua_wali = '$nama_orang_tua_wali' AND nama_calon_siswa = '$nama_calon_siswa' AND tempat_lahir_calon_siswa = '$tempat_lahir_calon_siswa' AND tanggal_lahir_calon_siswa = '$tanggal_lahir_calon_siswa'";
			$data_cek    = $databaseClass->query($q_cek_data);
			$data_id_cek = "";
			foreach ($data_cek as $dc) {
				$data_id_cek .= $dc["data_id"];
			}
			if ($data_id_cek!="") {
				$_SESSION["informasi_formulir"] = "Data pendaftaran yang anda masukkan sudah terdaftar!";
				header("Location: ./index.php");
				die();
			}
			else {
				// Proses simpan data ke database
				$q_input_data = "INSERT INTO psb_data_siswa VALUES ('', '$nama_orang_tua_wali', '$pekerjaan_orang_tua_wali', '$alamat_orang_tua_wali', '$email_orang_tua_wali', '$telepon_orang_tua_wali', '$nama_calon_siswa', '$asal_sekolah', '$tempat_lahir_calon_siswa', '$tanggal_lahir_calon_siswa', '$ta_id', 'pending', '', 'tidak_diketahui', '$client_ip', NOW(), '$client_ip', NOW())";
				$proses_simpan = $databaseClass->query($q_input_data);
				$data_id_baru  = $databaseClass->lastInsertId();

				// Jika proses simpan berhasil - kembalikan ke halaman awal
				if ($proses_simpan>=1) {
					// Set informasi
					$_SESSION["informasi_formulir"] = "Pendaftaran berhasil disimpan! Harap tunggu konfirmasi dari pihak sekolah. Terima kasih.";

					// Kirim email =======================>

					//SMTP needs accurate times, and the PHP time zone MUST be set
					//This should be done in your php.ini, but this is how to do it if you don't have access to that
					date_default_timezone_set('Asia/Jakarta');

					require_once(__DIR__ . '/lib/phpmailer/PHPMailerAutoload.php');

					//Create a new PHPMailer instance
					$mail = new PHPMailer;

					//Tell PHPMailer to use SMTP
					$mail->isSMTP();
					$mail->SMTPDebug = 0;

					//Ask for HTML-friendly debug output
					$mail->Debugoutput = 'html';

					//Set the hostname of the mail server
					$mail->Host = 'smtp.gmail.com';
					// use
					// $mail->Host = gethostbyname('smtp.gmail.com');
					// if your network does not support SMTP over IPv6

					//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
					$mail->Port = 587;

					//Set the encryption system to use - ssl (deprecated) or tls
					$mail->SMTPSecure = 'tls';

					//Whether to use SMTP authentication
					$mail->SMTPAuth = true;

					//Username to use for SMTP authentication - use full email address for gmail
					$mail->Username = "ppdb.smkpgri2cibinong@gmail.com";

					//Password to use for SMTP authentication
					$mail->Password = "nMQgapHzh4";

					//Set who the message is to be sent from
					$mail->setFrom('ppdb@smkpgri2cibinong.sch.id', 'PPDB SMK PGRI 2 Cibinong');

					//Set an alternative reply-to address
					$mail->addReplyTo('ppdb.smkpgri2cibinong@gmail.com', 'PPDB SMK PGRI 2 Cibinong');

					//Set who the message is to be sent to
					// Ambil berdasarkan fungsi - jika ingin disesuaikan user mana saja yang akan menerima email berdasarkan level,
					// tinggal tambahkan parameter level dalam fungsi get_email_admin();
					$q_users_email = "SELECT nama_depan, nama_belakang, email FROM psb_users WHERE email!='' AND aktif = 'yes'";
					$arr_penerima  = $databaseClass->query($q_users_email);
					$penerimanya   = "";
					foreach ($arr_penerima as $data_penerima) {
						$penerima_nama_depan    = $data_penerima["nama_depan"];
						$penerima_nama_belakang = $data_penerima["nama_belakang"];
						$penerima_email         = $data_penerima["email"];

						// Set penerimanya
						$mail->addAddress($penerima_email, $penerima_nama_depan." ".$penerima_nama_belakang);
						$penerimanya .= " ".$penerima_email;
					}

					//Set the subject line
					$mail->Subject = 'Informasi Pendaftaran Calon Siswa Baru';

					//Read an HTML message body from an external file, convert referenced images to embedded,
					//convert HTML into a basic plain-text alternative body
					// $mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));

					// Ambil data isian calon siswa baru
					$data_kiriman["nama_calon_siswa"]          = $nama_calon_siswa;
					$data_kiriman["asal_sekolah"]              = $asal_sekolah;
					$data_kiriman["tempat_lahir_calon_siswa"]  = $tempat_lahir_calon_siswa;
					$data_kiriman["tanggal_lahir_calon_siswa"] = $tanggal_lahir_calon_siswa;
					$data_kiriman["nama_orang_tua_wali"]       = $nama_orang_tua_wali;
					$data_kiriman["pekerjaan_orang_tua_wali"]  = $pekerjaan_orang_tua_wali;
					$data_kiriman["alamat_orang_tua_wali"]     = $alamat_orang_tua_wali;
					$data_kiriman["email_orang_tua_wali"]      = $email_orang_tua_wali;
					$data_kiriman["telepon_orang_tua_wali"]    = $telepon_orang_tua_wali;

					$mail->isHTML(true);
					// $mail->Body = "<strong>Test aja</strong>";
					$mail->Body = get_include_contents('email_content.php', $data_kiriman);

					//Replace the plain text body with one created manually
					$mail->AltBody = 'Data calon peserta didik baru telah masuk ke database. Silahkan cek aplikasi ppdb.';

					//send the message, check for errors
					if (!$mail->send()) {
					    // echo "Mailer Error: " . $mail->ErrorInfo;
					    $info_email     = $mail->ErrorInfo;
						$q_status_email = "UPDATE psb_data_siswa SET status_email = 'gagal_kirim' WHERE data_id = '$data_id_baru'";
					} else {
					    // echo "Message sent!";
						$info_email     = "Email sukses terkirim!";
						$q_status_email = "UPDATE psb_data_siswa SET status_email = 'terkirim' WHERE data_id = '$data_id_baru'";
					}
					$proses_status_email = $databaseClass->query($q_status_email);
					// Set info email
					$q_info_email        = "INSERT INTO psb_email_info VALUES ('', '$data_id_baru', 'Informasi : $info_email | Penerima : $penerimanya')";
					$proses_info_email   = $databaseClass->query($q_info_email);

					// Akhir kirim email =====================>
				}
				else {
					// Set informasi
					$_SESSION["informasi_formulir"] = "Proses penyimpanan data gagal! Silahkan coba lagi.";
				}
				header("Location: ./index.php");
				die();
			}
		}
		else {
			$_SESSION["informasi_formulir"] = "Captcha yang anda masukkan tidak valid!";
			header("Location: ./index.php");
			die();
		}
	}


	/**
	*	Proses ubah data calon siswa
	*	
	*/
	elseif ($aksi == "ubah_calon_siswa") {
		// Tentukan variabel dari data posting formulir
		$data_id                   = $_POST["id_data_ubah"];
		$nama_orang_tua_wali       = addslashes($_POST["nama_orang_tua_wali_ubah"]);
		$pekerjaan_orang_tua_wali  = addslashes($_POST["pekerjaan_orang_tua_wali_ubah"]);
		$alamat_orang_tua_wali     = addslashes($_POST["alamat_orang_tua_wali_ubah"]);
		$email_orang_tua_wali      = addslashes($_POST["email_orang_tua_wali_ubah"]);
		$telepon_orang_tua_wali    = addslashes($_POST["telepon_orang_tua_wali_ubah"]);
		$nama_calon_siswa          = addslashes($_POST["nama_calon_siswa_ubah"]);
		$asal_sekolah              = addslashes($_POST["asal_sekolah_ubah"]);
		$tempat_lahir_calon_siswa  = addslashes($_POST["tempat_lahir_calon_siswa_ubah"]);
		$tanggal_lahir_calon_siswa = $_POST["tanggal_lahir_calon_siswa_ubah"];
		$client_ip                 = $_SESSION["psb_username"];

		// Jika ada id = proses
		if ($data_id!="") {
			// Proses ubah data di database
			$q_update_data = "UPDATE psb_data_siswa SET nama_orang_tua_wali = '$nama_orang_tua_wali', pekerjaan_orang_tua_wali = '$pekerjaan_orang_tua_wali', alamat_orang_tua_wali = '$alamat_orang_tua_wali', email_orang_tua_wali = '$email_orang_tua_wali', telepon_orang_tua_wali = '$telepon_orang_tua_wali', nama_calon_siswa = '$nama_calon_siswa', asal_sekolah = '$asal_sekolah', tempat_lahir_calon_siswa = '$tempat_lahir_calon_siswa', tanggal_lahir_calon_siswa = '$tanggal_lahir_calon_siswa', updated_by = '$client_ip', updated_date = NOW() WHERE data_id = '$data_id'";
			$proses_simpan = $databaseClass->query($q_update_data);

			// Jika proses simpan berhasil - kembalikan ke halaman awal
			if ($proses_simpan>=1) {
				// Set informasi
				$_SESSION["informasi_formulir"] = "Perubahan data calon siswa berhasil disimpan!";
			}
			else {
				// Set informasi
				$_SESSION["informasi_formulir"] = "Proses perubahan data gagal! Silahkan coba lagi.";
			}
		}
		else {
			// Set informasi
			$_SESSION["informasi_formulir"] = "Data siswa tidak ada dalam database!";
		}

		header("Location: ./dashboard.php");
		die();
	}


	/**
	*	Proses penetapan status penerimaan calon siswa
	*	Data hasil penerimaan yang dilakukan oleh admin sistem.
	*	
	*/
	elseif ($aksi == "penetapan_calon_siswa") {
		// Set variabel & query
		$id_data_cs          = $_POST["id_data_cs"];
		$status_penerimaan   = $_POST["status_penerimaan"];
		$checker             = $_SESSION["psb_username"];
		$q_status_penerimaan = "UPDATE psb_data_siswa SET status_penerimaan = '$status_penerimaan', checker = '$checker', updated_by = '$checker', updated_date = NOW() WHERE data_id = '$id_data_cs'";
		$proses_simpan       = $databaseClass->query($q_status_penerimaan);
		// Jika proses simpan berhasil - kembalikan ke halaman awal
		if ($proses_simpan>=1) {
			// Set informasi
			$_SESSION["informasi_formulir"] = "Data calon siswa berhasil disimpan!";
		}
		else {
			// Set informasi
			$_SESSION["informasi_formulir"] = "Penyimpanan data calon siswa gagal! Silahkan coba lagi.";
		}
		header("Location: ./dashboard.php");
		die();
	}


	/**
	*	Proses tambah tahun ajaran baru
	*
	*/
	elseif ($aksi == "tambah_tahun_ajaran") {
		// Var
		$tahun_ajaran = addslashes($_POST["tahun_ajaran"]);
		$aktif        = $_POST["tahun_ajaran_aktif"];
		$creator      = $_SESSION["psb_username"];
		
		// Nonaktif ta lama
		$q_nonaktif_ta_lama = "UPDATE psb_tahun_ajaran SET aktif = 'no', updated_by = '$creator', updated_date = NOW()";
		$proses_1           = $databaseClass->query($q_nonaktif_ta_lama);

		// Cek duplikat ta
		$q_tahun_ajaran_lama = "SELECT ta_id FROM psb_tahun_ajaran WHERE tahun_ajaran = '$tahun_ajaran'";
		$proses_2            = $databaseClass->query($q_tahun_ajaran_lama);
		$ta_id_lama          = "";
		foreach ($proses_2 as $p2) {
			$ta_id_lama = $p2["ta_id"];
		}

		// Jika id tahun ajaran tidak ada, proses simpan ke database
		if ($ta_id_lama=="") {
			// Masukkan data ta baru
			$q_tahun_ajaran_baru = "INSERT INTO psb_tahun_ajaran VALUES ('', '$tahun_ajaran', '$aktif', '$creator', NOW(), '$creator', NOW())";
			$proses_3            = $databaseClass->query($q_tahun_ajaran_baru);

			// Jika proses simpan berhasil - kembalikan ke halaman awal
			if ($proses_3>=1) {
				// Set informasi
				$_SESSION["informasi_formulir"] = "Data tahun ajaran baru berhasil disimpan!";
			}
			else {
				// Set informasi
				$_SESSION["informasi_formulir"] = "Penyimpanan data tahun ajaran baru gagal! Silahkan coba lagi.";
			}
		}
		// Jika id tahun ajaran lama ada, berikan informasi tahun ajaran sudah ada
		else {
			// Set informasi
			$_SESSION["informasi_formulir"] = "Tahun ajaran baru yang anda masukkan sudah ada!";
		}

		header("Location: ./dashboard.php");
		die();
	}


	/**
	*	Proses ubah tahun ajaran baru
	*
	*/
	elseif ($aksi == "ubah_tahun_ajaran") {
		// Var
		$ta_id        = $_POST["ta_id"];
		$tahun_ajaran = addslashes($_POST["tahun_ajaran"]);
		$aktif        = $_POST["tahun_ajaran_aktif"];

		// Masukkan data ta baru
		$q_ubah_tahun_ajaran = "UPDATE psb_tahun_ajaran SET tahun_ajaran = '$tahun_ajaran', aktif = '$aktif' WHERE ta_id = '$ta_id'";
		$proses_simpan       = $databaseClass->query($q_ubah_tahun_ajaran);

		// Jika statusnya dijadikan aktif, nonaktifkan data tahun ajaran lain
		if ($aktif == "yes") {
			// Nonaktif ta lama
			$q_nonaktif_ta_lama = "UPDATE psb_tahun_ajaran SET aktif = 'no', updated_by = '$creator', updated_date = NOW() WHERE ta_id != '$ta_id'";
			$proses_nonaktif    = $databaseClass->query($q_nonaktif_ta_lama);
		}

		// Jika proses simpan berhasil - kembalikan ke halaman awal
		if ($proses_simpan>=1) {
			// Set informasi
			$_SESSION["informasi_formulir"] = "Data tahun ajaran berhasil diubah!";
		}
		else {
			// Set informasi
			$_SESSION["informasi_formulir"] = "Pengubahan data tahun baru gagal! Silahkan coba lagi.";
		}
		header("Location: ./dashboard.php");
		die();
	}


	/**
	*	Proses ubah data pengguna
	*	
	*/
	elseif ($aksi == "ubah_data_user") {
		// Var
		$username      = $_POST["username"];
		$nama_depan    = $_POST["nama_depan"];
		$nama_belakang = $_POST["nama_belakang"];
		$email         = $_POST["email"];
		$password      = $_POST["pass_baru"];
		$password_2    = $_POST["pass_baru_2"];

		// Set query
		$q_ubah_user = "UPDATE psb_users SET nama_depan = '$nama_depan', nama_belakang = '$nama_belakang', email = '$email', updated_by = '$username', updated_date = NOW(), revisi = revisi+1 WHERE username = '$username'";
		if ($password!="" && $password_2!="" && $password == $password_2) {
			// Set salt dan password saltnya
			$salt        = hash("SHA256", rand());
			$salted_pass = hash("SHA512", $password.$salt);
			$q_ubah_user = "UPDATE psb_users SET nama_depan = '$nama_depan', nama_belakang = '$nama_belakang', email = '$email', salt = '$salt', password = '$salted_pass', updated_by = '$username', updated_date = NOW(), revisi = revisi+1 WHERE username = '$username'";
		}

		// Proses
		$proses_simpan = $databaseClass->query($q_ubah_user);

		// Jika proses simpan berhasil - kembalikan ke halaman awal
		if ($proses_simpan>=1) {
			// Set informasi
			$_SESSION["informasi_formulir"] = "Data pengguna berhasil diubah!";
		}
		else {
			// Set informasi
			$_SESSION["informasi_formulir"] = "Pengubahan data pengguna gagal! Silahkan coba lagi.";
		}
		header("Location: ./pengguna.php");
		die();
	}



	// KOLOM FUNGSI

	/**
	*	Fungsi ambil ip client
	*	
	*	@return 	string 	$ipaddress
	*	
	*/
	function get_ip() {
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
		    $ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
		    $ip = $_SERVER['REMOTE_ADDR'];
		}
		return $ip;
	}


	/**
	*	Fungsi ambil isi dari file php, kombinasikan dengan variabel, bersihkan dan kembalikan hasil printnya
	*	
	*	@param 		string 	$filename
	*	@param 		array 	$variablesToMakeLocal
	*	@return 	string
	*	
	*/
	function get_include_contents($filename, $variablesToMakeLocal) {
		extract($variablesToMakeLocal);
		if (is_file($filename)) {
			ob_start();
			include $filename;
			return ob_get_clean();
		}
		return false;
	}

?>