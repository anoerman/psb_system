<?php 
// Require class database
require_once(__DIR__ . '/lib/db.class.php');
$databaseClass = new DB();

// Fungsi untuk ambil data laporan
$query_ta    = "SELECT ta_id, tahun_ajaran FROM psb_tahun_ajaran LIMIT 5";
$data_ta     = $databaseClass->query($query_ta);
$view_ta     = "";
$view_jml_cs = "";
$n           = 0;
foreach ($data_ta as $dta) {
	$n++;
	// Penetapan variabel ta
	$laporan_ta_id        = $dta["ta_id"];
	$laporan_tahun_ajaran = $dta["tahun_ajaran"];

	// Set untuk label chart
	if ($n==1) {
		$view_ta .= "'$laporan_tahun_ajaran'";
	}
	else {
		$view_ta .= ", '$laporan_tahun_ajaran'";
	}

	// Ambil jumlah calon siswa per tahun ajaran
	$query_jml_cs = "SELECT COUNT(*) AS jml_calon_siswa FROM psb_data_siswa WHERE ta_id = '$laporan_ta_id'";
	$data_jml_cs  = $databaseClass->query($query_jml_cs);
	foreach ($data_jml_cs as $djcs) {
		$jml_data_cs = $djcs["jml_calon_siswa"];

		// Set untuk label chart
		if ($n==1) {
			$view_jml_cs .= $jml_data_cs;
		}
		else {
			$view_jml_cs .= ", ".$jml_data_cs;
		}
	}
}
?>
<!-- Chart JS -->
<script type="text/javascript" src="./assets/plugins/chartjs/Chart.min.js"></script>
<script type="text/javascript">
	var barChartData = {
		labels : [<?php echo $view_ta; ?>],
		datasets : [
			{
				fillColor : "rgba(151,187,205,0.5)",
				strokeColor : "rgba(151,187,205,0.8)",
				highlightFill : "rgba(151,187,205,0.75)",
				highlightStroke : "rgba(151,187,205,1)",
				data : [<?php echo $view_jml_cs; ?>]
			}
		]

	}
	window.onload = function(){
		var ctx = document.getElementById("canvas").getContext("2d");
		window.myBar = new Chart(ctx).Bar(barChartData, {
			responsive : true
		});
	}
</script>

<!-- Fungsi Export -->
<script type="text/javascript">
jQuery(document).ready(function($) {
	$("#select_tahun_ajaran").on('change', function(event) {
		event.preventDefault();
		if (this.value != "") {
			$("#dl_export").removeClass('disabled');
			$("#dl_export").attr('href', 'laporan_export_excel.php?tahun_ajaran_id='+this.value+'&tahun_ajaran_name='+$("#select_tahun_ajaran option:selected").text());
		}
		else {
			$("#dl_export").addClass('disabled');
			$("#dl_export").attr('href', '#');
		}
	});
});
</script>