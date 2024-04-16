<?php
//FUNSION PARA EDITAR DATOS DE LOS ASESORES
//REFERENCIA ARCHIVO CONTROLADOR
require_once('../controlador/conexion.php');
	//DECLARACION DE VARIABLES Y ASIGNACION DE VALORES POR EL METODO POST
	$nom1 = $_POST['nombre1'];
	$ape1 = $_POST['Apellido1'];
	$ape2 = $_POST['Apellido2'];
	$doc = $_POST['doc'];
	$centro = $_POST['codigo'];
	$contrato = $_POST['contrato'];
	$excep = $_POST['excepcion'];
	//SE CONVIERTEN LOS CARACTERES EN MAYUSCULAS
	$Nombre1 = strtoupper($nom1);
	$Apellido1 = strtoupper($ape1);
	$Apellido2 = strtoupper($ape2);
	//CONEXION A LA BASE DE DATOS
	$otra = conectar_PostgreSQL('postgres', 'semana010411', '127.0.0.1', '5432', 'asesores');
	//VERIFICACION CAMPOS VACIOS
	 if($nom1 == ''){
		echo 15;				
	 }else{
    	if($Apellido1 == ""){
 		  echo 15;
	    }else{
		   if($centro == "" OR $centro == '0'){
		     echo 15;
	       }else{
    		 if($contrato == "" OR $contrato == '0'){
		       echo 15;
			 }else{
			   if($excep == "" OR $excep == '0'){
				  echo 15;
			   }else{
			      if( $doc != ''){
					//SI LA CONEXION ES TRUE HAGO LA CONSULTA 
					
					$sql = "UPDATE asesor SET nombres='".$Nombre1."', ape_1='".$Apellido1."', ape_2='".$Apellido2."', centro_costos='".$centro."', estado_contraro='".$contrato."', excep='".$excep."' WHERE doc_identidad ='".$doc."'";
					//EJECUTO LA CONSULTA 
					$result = pg_query($otra, $sql);
					//CIERRO LA CONEXION
					//VERIFICACION CONSULTA
					if(!$result){
						//CONSULTA NO REALIZADA
				    	echo 2;
					}else{
						//CONSULTA REALIZADA
						if($excep == 1){
							$excepcion = "SI";
						}else{
							$excepcion = "NO";
						}
						//SE INSERTA EN LA TABLA HISTORIAL LA MODIFICAION REALIZADA LA ASESOR
						//DECLARACION DE LA VARIABLE PARA LA FECHA
						$time = time();
						//SE TOMA LA FECHA Y HORA DEL SISTEMA, DEBE VERIFICAR LA ZONA HORARIA EN EL ARCHIVO PHP.INI 
						$hoy = date("d-m-Y (H:i:s)", $time);
						//SE DECLARA LA SESSION INICIADA PARA UTILIZAR UNA VARAIBLE DE SESSION
						session_start();
						//SE INSERTAN LOS DATOS A LA BASE DE DATOS
						$sqlmodificar = "INSERT INTO historiar(doc_identidad, excepcion, contrato, centro_costos, fecha_modificacion, usuario_modificacion) VALUES('".$doc."','".$excepcion."','".$contrato."','".$centro."','".$hoy."','".$_SESSION['nombre']."')";
						//SE EJECUTA LA CONSULTA DE INSERCION DE DATOS
						$sqlhisttorial = pg_query($otra, $sqlmodificar);
						//SE ENVIA ESTE VALOR A LA FUNSION DE AJAX INDICANDO LA EDICION REALIZADA
					   echo 5;
					}
					//CIERRO LA CONEXION
					pg_close($otra); 	
				  }else{
					  //SE ENVIA ESTE VALOR AQ LA FUNSION DE AJAX INIDCANDO QUE LA EDICION NO SE REALIZO, HUBO AL GUN PROBLEMA EN EL PROCEDIMIENTO
					echo 15;
				  }	
			  }
			}            
		  }
		}
	  }
?>
