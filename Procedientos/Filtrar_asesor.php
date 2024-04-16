<?php
//REFERENCIA AL FICHERO CONTROLADOR PARA PODER UTILIAR SUS PROCEDIMEINTOS
	require_once("../controlador/conexion.php");
	//DECLARACION VARIABLES
	$doc = $_POST['documento'];
	//CONVERSION DE LOS CARACTERES EN MAYUSCULAS, LOS DATOS DE TIPO STRING EN LA BASE DE DATOS ESTAN AMACENADOS EN MAYUSCULAS
	$documento = strtoupper($doc);
	//VARIABLES PARA LA PAGINACION
	$pagina = $_POST['limite'];
	$total_pagina = 12;
	if($pagina > 0){
		$pagina = $pagina;
	}else{
		$pagina = 0;
	}
	$a = $pagina + 1;
	//VERIFICACION DE QUE LA VARIABLE DE CONDICION CONTENGA DATOS
	if($doc != ""){
		$conn = conectar_PostgreSQL('postgres', 'semana010411', '127.0.0.1', '5432', 'asesores');
		//CONSULTA PARA CONTAR LA CANTIDAD DE REGISTROS QUE TRAERA LA CONSULTA Y CONTROLAR LA PAGINACION
		$sqltotal = "SELECT * FROM asesor WHERE doc_identidad LIKE '".$documento."%' OR nombres LIKE '".$documento."%' OR ape_1 LIKE '".$documento."%' OR ape_2 LIKE '".$documento."%'";
		//SE EJECUTA LA CONSULTA
		$r =  pg_query($conn, $sqltotal);
		//SE CUENTAN LOS REGISTROS TRAIDOS
		$total = pg_num_rows($r);
		//CONSULTA PARA TRAER LOS REGISTROS
		$sqlcentro = "SELECT * FROM asesor WHERE doc_identidad LIKE '".$documento."%' OR nombres LIKE '".$documento."%' OR ape_1 LIKE '".$documento."%' OR ape_2 LIKE '".$documento."%' LIMIT ".$total_pagina." OFFSET ".$pagina."";//select * from asesor where doc_identidad //like '1%'
		//SE EJECUTA LA CONSULTA
		$result = pg_query($conn, $sqlcentro);
		//SE ONTROLA QUE SE MUESTRE ALMENOS UN REGISTRO; DE LO CONTRARIO SE MOSTRARA MENSAJE
		if($total > 0){
	//ESTRUCTURACIONDE LA TABLA DONDE SE MOSTRARA LA CONSULTA
?>
<table class="table table-hover table-striped">
	<thead>
		<tr>
			<th>Registro</th>
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
	//SE RECORRE LAS FILAS TRAIDAS POR LA CONSULTA Y SE ASIGNAN A LA TABLA DONDE SE MOSTRARAN
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
					$res = pg_query($conn, $sqlcentro);
					$r = pg_fetch_array($res);
					?>
					<td><?php echo $fila["centro_costos"]." - ".$r['nombre'];?></td>
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
	if($total > 12){
		if($pagina > 0){
		$limite = $pagina - 12;
		echo "<a class=\"anterior btn btn-success\" onclick=\"buscarAsesor(".$limite.")\">Anterior</a>";
	}else{
		echo "<a class=\"anterior btn btn-success\" onclick=\"\" disabled>Anterior</a>";				
	}
	if($pagina < $total - 12){
		$limite = $pagina + 12;	
		echo "&nbsp;<a class=\"siguiente btn btn-success\" onclick=\"buscarAsesor(".$limite.")\">Siguiente</a>";			
	}else{
		echo "&nbsp;<a class=\"siguiente btn btn-success\" onclick=\"\" disabled>Siguiente</a>";
	}
	}
	
	}else{
		?>
		<h3>NO SE ENCONTRO NINGUN REGISTRO; &nbsp POR FAVOR VERIFIQUE QUE INGRESO BIEN LOS DATOS</h3>
		<?php
	}
	}
?>
		</tbody>
</table>