<script type="text/javascript">
	jQuery(document).ready(function($) {
		$("#ubah_data_pengguna").on('click', function(event) {
			event.preventDefault();
			$(".u_data").removeAttr('disabled');
			$("#u_password").show("fast");
			$(this).hide('fast');
		});
	});
</script>