<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	<title>Data Calon Peserta Didik Baru</title>
	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 14px 15px;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
</head>
<body>
<div id="container">
	<h1>Telah masuk data calon peserta didik baru pada sistem PPDB anda.</h1>
	<div id="body">
		<h4>Berikut adalah data calon siswa yang baru dimasukkan dalam sistem :</h4>
		<p>Nama Calon Siswa : <?php echo $nama_calon_siswa; ?></p>
		<p>Asal Sekolah : <?php echo $asal_sekolah; ?></p>
		<p>Tempat, Tgl Lahir : <?php echo $tempat_lahir_calon_siswa." ".$tanggal_lahir_calon_siswa; ?></p>
		<p>Nama Orang Tua : <?php echo $nama_orang_tua_wali; ?></p>
		<p>Pekerjaan : <?php echo $pekerjaan_orang_tua_wali; ?></p>
		<p>Alamat Rumah : <?php echo $alamat_orang_tua_wali; ?></p>
		<p>No Telepon : <?php echo $telepon_orang_tua_wali; ?></p>
		<p>Email Orang Tua : <?php echo $email_orang_tua_wali; ?></p>
		<br>
		<p><strong>Sistem PPDB PGRI 2 Cibinong</strong></p>
	</div>
</div>
</body>
</html>
