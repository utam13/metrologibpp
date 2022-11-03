$(document).ready(function () {

	$('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
		$($.fn.dataTable.tables(true)).DataTable().columns.adjust().draw();
	});

	$('#mytable').DataTable({
		"bProcessing": true,
		"bPaginate": false,
		"bLengthChange": false,
		"scrollX": false,
		"scrollCollapse": false,
		"fixedHeader": false,
		"bFilter": false,
		"bInfo": false,
		"bAutoWidth": true,
		"oLanguage": {
			"sEmptyTable": "Data masih kosong"
		}
	});

	$('#mytable_item').DataTable({
		"bProcessing": true,
		"bPaginate": true,
		"bLengthChange": true,
		"iDisplayLength": 10,
		"scrollX": true,
		"scrollY": true,
		"scrollCollapse": true,
		"fixedHeader": false,
		"bFilter": true,
		"bInfo": false,
		"bAutoWidth": false,
		"oLanguage": {
			"sEmptyTable": "Data masih kosong",
			"sSearch": "Pencarian: ",
			"oPaginate": {
				"sFirst": "<i class='fa fa-fast-backward'></i>",
				"sLast": "<i class='fa fa-fast-forward'></i>",
				"sNext": "<i class='fa fa-forward'></i>",
				"sPrevious": "<i class='fa fa-backward'></i>"
			}
		}
	});

});
