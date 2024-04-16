<?php 
	require_once("../controlador/conexion.php");
	session_start();
	$contrato = $_POST['contrato'];
	$tamaño_pagina = 10;
	$pagina = isset($_GET['pos']);
	if(isset($_GET['pos'])){
		$inicio = ($_GET['pos']);
	}else{
		$inicio = 0;
	}
	/* $codigo = $_POST['codigo']; */
	if($contrato == "GENERAL"){
		$conn = conectar_PostgreSQL('postgres', 'semana010411', '127.0.0.1', '5432', 'asesores');
		$sqlcontrato = "SELECT * FROM asesor ";
		$result = pg_query($conn, $sqlcontrato);
	}
	else{
		$conn = conectar_PostgreSQL('postgres', 'semana010411', '127.0.0.1', '5432', 'asesores');
	$sqlcontrato = "SELECT * FROM asesor WHERE estado_contraro = '".$contrato."' AND centro_costos ='".$_SESSION['codigo']."'";
	$result = pg_query($conn, $sqlcontrato);
	}
	
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
	}
	//pg_close($conn);
	$print = 0;
	$conn = conectar_PostgreSQL('postgres', 'semana010411', '127.0.0.1', '5432', 'asesores');
	$sqlcontar = "select * from asesort_temp";
	$res = pg_query($conn, $sqlcontar);
	$contar = pg_num_rows($res);
	for($i = 0; $i <= $contar; $i= $i+20){
		

		?> <a href="" class="btn btn-success" onclick="paginacion_js()?pos=<?php echo $i;?>"><?php echo $print; "</a>";
		$print++;
	}
?>
		</tbody>
</table>