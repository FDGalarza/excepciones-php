<?php
//FUNSION PARA EDITAR UN USUARIO DEL SISTEMA
//REFERENCIA ARCHIVO CONTROLADOR
require_once('../controlador/conexion.php');
//DECLARACION DE VARIABLES Y SIGNACION DE VALORES POR EL METODO POST
	$nom1 = $_POST['nombre1'];
	$ape1 = $_POST['Apellido1'];
	$ape2 = $_POST['Apellido2'];
	$doc = $_POST['doc'];
	$contrato = $_POST['contrato'];
	$excep = $_POST['excepcion'];
	$costo = $_POST['codigo'];
	//SE CONVIERTEN CARACTERES EN MAYUSCULAS
	$Nombre1 = strtoupper($nom1);
	$Apellido1 = strtoupper($ape1);
	$Apellido2 = strtoupper($ape2);
	//VERIFICACION CAMPOS VACIOS
			if($nom1 == ''){
				echo 15;
				
			}else{
				if($ape1 == ''){
				  echo 15;
			    }else{
				   if($costo == '' or $costo == '0'){
				     echo 15;
			       }else{
					  if($contrato == '' or $contrato == '0'){
				        echo 15;
			          }else{
						  if($excep == '' or $excep == '0'){
							  echo 15;
						  }else{
							    if( $doc != ''){
									//SE REALIZA LA INSERCION DE DATOS A LA BASE D EDATOS
									//LE DOY EL VALOR DE LA CONEXION A LA VARIABLE $OTRA
									$otra = conectar_PostgreSQL('postgres', 'semana010411', '127.0.0.1', '5432', 'asesores');
									//SI LE REGISTRO NO EXISTE HAGO EL INSERT EN LA BASE DE DATOS
									$sql = "INSERT INTO asesor(doc_identidad, nombres, ape_1, ape_2, centro_costos, estado_contraro, excep) VALUES('".$doc."','".$Nombre1."','".$Apellido1."',' ".$Apellido2."', '".$costo."', '".$contrato."',' ".$excep."')";
									//EJECUTO LA CONSULTA 
									$resultado = pg_query($otra, $sql);
									if(!$resultado){
										//NO SE REALIZA LA TRANSACCION CON EXITO
										echo 2;
									}else{
										//SE REALIZA LA TRANSACCION CON EXITO
										echo 5;
									}
									//CIERRO LA CONEXION
									pg_close($otra); 	
							   }else{
								 echo 15;
							   }	
						}
					}
		              
			     }
			  }
		   }
			
			
		
?>
