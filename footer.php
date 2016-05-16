
							
</body>
</html>
<!-- Aditional Script -->
<script type="text/javascript" src="./assets/js/jquery-1.11.3.min.js"></script>
<!-- Bootstrap -->
<script type="text/javascript" src="./assets/js/bootstrap.min.js"></script>
<!-- Pace -->
<script type="text/javascript" src="./assets/plugins/pace/pace.js"></script>
<!-- Datepicker -->
<script type="text/javascript" src="./assets/plugins/datepicker/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" type="text/css" href="./assets/plugins/datepicker/css/bootstrap-datepicker.min.css">
<script type="text/javascript">
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
<!-- Validetta -->
<link rel="stylesheet" type="text/css" href="./assets/plugins/validetta/validetta.min.css">
<script type="text/javascript" src="./assets/plugins/validetta/validetta.min.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('.validetta').validetta({
			showErrorMessages : true,
			display : 'inline', // bubble or inline
			errorTemplateClass : 'validetta-inline',
		});
	} );
</script>
<!-- Datatables -->
<link rel="stylesheet" type="text/css" href="./assets/plugins/datatables/media/css/dataTables.bootstrap.min.css">
<script type="text/javascript" src="./assets/plugins/datatables/media/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="./assets/plugins/datatables/media/js/dataTables.bootstrap.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#datatable').DataTable( {
			"language": {
	            "url": "http://cdn.datatables.net/plug-ins/1.10.11/i18n/Indonesian.json"
	        }
			// "order": [[ 0, "desc" ]]
		} );
		$('#datatable2').DataTable( {
			// "order": [[ 0, "desc" ]]
		} );
	} );
</script>
<!-- Tooltip -->
<script type="text/javascript">
    $('.tooltip').tooltip({
        selector: "[data-toggle=tooltip]",
        container: "body"
    })
</script>
