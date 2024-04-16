<?php 
	require_once("../controlador/conexion.php");
	$excepcion = $_POST['excepcion'];
	$tamaño_pagina = 12;
	$pagina = $_POST['limite'];
	if($pagina > 0){
		$pagina = $pagina;
	}else{
		$pagina = 0;
	}
	$a = $pagina + 1;
	$conn = conectar_PostgreSQL('postgres', 'semana010411', '127.0.0.1', '5432', 'asesores');
	$sqlcontar = "SELECT centro_costos FROM centro_tem WHERE excep = '".$excepcion."'";
	$res = pg_query($conn, $sqlcontar);
	$total = pg_num_rows($res);
	$paginas = ceil($total/$tamaño_pagina);
	$sqlexcepcion = "SELECT * FROM centro_tem WHERE excep = '".$excepcion."' LIMIT ".$tamaño_pagina." OFFSET ".$pagina." ";
	$result = pg_query($conn, $sqlexcepcion);
	if($total > 0){
?>
		<table class="table table-hover table-striped">
			<thead>
				<tr >
					<th>registro</th>
					<th>Doc identidad</th>
					<th>Nombres</th>	
					<th>Primer Apellido</th>
					<th>Segundo Apellido</th>
					<th>centro de Costos</th>
					<th>Estado Contrato</th>
					<th >Excepci&oacute;n</th>
				</tr>
			</thead>
				<tbody>
<?php									
				while($fila = pg_fetch_array($result)){
?>
						<tr>
							<td><?php echo $a;?></td>
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
				$a++;
				}
				pg_close($conn);
				if($total > 12){
					if($pagina > 0){
						$limite = $pagina - 12;
						echo "<a class=\"anterior btn btn-success\" onclick=\"AsesorExcepciones(".$limite.")\">Anterior</a>";	
					}else{
						echo "<a class=\"anterior btn btn-success\" onclick=\"\" disabled>Anterior</a>";	
					}
					if($pagina < $total - 12){
						$limite = $pagina + 12;
						echo "&nbsp;<a class=\"siguiente btn btn-success\" onclick=\"AsesorExcepciones(".$limite.")\">Siguiente</a>";
					
					}else{
						echo "&nbsp;<a class=\"siguiente btn btn-success\" onclick=\"\" disabled>Siguiente</a>";
					}
				}
	}else{
		?>
		<h2>NO SE ENCONTRO NINGUN REGISTRO&nbsp CON LA OPCION SELECCIONADA</h2>
		<?php
	}
?>
		</tbody>
</table>