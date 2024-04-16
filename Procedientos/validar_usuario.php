<?php
//FUNSION PARA VALIDAR DISPONIBILIDAD DEL NOMBRE DE USUARIO
//REFERENCIA ARCHIVO CONTROLADOR
require_once('../controlador/conexion.php');
//DECLARACION DE VARIABLES Y SIGNACION DE VALORES POR EL METODO POST
$usuario = $_POST['usuario'];
//CONEXION A BASE DE DATOS
$conn = conectar_PostgreSQL('postgres', 'semana010411', '127.0.0.1', '5432', 'asesores');
//SE REALIZA LA CONSULTA PARA VERIFICAR QUE EL USUARIO NO EXISTA
$sqlvalidar = "SELECT nombre_completo, estado FROM usuarios WHERE nombreusuario='".$usuario."'";
//SE EJECUTA LA CONSULTA
$sqlresul = pg_query($conn, $sqlvalidar);
//VERIFICACIN DE CONSULTA EXITOSA
if(!$sqlresul){
	//LA CONSULTA NO SE REALIZO
   echo 2;
}else{
	//LA CONSULTA SE RALIZA
	$fila = pg_fetch_array($sqlresul);
	//SE VERIFICA EL ESTADO DEL USUARIO
	$estado = $fila['estado'];
	$nombre = $fila['nombre_completo'];
	if($estado == 1 and $nombre != ''){
		//NOMBRE USUARIO NO DISPONIBLE
		echo 10;//el usuario ya existe y el estado es activo no se puede crrear un nuevo usuario con ese nombre
	}else{
		//USUARIO DISPONIBLE
		echo 12;//el usuario puede ser creado
	}
	//SE CIERRRA CONEXION CON LA BASE DE DATOS
	pg_close($conn);
}