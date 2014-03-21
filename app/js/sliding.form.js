$(function() {
	/*
	n&uacute;mero de fieldsets
	*/
	var fieldsetCount = $('#form1').children().length;
 
	/*
	Posici&oacute;n actual del fieldset / link de navegaci&oacute;n
	*/
	var current 	= 1;
 
	/*
	suma y almacena las anchuras de cada uno de los fieldsets
	establece el sumatoria total como ancho total del elemento
	*/
	var stepsWidth	= 0;
    var widths 		= new Array();
	$('#steps .step').each(function(i){
        var $step 		= $(this);
		widths[i]  		= stepsWidth;
        stepsWidth	 	+= $step.width();
    });
	$('#steps').width(stepsWidth);
 
	/*
	Para solucionar los problemas de IE, se pone el foco in el primer elemento del formulario
	*/
	$('#form1').children(':first').find(':input:first').focus();	
 
	/*
	Muestra la barra de navegaci&oacute;n
	*/
	$('#navigation').show();
 
	/*
	Cuando se clica sobre el link de navegaci&oacute;n el formulario se desplaza al correspondiente fieldset
	*/
    $('#navigation a').bind('click',function(e){
		var $this	= $(this);
		var prev	= current;
		$this.closest('ul').find('li').removeClass('selected');
        $this.parent().addClass('selected');
		/*
		Almacenamos la posici&oacute;n del link
		*/
		current = $this.parent().index() + 1;
		/*
		anima / slide al siguiente o al correspondiente fieldset. El orden de los links en la navegaci&oacute;n es el orden de los fieldsets. Adem&aacute;s, despu&eacute;s del sliding, el foco se posiciona sobre el primer elemento del siguiente fieldest.
		Si se clica sobre el &uacute;ltimo link (confirmaci&oacute;n), se validan todos los fieldsets, sino se valida el fieldset anterior antes de que se produzca el slide
		*/
        $('#steps').stop().animate({
            marginLeft: '-' + widths[current-1] + 'px'
        },500,function(){
			if(current == fieldsetCount)
				validateSteps();
			else
				validateStep(prev);
			$('#form1').children(':nth-child('+ parseInt(current) +')').find(':input:first').focus();
		});
        e.preventDefault();
    });
 
	/*
	Clicando el el tab (en el &uacute;ltimo input de cada fieldset), se fuerza a ir al "siguiente paso"
	*/
	$('#form1 > fieldset').each(function(){
		var $fieldset = $(this);
		$fieldset.children(':last').find(':input').keydown(function(e){
			if (e.which == 9){
				$('#navigation li:nth-child(' + (parseInt(current)+1) + ') a').click();
				/* force the blur for validation */
				$(this).blur();
				e.preventDefault();
			}
		});
	});
 
	/*
	validaci&oacute;n de errores de todos los fieldsets 
	Almacena posibles errores en $('#form1').data()
	*/
	function validateSteps(){
		var FormErrors = false;
		for(var i = 1; i < fieldsetCount; ++i){
			var error = validateStep(i);
			if(error == -1)
				FormErrors = true;
		}
		$('#form1').data('errors',FormErrors);
	}
 
	/*
	Valida un fieldset y retorna -1 si hay errores o 0 si no los hay
	*/
	function validateStep(step){
		if(step == fieldsetCount) return;
 
		var error = 1;
		var hasError = false;
		$('#form1').children(':nth-child('+ parseInt(step) +')').find(':input:not(button)').each(function(){
			var $this 		= $(this);
			var nombre_id   = $(this).attr("id");
			var tipo 		= $(this).attr('type');
			
			//if (tipo == 'text'){
	////////////VALIDAR: AF_CodEvento
				if(nombre_id == 'AF_CodEvento'){
					// Campo Obligatorio
					var valueLength = jQuery.trim($this.val()).length;
					if(valueLength == ''){
						hasError = true;
						$this.css('background-color','#FFEDEF');
					}
					else
						$this.css('background-color','#FFFFFF');
				}
	////////////VALIDAR: asunto			
				if(nombre_id == 'asunto'){
					// Campo Obligatorio
					var valueLength = jQuery.trim($this.val()).length;
					if(valueLength == ''){
						hasError = true;
						$this.css('background-color','#FFEDEF');
					}
					else
						$this.css('background-color','#FFFFFF');
				}
	/*///////////////////////// EJEMPLO ORIGINAL VALIDACION DE CAMPO
				if(nombre_id == 'AF_CodEvento'){
					var valueLength = jQuery.trim($this.val()).length;
		 
					if(valueLength == ''){
						hasError = true;
						$this.css('background-color','#FFEDEF');
					}
					else
						$this.css('background-color','#FFFFFF');
				}
			}
			var check_error;
		if (tipo == 'checkbox'){
				// Por lo menos algun checkbox obligatorio
				var marcado = $(this).attr("checked");
				if(marcado){
					check_error = 0;
					$this.css('background-color','#FFFFFF');				
				}else{
					if(check_error != 0){
						check_error = 1;
						$this.css('background-color','#FFEDEF');
					}
				}
			}*/
//////////////////////////////////////////////////////////FIN VALIDACION			
		});

		if (hasError == true){
			hasError = true;
		}

		var $link = $('#navigation li:nth-child(' + parseInt(step) + ') a');
		$link.parent().find('.error,.checked').remove();
 
		var valclass = 'checked';
		if(hasError){
			error = -1;
			valclass = 'error';
		}
		$('<span class="'+valclass+'"></span>').insertAfter($link);
 
		return error;
	}
 
	/*
	Si hay errores no se produce el submit
	*/
	$('#Enviar').bind('click',function(){
		if($('#form1').data('errors')){
			alert('Por favor, corrija los errores en el formulario');
			return false;
		}
	});
});