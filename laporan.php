<?php  session_start();
/**
*	Laporan
*	Bentuk tampilan berupa chart
*	Ekspor berupa bentuk excel
*	
*/

// Jika user sudah sign in
if (isset($_SESSION['psb_username']) && isset($_SESSION['psb_level']) && $_SESSION['psb_username']!="" && $_SESSION['psb_level']!="") {
	// Require class database
	require_once(__DIR__ . '/lib/db.class.php');
	$databaseClass = new DB();

	// Ambil header
	include("./header.php");
	?>
	<div class="container document">
    	<div class="row">
			<div class="panel panel-default">
				<div class="panel-body">
			    	<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">
						<legend>Grafik</legend>
						<div class="well well-sm">
							<canvas id="canvas" class="img-thumbnail"></canvas>
						</div>
						<div class="alert alert-danger">
							<p>Grafik jumlah penerimaan calon siswa selama 5 tahun terakhir.</p>
						</div>
					</div>
			    	<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
				    	<legend>Ekspor Data</legend>
				    	<div class="input-group">
				    		<!-- <div class="input-group-addon">Tahun Ajaran</div> -->
				    		<select class="form-control" id="select_tahun_ajaran" name="select_tahun_ajaran">
				    			<option value="">Pilih Tahun Ajaran</option>
				    			<?php 
								// Ambil semua tahun ajaran
								$query_ta_select = "SELECT ta_id, tahun_ajaran FROM psb_tahun_ajaran ORDER BY aktif ASC";
								$data_select     = $databaseClass->query($query_ta_select);
								$view_ta_select  = "";
								foreach ($data_select as $dselect) {
									$ta_id_select   = $dselect["ta_id"];
									$ta_name_select = stripslashes($dselect["tahun_ajaran"]);
									if (isset($_POST["pilih_tahun_ajaran"]) && $_POST["pilih_tahun_ajaran"] == $ta_id_select) {
										$view_ta_select.= "<option value='$ta_id_select' selected>$ta_name_select</option>";
									}
									else {
										$view_ta_select.= "<option value='$ta_id_select'>$ta_name_select</option>";
									}
								}
								echo $view_ta_select;
								?>
				    		</select>
				    		<div class="input-group-btn">
						    	<a href="#" class="btn btn-primary form-control disabled" id="dl_export">Download</a>
				    		</div>
				    	</div>
			    	</div>
				</div>
			</div>
		</div>
	</div>
	<?php
	// Ambil footer
	include("./footer.php");
	include("./laporan_chart.php");
}
else {
	// Redirect dashboard
	header("Location: ./index.php");
	die();
}
