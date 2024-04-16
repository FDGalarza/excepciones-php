<?php 
//REFERENCIA AL FICHERO CONTROLADOR
	require_once('../controlador/conexion.php');
	//DECLARACION DE VARIABLES
	$usuario = $_POST['usuario'];
	$pass =$_POST['pass1'];
	//SE ENCRIPTA LA CONTRASEÑA INGRESADA
	$password = sha1($pass);
	//SE HACE CONEXION A LA BASE DE DATOS
	$conn = conectar_PostgreSQL('postgres', 'semana010411', '127.0.0.1', '5432', 'asesores');
	//SE HACE LA EDICION EN LA BASE DE DATOS
	$sqleditar = "UPDATE usuarios SET password = '".$password."' WHERE nombreusuario='".$usuario."'";
	//SE EJECUTA LA COSNULTA
	$result = pg_query($conn, $sqleditar);
	//VERIFICACION CONSULTA EXITOSA
	if(!$result){
		//SE EVIA ESTE VALOR A LA FUSNION AJAX INDICANDO QUE LA CONSULTA NO SE REALIZO
		echo 3;
	}else{
		$borrarhistorial = "DELETE  FROM historial_usuarios WHERE nombreusuario = '".$usuario."'";
		$borrar = pg_query($conn, $borrarhistorial);
		session_start();
		$time = time();
		//SE TOMA LA FECHA Y HORA DEL SISTEMA, DEBE VERIFICAR LA ZONA HORARIA EN EL ARCHIVO PHP.INI 
		$hoy = date("d-m-Y (H:i:s)", $time);
		$sqlhistorial = "INSERT INTO historial_usuarios(nombre, nombreusuario, password, fecha_modificacion, modificado_por, rol, estado) VALUES('".$_SESSION['nombre']."', '".$usuario."', '".$password."', '".$hoy."', '".$_SESSION['nombre']."', '".$_SESSION['rol']."',  1)";
		$ejecutar = pg_query($conn, $sqlhistorial);
		//SE ENVIA ESTA VALORA A LA FUNSION AJAX INDICANCO QUE LA CONSULTA SE RALIZO CON EXITO
		echo 2;
	}
	//SE CIERRA LA CONEXION A LA BASE DE DATOS
	pg_close($conn);
?>