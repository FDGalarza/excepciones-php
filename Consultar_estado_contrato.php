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
	/* $codigo = $_POST['codigo']; */
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
	<thead>
		<tr>
			<th>Doc identidad</th>
			<th>Primer Nombre</th>
			<th>Segundo Nombre</th>		
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
					<td><?php echo $fila["nom_1"];?></td>
					<td><?php echo $fila["nom_2"];?></td>
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
	/* if($inicio == 0){
		//si en la pagina actual se mostraron los registros a partir del primero mostramos el link anterior solo como texto
		echo "anteriores ";
		echo $inicio;
		echo $pagina;
	}else{
		//si el registro inicial no fue el primero de la consulta le asignamos a la variable inicio el valor que traia el numero d elregistros por pagina
		$anteriores = $inicio - 14;
?>
		<!--Creamos el link para mostrar los registros anteriores-->
		<a href="" onclick="paginacion_js(<?php $anteriores; ?>)">Anteriores </a>	
<?php
	
	} */
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