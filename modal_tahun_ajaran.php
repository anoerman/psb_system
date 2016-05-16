<?php 
/**
*	Modal tahun ajaran.
*	Menampilkan formulir untuk melakukan pengaturan mengenai tahun ajaran.
*/
?>
<div class="modal fade" id="modal_tahun_ajaran">
	<div class="modal-dialog">
		<div class="modal-content">
			<form method="post" action="proses_simpan.php">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
					<h4 class="modal-title">Tahun Ajaran</h4>
				</div>
				<div class="modal-body">
					<div class="form-horizontal">
						<div class="form-group">
							<label class="control-label col-xs-4" for="tahun_ajaran">Tahun Ajaran</label>
							<div class="col-xs-8">
								<input type="text" class="form-control" name="tahun_ajaran" id="tahun_ajaran">
								<span class="help-block">Contoh : 2016-2017, Gelombang 1 2016-2017</span>
							</div>
						</div>
						<div class="form-group" id="status_aktif_ta">
							<label class="control-label col-xs-4" for="tahun_ajaran_aktif">Aktif</label>
							<div class="col-xs-8">
								<select class="form-control" name="tahun_ajaran_aktif" id="tahun_ajaran_aktif">
									<option value="yes">Iya</option>
									<option value="no">Tidak</option>
								</select>
							</div>
						</div>
						<div class="alert alert-info" id="info_ta_baru">
							<p>Setelah proses penyimpanan, tahun ajaran akan langsung aktif.</p>
							<p>Tahun ajaran sebelumnya yang masih memiliki status aktif akan secara otomatis di nonaktifkan.</p>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" name="ta_id" id="ta_id" value="">
					<input type="hidden" name="aksi" id="aksi_ta" value="">
					<button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
					<button type="submit" id="proses_data_siswa" class="btn btn-primary"><i class="glyphicon glyphicon-save"></i> Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>
<script type="text/javascript">
	// Tambah Tahun ajaran baru!!!
	function tambah_ta () {
		// kosongkan semua nilai
		$("#ta_id").val("");
		$("#tahun_ajaran").val("");
		$("#tahun_ajaran_aktif").val("yes");
		$("#aksi_ta").val("tambah_tahun_ajaran");
		$("#status_aktif_ta").hide();
		$("#info_ta_baru").show();
		// tampilkan modal
		$("#modal_tahun_ajaran").modal("show");
	}

	// Ubah tahun ajaran lama!!!
	function ubah_ta (ta_id) {
		// isikan semua nilai
		$("#ta_id").val(ta_id);
		$("#tahun_ajaran").val($("#tha_nama_"+ta_id).val());
		$("#tahun_ajaran_aktif").val($("#tha_status_"+ta_id).val());
		$("#aksi_ta").val("ubah_tahun_ajaran");
		$("#status_aktif_ta").show();
		$("#info_ta_baru").hide();
		// tampilkan modal
		$("#modal_tahun_ajaran").modal("show");
	}
</script>