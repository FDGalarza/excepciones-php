<?php 
	//REFERENCIA AL EL FICHERO CONTROLADOR QUE CONTIENE LA FUNSION DE CONEXION CON LA BASE DE DATOS
	require_once("../controlador/conexion.php");
	//SE DECLARAN VAIABLES ASIGANDOLE LOS VALORES RECIBIDOS POR EL METODO POST
	$codigo = $_POST['codigo'];
	//CONEXION CON LA BASE DE DATOS
	$conn = conectar_PostgreSQL('postgres', 'semana010411', '127.0.0.1', '5432', 'asesores');
	//CONSULTA A LA BASE DE DATOS
	$sqlcentro = "SELECT * FROM asesor WHERE centro_costos = '".$codigo."'";
	//SE EJECUTA LA CONSULTA SE PASAN COMO PARAMETROS LA VARIABLE CONEXION Y LA VARIABLE QUE CONTIENE LA CONSULTA
	$result = pg_query($conn, $sqlcentro);
	
?>
<!--SE CREA EL ENCABEZADO DE LA TABLA EN LA QUE SE MOSTRARA LA CONSULTA-->
<table class="table table-stripped">
	<thead>
		<tr>
			<th>Doc identidad</th>
			<th>Nombres</th>
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
	//SE EMPIEZA A ASIGNAR A LA TABLA LOS REGISTROS TRAIDOS EN LA CONSULTA
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
	//SE CIERRA LA CONEXION A LA BASE DE DATOS
	pg_close($conn);
?>
		</tbody>
</table>