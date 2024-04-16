<?php 
// CONSULTAR ASESORES ESTADO DE CONTRATO
	require_once("../controlador/conexion.php");
	//El número maximo de registros por pagina
	$tamaño_pagina = 14;
	//para almacenar cuantos registros se han mostrado
	$impresos = 0;
	//hacemos el get de la pagina actual
	$pagina = isset($_GET['pos']);
	if(isset($_GET['pos'])){
		//si la pagina actual es diferente de null el limit d ela consulta inicia en el valor tomado de la pagina
		$inicio = ($_GET['pos']);
	}else{
		//si el valor de la pagina actual es cero declaramos el limit de la coansulta en cero
		$inicio = 0;
	}
	session_start();
	$contrato = $_POST['contrato'];
	if($contrato == "GENERAL"){
		//$declaramos la variable conexion
		$conn = conectar_PostgreSQL('postgres', 'semana010411', '127.0.0.1', '5432', 'asesores');
		//hacemos la cosnulta a la base de datos
		$sqlborrar = "DROP TABLE asesort_temp";
		$borrar = pg_query($conn, $sqlborrar);
		$sqlcontrato = "CREATE TABLE asesort_temp AS SELECT * FROM asesor ";
		//ejecutamos la cosnulta
		$result = pg_query($conn, $sqlcontrato);
	}
	else{
		$conn = conectar_PostgreSQL('postgres', 'semana010411', '127.0.0.1', '5432', 'asesores');
	$sqlcontrato = "SELECT * FROM asesor  WHERE estado_contraro = '".$contrato."'";
	$result = pg_query($conn, $sqlcontrato);
	}
	$contar = pg_num_rows($result);
	
?>
<table class="table table-hover">
	<!--ENCABEZADO DE LA TABLA EN LA QUE SE MOSTRARA LOS REGISTROS-->
	<thead>
		<tr>
			<th>Doc identidad</th>
			<th>Nombres</th>	
			<th>Primer Apellido</th>
			<th>Segundo Apellido</th>
			<th>centro de Costos</th>
			<th>Estado Contrato</th>
			<th>Excepci&oacute;n</th>
		</tr>
	</thead>
		<tbody>
<?php	
	//empezamos a leer lor registros traidos en la consulta
	while($fila = pg_fetch_array($result)){
?>
				<tr>
					<td><?php echo $fila["doc_identidad"];?></td>
					<td><?php echo $fila["nombres"];?></td>
					<td><?php echo $fila["ape_1"];?></td>
					<td><?php echo $fila["ape_2"];?></td>
<?php
						$sqlcentro = "SELECT nombre FROM centro_costos WHERE codigo = '".$fila['centro_costos']."'";
						$r = pg_query($conn, $sqlcentro);
						$f = pg_fetch_array($r);
						$Ncentro = $f['nombre'];
?>
					<td><?php echo $fila["centro_costos"]." - ".$Ncentro;?></td>
					<td><?php echo $fila["estado_contraro"];?></td>
<?php
					if($fila["excep"] == 1){
?>
					<td><?php echo "SI";}else{?></td>
					<td><?php echo "NO";}?></td>

				</tr>
<?php
	$impresos++;
	}
	pg_close($conn);
	$print = 0;
	$conn = conectar_PostgreSQL('postgres', 'semana010411', '127.0.0.1', '5432', 'asesores');
	$sqlcontar = "select * from asesort_temp";
	$res = pg_query($conn, $sqlcontar);
	$contar = pg_num_rows($res);
	for($i = 0; $i <= $contar; $i= $i+20){
		

		echo "<a href="" onclick=\" paginacion_js()\">$print </a>";
		$print++;
	}
?>
		</tbody>
</table>