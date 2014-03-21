<?php
	require_once('../controller/sessionController.php'); 
	require_once('../model/empresaModel.php'); 
?>
<?php
////////////////////// CASO DE USO PERFIL EMPRESA ///////
	if ($_POST['origen']=='editEmp')
	{
		$objEmpresa = new Empresa();
		$objEmpresaCont = new EmpresaCont();
		$objEmpresaCodArancel = new EmpresaCodArancel();
		$objCodArancel = new CodArancel();

		$AF_RIF						= $_POST["AF_RIF"];
		$ciudad_AF_CodCiudad		= $_POST["ciudad_AF_CodCiudad"];
		$pais_AL_CodPais 			= $_POST["pais_AL_CodPais"];
		$AF_Clasificacion_Empresa	= $_POST["AF_Clasificacion_Empresa"];
		$AF_Razon_Social			= $_POST["AF_Razon_Social"];
		$AF_Direccion				= $_POST["AF_Direccion"];
		$AL_Web						= $_POST["AL_Web"];
		$AF_Correo_Electronico		= $_POST["AF_Correo_Electronico"];
		$AF_Telefono				= $_POST["AF_Telefono"];
		$AF_Fax						= $_POST["AF_Fax"];

		$objEmpresa->actualizar($objConexion,$AF_RIF,$ciudad_AF_CodCiudad,$pais_AL_CodPais,$AF_Clasificacion_Empresa,$AF_Razon_Social,$AF_Direccion,$AL_Web,$AF_Correo_Electronico,$AF_Telefono,$AF_Fax);

		for($k=0;$k<=$_POST['cant_contac'];$k++){

				$id 			= $_POST['id'.$k];
				$NU_Cedula 		= $_POST["NU_Cedula".$k];
				$AF_RIF 		= $AF_RIF;
				$AL_Nombre 		= $_POST["AL_Nombre".$k];
				$AL_Apellido	= $_POST["AL_Apellido".$k];
				$AF_Cargo 		= $_POST["AF_Cargo".$k];

			if ($_POST["AL_Nombre".$k]!=''){
				if ($id==''){
					$objEmpresaCont->insertar($objConexion,$NU_Cedula,$AF_RIF,$AL_Nombre,$AL_Apellido,$AF_Cargo); 
				}else{
					$objEmpresaCont->update($objConexion,$id,$NU_Cedula,$AF_RIF,$AL_Nombre,$AL_Apellido,$AF_Cargo); 					
				}
			}else{
				if ($id){
					$objEmpresaCont->delete($objConexion,$id); 									
				}
			}
		}
		
		$rsDelCodA = $objEmpresaCodArancel->delete($objConexion,$AF_RIF);
		
		$rsCodA = $objCodArancel->listar($objConexion);
		$cantRS = $objConexion->cantidadRegistros($rsCodA);
		
		for($i=0;$i<=$cantRS;$i++)
		{
			$AL_CodArancel=$objConexion->obtenerElemento($rsCodA,$i,"AL_CodArancel");
			if(isset($_POST["chk".$AL_CodArancel]))
			{
				$objEmpresaCodArancel->insertar($objConexion,$AL_CodArancel,$AF_RIF);
			}
		}
		
		$mensaje='El Perfil de la Empresa se ha actualizado Correctamente.';
		header("Location: ../views/centralView.php?mensaje=$mensaje");
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