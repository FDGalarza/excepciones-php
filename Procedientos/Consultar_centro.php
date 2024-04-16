<?php
	require_once("../controlador/conexion.php");
		$codigo = $_POST['codigo'];
		$Ncentro;
		$conn = conectar_PostgreSQL('postgres', 'semana010411', '127.0.0.1', '5432', 'asesores');
			$sqlcentro = "SELECT nombre FROM centro_costos WHERE codigo ='".$codigo."'";
			$result = pg_query($conn, $sqlcentro);
			$fila = pg_fetch_array($result);
			$Ncentro = $fila['nombre'];
			pg_close($conn);
echo $Ncentro;
?>
		