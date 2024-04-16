<?php
	require_once('../controlador/conexion.php');
	$documento = $_POST['documento'];
	$conn = conectar_PostgreSQL('postgres', 'semana010411', '127.0.0.1', '5432', 'asesores');
	$sqlcedula = "SELECT excep FROM asesor WHERE doc_identidad = '".$documento."'";
	$result = pg_query($conn, $sqlcedula);
	$fila = pg_fetch_array($result);
	$Nombre = $fila['excep'];
	echo $Nombre;