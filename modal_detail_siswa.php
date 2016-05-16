<?php 
/**
*	Modal detail siswa.
*	Menampilkan data detail dalam bentuk modal.
*	Metode : mengambil data berdasarkan data yang ditampilkan dari datatable berdasarkan id calon siswa.
*/
?>
<div class="modal fade" id="modal_detail">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
				<h3 class="modal-title text-center">Data calon siswa</h3>
			</div>
			<div class="modal-body">
				<div class="form-horizontal">
					<div class="form-group">
						<label class="control-label col-xs-4" for="cs_nama">Nama calon siswa</label>
						<div class="col-xs-8"><p class="form-control-static" id="cs_nama"></p></div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-4" for="cs_ttl">Tempat, Tgl lahir</label>
						<div class="col-xs-8"><p class="form-control-static" id="cs_ttl"></p></div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-4" for="cs_ask">Asal sekolah</label>
						<div class="col-xs-8"><p class="form-control-static" id="cs_ask"></p></div>
					</div>
					<hr>
					<legend class="text-center">Data orang tua / wali</legend>
					<div class="form-group">
						<label class="control-label col-xs-4" for="ot_nama">Nama orang tua</label>
						<div class="col-xs-8"><p class="form-control-static" id="ot_nama"></p></div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-4" for="ot_pkj">Pekerjaan</label>
						<div class="col-xs-8"><p class="form-control-static" id="ot_pkj"></p></div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-4" for="ot_alt">Alamat</label>
						<div class="col-xs-8"><p class="form-control-static" id="ot_alt"></p></div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-4" for="ot_tlp">Telepon</label>
						<div class="col-xs-8"><p class="form-control-static" id="ot_tlp"></p></div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-4" for="ot_eml">Email</label>
						<div class="col-xs-8"><p class="form-control-static" id="ot_eml"></p></div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<form action="proses_simpan.php" method="post">
					<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
					<button type="button" id="terima_cs" class="btn btn-success" onclick="proses_cek('terima')"><i class="glyphicon glyphicon-ok"></i> Terima</button>
					<button type="button" id="tolak_cs" class="btn btn-danger" onclick="proses_cek('tolak')"><i class="glyphicon glyphicon-remove"></i> Tolak</button>
					<input type="hidden" name="aksi" id="aksi" value="penetapan_calon_siswa">
					<input type="hidden" name="id_data_cs" id="id_data_cs" value="">
					<input type="hidden" name="status_penerimaan" id="status_penerimaan" value="">
					
					<button type="submit" id="proses_data_siswa" class="btn btn-danger hide">Proses simpan laaah.. :P</button>
				</form>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	// Fungsi ambil data detail siswa berdasarkan idnya
	function lihat_detail (id_siswa) {
		// Set isinya
		$("#cs_nama").html($("#nama_cs_"+id_siswa).html());
		$("#cs_ttl").html($("#ttl_cs_"+id_siswa).html());
		$("#cs_ask").html($("#asekolah_cs_"+id_siswa).html());
		$("#ot_nama").html($("#nama_ot_"+id_siswa).html());
		$("#ot_tlp").html($("#tlp_ot_"+id_siswa).val());
		$("#ot_alt").html($("#alt_ot_"+id_siswa).val());
		$("#ot_pkj").html($("#pkj_ot_"+id_siswa).val());
		$("#ot_eml").html($("#eml_ot_"+id_siswa).val());
		$("#id_data_cs").val(id_siswa);
		// Tampilkan modal
		$("#modal_detail").modal("show");
	}

	// Fungsi untuk melakukan proses simpan data siswa
	function proses_cek (status) {
		if (status!="") {
			if ( confirm("Nama Calon Siswa : "+$("#cs_nama").html()+"\nNama Admin PSB : <?php echo $_SESSION['psb_nama_depan'].' '.$_SESSION['psb_nama_belakang'] ?>\nTanggal Cek : <?php echo date('d M Y'); ?>\nYakin ubah status penerimaan calon siswa ini menjadi di"+status+"?\n") ) {
				// Set status penerimaan dan kirimkan ke halaman tujuan untuk proses selanjutnya
				$("#status_penerimaan").val(status);
				if ($("#status_penerimaan").val()!="") {
					$("#proses_data_siswa").click();
					// alert($("#status_penerimaan").val());
				};
			};
		};
	}
</script>

<?php 
/**
*	Modal edit data siswa
*	Menampilkan data siswa untuk dapat diedit dan simpan kembali
*
*/
?>
<div class="modal fade" id="modal_ubah_cs">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form class="form" method="post" action="proses_simpan.php">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					<h3 class="modal-title text-center">Ubah data calon siswa</h3>
				</div>
				<div class="modal-body">
					<div class="form-horizontal">
						<div class="form-group">
							<label class="col-md-3 control-label" for="nama_orang_tua_wali_ubah">
								Nama Orang Tua / Wali
							</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="nama_orang_tua_wali_ubah" id="nama_orang_tua_wali_ubah" data-validetta="required">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label" for="pekerjaan_orang_tua_wali_ubah">
								Pekerjaan Orang Tua / Wali
							</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="pekerjaan_orang_tua_wali_ubah" id="pekerjaan_orang_tua_wali_ubah">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label" for="alamat_orang_tua_wali_ubah">
								Alamat Orang Tua / Wali
							</label>
							<div class="col-md-9">
								<textarea class="form-control" name="alamat_orang_tua_wali_ubah" id="alamat_orang_tua_wali_ubah" style="resize:vertical; max-height:150px;"></textarea>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label" for="email_orang_tua_wali_ubah">
								Email
							</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="email_orang_tua_wali_ubah" id="email_orang_tua_wali_ubah" data-validetta="email">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label" for="telepon_orang_tua_wali_ubah">
								No Telepon / HP
							</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="telepon_orang_tua_wali_ubah" id="telepon_orang_tua_wali_ubah" data-validetta="number,required">
							</div>
						</div>
						<hr>
						<div class="form-group">
							<label class="col-md-3 control-label" for="nama_calon_siswa_ubah">
								Nama Calon Siswa
							</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="nama_calon_siswa_ubah" id="nama_calon_siswa_ubah" data-validetta="required">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label" for="asal_sekolah_ubah">
								Asal Sekolah SMP / Mts
							</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="asal_sekolah_ubah" id="asal_sekolah_ubah" data-validetta="required">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label" for="tempat_lahir_calon_siswa_ubah">
								Tempat Lahir
							</label>
							<div class="col-md-9">
								<input type="text" class="form-control" name="tempat_lahir_calon_siswa_ubah" id="tempat_lahir_calon_siswa_ubah">
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label" for="tanggal_lahir_calon_siswa_ubah">
								Tanggal Lahir
							</label>
							<div class="col-md-5">
								<div class="input-group">
									<input type="text" class="form-control datepicker" name="tanggal_lahir_calon_siswa_ubah" id="tanggal_lahir_calon_siswa_ubah">
									<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="aksi" id="aksi" value="ubah_calon_siswa">
					<input type="hidden" name="id_data_ubah" id="id_data_ubah" value="">				
					<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
					<button type="submit" class="btn btn-primary" onclick="return confirm('Proses simpan perubahan data calon siswa?')">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	// Fungsi ambil data detail siswa berdasarkan idnya
	function ubah_data_cs (id_siswa) {
		// Set isinya
		$("#nama_calon_siswa_ubah").val($("#nama_cs_"+id_siswa).html());
		$("#tempat_lahir_calon_siswa_ubah").val($("#tmp_lhr_"+id_siswa).val());
		$("#tanggal_lahir_calon_siswa_ubah").val($("#tgl_lhr_"+id_siswa).val());
		$("#asal_sekolah_ubah").val($("#asekolah_cs_"+id_siswa).html());
		$("#nama_orang_tua_wali_ubah").val($("#nama_ot_"+id_siswa).html());
		$("#telepon_orang_tua_wali_ubah").val($("#tlp_ot_"+id_siswa).val());
		$("#alamat_orang_tua_wali_ubah").val($("#alt_ot_"+id_siswa).val());
		$("#pekerjaan_orang_tua_wali_ubah").val($("#pkj_ot_"+id_siswa).val());
		$("#email_orang_tua_wali_ubah").val($("#eml_ot_"+id_siswa).val());
		$("#id_data_ubah").val(id_siswa);
		// Tampilkan modal
		$("#modal_ubah_cs").modal("show");
	}

	// Re init datepicker
	$('.datepicker').datepicker({
	    format: "yyyy/mm/dd",
	    weekStart: 1,
	    todayBtn: "linked",
	    daysOfWeekHighlighted: "0,6",
	    orientation: "bottom right",
	    autoclose: true,
	    todayHighlight: true,
	    toggleActive: true,
	    language: "id"
	});
</script>