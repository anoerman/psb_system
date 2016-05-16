<?php  session_start();
/**
*	User Settings
*	Bentuk tampilan berupa chart
*	Ekspor berupa bentuk excel - proses
*	
*/

// Jika user sudah sign in
if (isset($_SESSION['psb_username']) && isset($_SESSION['psb_level']) && $_SESSION['psb_username']!="" && $_SESSION['psb_level']!="") {
	// Require class database
	require_once(__DIR__ . '/lib/db.class.php');
	$databaseClass = new DB();

	// Ambil header
	include("./header.php");

	// Ambil detail user
	$query_detail_user = "SELECT * FROM psb_users WHERE username = '$_SESSION[psb_username]'";
	$data_detail_user  = $databaseClass->query($query_detail_user);
	foreach ($data_detail_user as $ddu) {
		$u_username      = $ddu["username"];
		$u_nama_depan    = $ddu["nama_depan"];
		$u_nama_belakang = $ddu["nama_belakang"];
		$u_email         = $ddu["email"];
	}
	?>
	<div class="container document">
    	<div class="row">
			<div class="panel panel-default">
				<div class="panel-body">
			    	<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
			    		<legend>Detail User</legend>
			    		<?php 
			    		// Tampilkan informasi jika ada!
			    		if (isset($_SESSION["informasi_formulir"])) {
			    			echo "<div class='alert alert-info'>".$_SESSION["informasi_formulir"]."</div>";
			    			unset($_SESSION["informasi_formulir"]);
			    		}
			    		?>
			    		<form class="form-horizontal validetta" method="post" action="proses_simpan.php">
			    			<input type="hidden" name="aksi" id="aksi" value="ubah_data_user">
			    			<div class="form-group">
			    				<label class="col-md-3 control-label">Username</label>
			    				<div class="col-md-9">
			    					<p class="form-control-static"><?php echo $u_username; ?></p>
			    					<input type="hidden" name="username" value="<?php echo $u_username; ?>">
			    				</div>
			    			</div>
			    			<div class="form-group">
			    				<label class="col-md-3 control-label">Nama Depan</label>
			    				<div class="col-md-9">
			    					<input type="text" name="nama_depan" id="nama_depan" class="form-control u_data" disabled="" value="<?php echo $u_nama_depan; ?>" data-validetta="required">
			    				</div>
			    			</div>
			    			<div class="form-group">
			    				<label class="col-md-3 control-label">Nama Belakang</label>
			    				<div class="col-md-9">
			    					<input type="text" name="nama_belakang" id="nama_belakang" class="form-control u_data" disabled="" value="<?php echo $u_nama_belakang; ?>">
			    				</div>
			    			</div>
			    			<div class="form-group">
			    				<label class="col-md-3 control-label">Email</label>
			    				<div class="col-md-9">
			    					<input type="text" name="email" id="email" class="form-control u_data" disabled="" value="<?php echo $u_email; ?>" data-validetta="required, email">
			    				</div>
			    			</div>
			    			<div id="u_password" style="display:none;">
			    				<hr>
				    			<div class="form-group">
				    				<label class="col-md-3 control-label">Password Baru</label>
				    				<div class="col-md-9">
				    					<input type="password" name="pass_baru" id="pass_baru" class="form-control">
				    				</div>
				    			</div>
				    			<div class="form-group">
				    				<label class="col-md-3 control-label">Ulangi Password</label>
				    				<div class="col-md-9">
				    					<input type="password" name="pass_baru_2" id="pass_baru_2" class="form-control" data-validetta="equalTo[pass_baru]">
				    					<span class="help-block">Isi kolom password hanya jika anda ingin mengubah password anda.</span>
				    				</div>
				    			</div>
				    			<div class="form-group">
				    				<div class="col-md-12 text-center">
				    					<button type="submit" class="btn btn-primary">Simpan</button>
				    					<a href="pengguna.php" class="btn btn-danger">Batal</a>
				    				</div>
				    			</div>
			    			</div>
			    		</form>
			    	</div>
			    	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
		    			<div class="text-center">
			    			<button type="button" class="btn btn-primary" id="ubah_data_pengguna"><i class="glyphicon glyphicon-pencil"></i> Ubah Data</button>
		    			</div>
		    				
		    			<br>
			    		<div class="alert alert-info">
			    			<p>Berikut adalah profil anda saat ini.<br>Klik ubah data untuk melakukan perubahan data.</p>
			    		</div>
			    	</div>
			    </div>
			</div>
		</div>
	</div>

	<?php
	// Ambil footer
	include("./footer.php");
	include("./pengguna_ubah.php");
}
else {
	// Redirect dashboard
	header("Location: ./index.php");
	die();
}
