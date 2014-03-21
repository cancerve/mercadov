<?php
	require_once('../controller/sessionController.php'); 
	require_once('../model/mercadoModel.php'); 
	require_once('../model/mercadoProductoModel.php'); 
?>
<?php
	///// CONVIERTE FECHA 04/07/1980 A 1980-07-04 (FORMATO MYSQL)
	function setFechaSQL($FE_FechaNac)
	{
		$partes = explode("/", $FE_FechaNac);
		$FE_FechaNac = $partes[2].'-'.$partes[1].'-'.$partes[0];
		return $FE_FechaNac;
	}
////////////////////// CASO DE USO PERFIL EMPRESA ///////
	if ($_POST['origen']=='apertura_mercado')
	{
		$objMercado 		= new Mercado();
		$objMercadoProducto = new MercadoProducto();

		$empresa_NU_IdEmpresa	= $_POST["empresa_NU_IdEmpresa"];
		$FE_FechaMercado		= setFechaSQL($_POST["FE_FechaNac1"]);
		$FE_Inicio				= setFechaSQL($_POST["FE_Inicio"]);
		$FE_Fin 				= setFechaSQL($_POST["FE_Fin"]);

		$verificarMercado = $objMercado->verificarActivo($objConexion,$empresa_NU_IdEmpresa);
		
		if ($verificarMercado==1){
			$mensaje='ERROR: Actualmente esta empresa ya posee un Mercado Virtual activo.';
			header("Location: ../views/apertura_mercado/index.php?mensaje=$mensaje");
		}else{
			$objMercado->insertar($objConexion,$empresa_NU_IdEmpresa,$FE_FechaMercado,$FE_Inicio,$FE_Fin);
			
			$NU_IdMercado = $objMercado->obtenerUltimo($objConexion);
			
			for($k=0;$k<=$_POST['cantProducto'];$k++){
	
				$NU_IdProducto	= $_POST["chk".$k];
	
				if (isset($_POST["chk".$k])){
					$objMercadoProducto->insertar($objConexion,$NU_IdMercado,$NU_IdProducto); 
				}
			}
	
			$mensaje='El Mercado Virtual se ha aperturado Correctamente.';
			header("Location: ../views/apertura_mercado/index.php?mensaje=$mensaje");
		}
	}
////////////////////// CASO DE USO CONTACTAR EMPRESAS ///////
	if ($_POST['origen']=='Contactar Empresa')
	{
		$objEmpresa = new Empresa();	
		$objEmpresaPostu = new EmpresaPostu();
			
		$evento_AF_CodEvento 	= $_POST["AF_CodEvento"];
		$BI_Status 				= 1; 
		$asunto 				= $_POST['asunto'];		

		$RS = $objEmpresa->buscarXEventXcod($objConexion,$evento_AF_CodEvento);		
		$cantRS = $objConexion->cantidadRegistros($RS);

		$para='';

		for($i=1;$i<=$_POST['cantidad'];$i++)
		{
			if(isset($_POST["chk".$i]))
			{
				$para .= $_POST["chk".$i].',';
				$AF_RIF = $objConexion->obtenerElemento($RS,$i-1,"AF_RIF");
				
				$RSexist = $objEmpresaPostu->buscarXempresaXevento($objConexion,$AF_RIF,$evento_AF_CodEvento);
				$cantRSexist = $objConexion->cantidadregistros($RSexist);
				if($cantRSexist==0){
					$objEmpresaPostu->insertar($objConexion,$evento_AF_CodEvento,$AF_RIF,$BI_Status);
				}
			}
		}		
		$adjunto = $_FILES['adjunto']['tmp_name'];
		if ($adjunto!=''){
			//////////// CON ADJUNTO
			$destino = "../images/adjuntos/".$_FILES['adjunto']['name'];
			if(!@move_uploaded_file($origen, $destino))
			{
				die("Error al tratar de subir el archivo");
			}
			$fp = fopen($destino, 'rb');
			$data = fread($fp, $_FILES['adjunto']['size']);
			fclose($fp);
			
			$data = chunk_split(base64_encode($data));
			$borde_mime = "BORDE_MULTIPARTE_123";
			$ent = chr(13).chr(10);
			$encabezados = "Content-Type: multipart/mixed; ".
					   "boundary=".chr(34).$borde_mime.chr(34);
			$mensaje = "--$borde_mime".$ent;
			$mensaje.= "Content-Type: text/html; ".
					   "charset=".chr(34)."iso-8859-1".chr(34).";".$ent.$ent;
			$mensaje.=$_POST['mensaje'].$ent.$ent;
			$mensaje.= "--$borde_mime".$ent;
			$mensaje.= "Content-Type: ".$_FILES['adjunto']['type'].";".
					   "name=".chr(34).$_FILES['adjunto']['name'].chr(34).";".$ent;
			$mensaje.= "Content-Transfer-Encoding: base64 ".$ent;
			$mensaje.= "Content-Disposition: attachment; ".
			"filename=".chr(34).$_FILES['adjunto']['name'].chr(34).";".$ent.$ent;
			$mensaje.="$data".$ent;
			$mensaje.= "--$borde_mime--".$ent;
			if(!mail($para,$asunto,$mensaje,$encabezados)){
				$mensaje = "Error al tratar de enviar el Correo \n";
			}else{
				$mensaje = "Correo Enviado Correctamente \n";			
			}
		}else{
			////////////// SIN ADJUNTO
			$remitente = "INFORMACION OFICINA COMERCIAL";
			$correo = "contacto@bancoex.gob.ve";	 
			$headers = "MIME-Version: 1.0\r\n";
			$headers.= "From: BANCOEX <$remitente>\n";
			$headers.= "Content-type: text/html; charset=iso-8859-1\r\n";
			$mensaje = $_POST['mensaje'];
			if(!mail($para,$asunto,$mensaje,$headers)){
				$mensaje = "Error al tratar de enviar el Correo \n";
			}else{
				$mensaje = "Correo Enviado Correctamente \n";			
			}
		}

		echo "<META HTTP-EQUIV=\"REFRESH\" CONTENT=\"0; URL=../views/contactarEmp/index.php?mensaje=$mensaje\">";
	}	
	
////////////////////// CASO DE USO POSTULAR EMPRESA INTERNAS ///////
	if ($_POST['origen']=='Postular Internas')
	{
		$objEmpresaPostu = new EmpresaPostu();		
		
		$AF_CodEvento = $_POST['AF_CodEvento'];
		
		$RS=$objEmpresaPostu->buscarXcandidatas($objConexion,$AF_CodEvento);
		$cant=$objConexion->cantidadRegistros($RS);
		
		for($i=0;$i<$cant;$i++)
		{
			if(isset($_POST['chk'.$i]))
			{
				$empresa_AF_RIF = $_POST['chk'.$i];
				$objEmpresaPostu->actStatus($objConexion,$AF_CodEvento,$empresa_AF_RIF,2);
			}
		}
		
		$c='1';
		$mensaje='Empresas Postuladas Correctamente! Ahora se encuentran a disposicion del Comite de Seleccion para su evaluacion.';
		header("Location: ../views/centralView.php?mensaje=$mensaje&&c=$c");
	}
////////////////////// CASO DE USO POSTULAR EMPRESA EXTERNAS ///////
	if ($_POST['origen']=='Postular Externas')
	{
		$objEmpresaPostu = new EmpresaPostu();		
		
		$AF_CodEvento = $_POST['AF_CodEvento'];
		
		$objEmpresaPostu->actStatus($objConexion,$AF_CodEvento,$_SESSION['AF_RIF'],2);
		
		$mensaje='Empresa Postulada Correctamente! Ahora se encuentra a disposicion del Comite de Seleccion para su evaluacion.';
		header("Location: ../views/centralView.php?mensaje=$mensaje");
	}	
////////////////////// CASO DE USO EVALUAR Y SELECCIONAR EMPRESA ///////	
	if ($_POST['origen']=='Seleccionar Empresas')
	{
		$objEmpresaPostu = new EmpresaPostu();		
		
		$AF_CodEvento = $_POST['AF_CodEvento'];
		
		$RS=$objEmpresaPostu->buscarXpostulada($objConexion,$AF_CodEvento);
		$cant=$objConexion->cantidadRegistros($RS);
		
		for($i=0;$i<$cant;$i++)
		{
			if(isset($_POST['chk'.$i]))
			{
				$ep_id = $_POST['chk'.$i];
				$objEmpresaPostu->actStatus($objConexion,$ep_id,3);
				
				$asunto = 'Felicitaciones';		
				$para='';
				for($i=0;$i<$cant;$i++)
				{
					$para .= $objConexion->obtenerElemento($RS,$i,"AF_Correo_Electronico").',';
				}
				$borde_mime = "BORDE_MULTIPARTE_123";
				$ent = chr(13).chr(10);
				$encabezados = "Content-Type: multipart/mixed; ".
						   "boundary=".chr(34).$borde_mime.chr(34);
				$mensaje = "--$borde_mime".$ent;
				$mensaje.= "Content-Type: text/html; ".
						   "charset=".chr(34)."iso-8859-1".chr(34).";".$ent.$ent;
				$mensaje.='Felicitaciones su Empresa ha sido Seleccionada!!'.$ent.$ent;
				$mensaje.= "--$borde_mime".$ent;
				$mensaje.= "--$borde_mime--".$ent;

				if(!mail($para,$asunto,$mensaje,$encabezados)){
					$mensaje = "Error al tratar de enviar el Correo \n";
					$tmenj = 0;
				}else{
					$mensaje = "Correo Enviado Correctamente \n";			
					$tmenj = 1;
				}		
	//////////////////////////////////////////////////////////////////////		
				
			}
		}
		$c='1';
		$mensaje='Empresas Seleccionadas Correctamente! En espera de la decision de participacion por parte de las Empresas.';
		header("Location: ../views/centralView.php?mensaje=$mensaje&&c=$c");
	}
	
?>