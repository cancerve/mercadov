// JavaScript Document
$(document).ready(function() {
    $('#grilla').dataTable( {
        "sPaginationType": "full_numbers",
		"oLanguage": {
			"sLengthMenu": "Mostrando _MENU_ Registros por pagina",
			"sZeroRecords": "No se encontr&oacute; nada - lo siento",
			"sInfo": "Mostrando _START_ al _END_ de _TOTAL_ Registros",
			"sInfoEmpty": "Mostrando 0 al 0 de 0 Registros",
			"sSearch": "Buscar:",
			"oPaginate": {
				"sFirst":    "Primera",
				"sPrevious": "Anterior",
				"sNext":     "Siguiente",
				"sLast":     "Ultimo"
			},
			"sInfoFiltered": "(filtrado de _MAX_ total registros)"
		}
    } );
} );