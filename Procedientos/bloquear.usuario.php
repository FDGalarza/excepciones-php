<?php 
//REFERENCIA AL FICHERO CONTROLADOR
	require_once('../controlador/conexion.php');
	//DECLARACION DE VARIABLES
	$usuario = $_POST['usuario'];
	//CONEXION BASE DE DATOS
	$conn = conectar_PostgreSQL('postgres', 'semana010411', '127.0.0.1', '5432', 'asesores');
	//CONSULTA BASE DE DATOS
	$sqlbloquiado = "SELECT estado FROM usuarios WHERE nombreusuario ='".$usuario."'";
	//SE EJECUTA LA CONULTA
	$result = pg_query($conn, $sqlbloquiado);
	//ASUGANCION DE EL RESULTADO DE LA CONSULTA
	$fila = pg_fetch_array($result);
	//SE DECLARA LA VARIABLE ESTADO Y SE LE ASIGNA EL VALOR TRAIOD EN LA CONSULTA
	$estado = $fila['estado'];
	//VERIFICACION DEL ESTADO DE LA CONSULTA
	if($estado == 2){
		//SE LE ENVIA ESTE VALOR A LA FUNSION DE AJAX INDICANDO QUE EL USUARIO ESTA BLOQUEADO
		echo 5;
	}else{
		//SE LE ENVIA ESTE VALOR A LA FUNSIONDE JAX INDICANDO QUE EL USUARIO ESTA HABILITADO
		echo 2;
	}
	pg_close($conn);
?>