<?php 
//REFERENCIA AL FICHERO CONTROLADOR
	require_once('../controlador/conexion.php');
	//DECLARACIONDE VARAIBLES
	$usuario = $_POST['usuario'];
	$pass =$_POST['password2'];
	//SE ENCRIPTA LA CONTRASEÑA
	$password = sha1($pass);
	//CONXION BASE DE DATOS
		$conn = conectar_PostgreSQL('postgres', 'semana010411', '127.0.0.1', '5432', 'asesores');
		//SE HACE CONSULTA A BASE DE DATOS PARA VERIFICAR QUE LA CONTRASEÑA SI ES LA CORRECTA
		$sqlusuario = "SELECT password FROM usuarios WHERE nombreusuario='".$usuario."'";
		//SE EJECUTA LA CONSULTA ANTERIOR
		$result = pg_query($conn, $sqlusuario);
		//SE ASIGNA A LA VARIABLE FILA LOS DATOS TRAIDOS EN LA CONSULTA
		$fila = pg_fetch_array($result);
		//SE LE ASIGNA EL VALOR DEL PASSWORD ALMACENADO A LA VARIABLE DECLARADA PARA ESTE FIN
		$passw = $fila['password'];
		//SE VERIFICA QUE EN LA VARIABLE HAYA ALGUN DATO
		if($password == $passw){
		//SI SE HA ENCONTRADO ALGUNA COINCIDENCIA SE ENVIA ESTE VALOR A LA FUNSION AJAX
		echo 10;
		}else{
			//SI NO SE HA ENCONTRADO ALGUNA COINCIDENCIA SE ENVIA ESTE VALOR A LA FUNSION AJAX
			echo 20;
		}
		//SE CIERRA CONEXION A LA BASE DE  DATOS
	pg_close($conn);
?>