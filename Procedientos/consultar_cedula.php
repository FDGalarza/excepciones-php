<?php 
//CON ESTA FUNSION SE CONSULTAS LOS DATOS EN EL MOMENTO DE LA EDICION DE UN COLOCADOR
	//REFERENCIA FICHERO CONTROLADOS
require_once("../controlador/conexion.php");
		//DECLARACON DE VARIABLES
		$cedula = $_POST['doc'];
		$Ncentro;
		$Nombre1;
		$Apellido1;
		$Apellido2;
		$Centro;
		$contrato;
		$excepcion;
		//CONEXION BASE DE DATOS
			$conn = conectar_PostgreSQL('postgres', 'semana010411', '127.0.0.1', '5432', 'asesores');
			//CONSULTA A LA BASE DE DATOS PARA TRAER LOS DATOS DEL COLOCADOR
			$sqlcentro = "SELECT nombres, ape_1, ape_2, centro_costos, estado_contraro, excep FROM asesor WHERE doc_identidad ='".$cedula."'";
			//SE EJECUTA LA COSNSULTA
			$result = pg_query($conn, $sqlcentro);
			//SE VERIFCA QUE LA CONSULTA TENGA REGISTROS
				if(pg_num_rows($result) == 0){
					//SI LA CONSULTA NO TRAE REGISTROS SE ENVIA ESTE VALOR A LA FUNSION DE AJAX INDICANDO EQU EL USUARIO NO EXISTE
					echo 0;
				}else{
					//SI LA CONSULTA TIENE REGISTROS SE ASIGNAN A LAS VARIABLES DECLARADAS
					while($fila = pg_fetch_array($result)){
						$Nombre1 = $fila['nombres'];
						$Apellido1 = $fila['ape_1'];
						$Apellido2 = $fila['ape_2'];
						$Centro = $fila['centro_costos'];
						$contrato = $fila['estado_contraro'];
						$excepcion = $fila['excep'];
					}
					
					$conn = conectar_PostgreSQL('postgres', 'semana010411', '127.0.0.1', '5432', 'asesores');	
					//SE CONSULTA LA TABLA CENTRO COSTOS DE LA BASE DE DATOS PARA TRAER EL NOMBRE DEL CENTRO DE COSTOS
					$sqlcentro = "SELECT nombre FROM centro_costos WHERE codigo ='".$Centro."'";
					$resultado = pg_query($conn, $sqlcentro);
					$fila = pg_fetch_array($resultado);
					$Ncentro = $fila["nombre"];
					pg_close($conn);
					//SE ENVIA EL RESULTADO DE LA CONSULTA A LA FUNSION DE AJAX EN FORMA DE ARRAYS
					echo $Nombre1. ", ".$Apellido1.",".$Apellido2.",".$Centro." ,".$contrato.",".$excepcion;
					
				}
?>


