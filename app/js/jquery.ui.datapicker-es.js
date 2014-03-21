	jQuery(function($){
4	        $.datepicker.regional['es'] = {
5	                clearText: 'Limpiar', clearStatus: '',
6	                closeText: 'Cerrar', closeStatus: '',
7	                prevText: '&#x3c;Ant', prevStatus: '',
8	                prevBigText: '&#x3c;&#x3c;', prevBigStatus: '',
9	                nextText: 'Sig&#x3e;', nextStatus: '',
10	                nextBigText: '&#x3e;&#x3e;', nextBigStatus: '',
11	                currentText: 'Hoy', currentStatus: '',
12	                monthNames: ['Enero','Febrero','Marzo','Abril','Mayo','Junio',
13	                'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'],
14	                monthNamesShort: ['Ene','Feb','Mar','Abr','May','Jun',
15	                'Jul','Ago','Sep','Oct','Nov','Dic'],
16	                monthStatus: '', yearStatus: '',
17	                weekHeader: 'Sm', weekStatus: '',
18	                dayNames: ['Domingo','Lunes','Martes','Mi&eacute;rcoles','Jueves','Viernes','S&aacute;bado'],
19	                dayNamesShort: ['Dom','Lun','Mar','Mi&eacute;','Juv','Vie','S&aacute;b'],
20	                dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','S&aacute;'],
21	                dayStatus: 'DD', dateStatus: 'D, M d',
22	                dateFormat: 'dd/mm/yy', firstDay: 0, 
23	                initStatus: '', isRTL: false};
24	        $.datepicker.setDefaults($.datepicker.regional['es']);
25	});