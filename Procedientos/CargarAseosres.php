<?php
//REFERENCIA A EL FICHERO CONTROLADOR
require_once("../controlador/conexion.php");
//DECLARACION DE VARIABLES
	$documento = $_POST['documento'];
	//CONEXION CON BASE DE DATOS
	$conn = conectar_PostgreSQL('postgres', 'semana010411', '127.0.0.1', '5432', 'asesores');
	$sqlcentro = "SELECT * FROM asesor ";//select * from asesor where doc_identidad like '1%'
	
	$result = pg_query($conn, $sqlcentro);
?>
<table class="table table-stripped">
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
	while($fila = pg_fetch_array($result)){
?>
				<tr>
					<td><?php echo $fila["doc_identidad"];?></td>
					<td><?php echo $fila["nombres"];?></td>
					<td><?php echo $fila["ape_1"];?></td>
					<td><?php echo $fila["ape_2"];?></td>
					<td><?php echo $fila["centro_costos"];?></td>
					<td><?php echo $fila["estado_contraro"];?></td>
					<td><?php echo $fila["excep"];?></td>
				</tr>
<?php
	}
	pg_close($conn);
?>
		</tbody>
</table>