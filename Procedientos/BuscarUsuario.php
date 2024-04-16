<?php 
//Se hace referencia al archivo ocntrolador para poder utilizar la funcion para hacer conexin con la base de datos
require_once("../controlador/conexion.php");
		//Declaracion de variables tomadno los campos enviados por la funsion de ajax
		$nombre = $_POST['nombreCompleto'];
		//Para pasar a mayusculas los datos recibidos
		$nombres = strtoupper($nombre);
		$correo;
		$usuario;
		$rol;
		$estado;
			//CONEXION CON BASE DE DATOS Y ASIGNACION DE LA VARIABLE DE CONEXION
			$conn = conectar_PostgreSQL('postgres', 'semana010411', '127.0.0.1', '5432', 'asesores');
			//CONSULTA A LA BASE DE DATOS PARA CONFIRMAR QUE EL USUARIO EXISTA
			$sqlcentro = "SELECT correo_electronico, nombreusuario, password, nombre_completo, estado, rol FROM usuarios WHERE nombre_completo LIKE'".$nombres."%'";
			//EJECUCION DE LA CONSULTA SE PASA COMO PARAMETROS LA VARABLE DE CONEXION Y LA VARIABLE QUE CONTIENE LA CONSULTA
			$result = pg_query($conn, $sqlcentro);
				//SE VERIFICA QUE LA CONSULTA REALIZADA TENGA REGISTROS O NO
				if(pg_num_rows($result)==false){
					//SI LA CONSULTA NO CONTIENE REGISTROS PASAMOS EL PARAMETRO CERO ALA FUNSIONDE AJAX
					echo 0;
					
				}else{
					//SI LA CONSULTA OBTUVO REGISTROS SE CAPTURAN ESTOS REGISTROS EN VRIABLES
					while($fila = pg_fetch_array($result)){
						$nombres = $fila['nombre_completo'];
						$correo = $fila['correo_electronico'];
						$usuario = $fila['nombreusuario'];
						$rol = $fila['rol'];
						$estado = $fila['estado'];
					}
					//SE CIERRA LA CONEXION CON LA BASE DE DATOS, SE PASA COMO PARAMETROS LA VARIABLE DE LA CONEXION ABIERTA AL PRINCIPIO DE LA FUNSION
					pg_close($conn);
					//CONVERTIR LAS VARIABLES EN ARRAYS Y SE PASA A LA FUNSION DE AJAX
					echo $nombres. ",".$correo.",".$usuario." ,".$estado.",".$rol;
					
				}
?>