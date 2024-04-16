<?php 
	//FUNSION PARA CONSULTAR LOS ASESORES POR CENTRO DE COSTO
	//REFERENCIA AL ARCHIVO CONTROLADOR
	require_once("../controlador/conexion.php");
	//DECLARACION DE VARIABLES Y ASIGNACION DE VALORES POR EL METODO POST
	$codigo = $_POST['codigo'];
	session_start();
	//MAXIMO DE REGISTROS QUE SE MOSTRARAN EN UNA PAGINA
	$tamaño_pagina = 12;
	//RE RECOGE EL VALOR DE LA URL PARA ASIGNAR EL LIMITE DE LA CONULTA
	$pagina = $_POST['limite'];
	//VERIFICAION VALOR DE LA VARIABLE DEL LIMITE
	if($pagina > 0){
		//SI TRAE ALGUN VALOR SE QUEDA CON ESE VALOR
		$pagina = $pagina;
	}else{
		//SI NO TRAE NINGUN VALOR SE LE ASIGNA EL VALOR CERO QUE SERA EL PRIMER REGISTRO QUE S EMOSTRARA
		$pagina = 0;
	}
	//VARIABLE PARA EL CONSECUTIVO DE LOS REGISTROS TRAIDOS EN LA CONSULTA
	$a  = $pagina + 1;
	//CONEXION CON LA BASE DE DATOS
	$conn = conectar_PostgreSQL('postgres', 'semana010411', '127.0.0.1', '5432', 'asesores');
	//SE VERIFICA EL CENTRO DE COSTOS SOLICITADO; SI EL VALOR MANDADO ES APUESTAS AZAR SE HACE UNA CONSULTA GENERAL
	if($codigo != "APUESTAS AZAR S.A"){
		//CONSULTA A BASE DE DATOS LOS ASEOSRES DEL CENTRO DE COSNTO INIDCADO POR EL USUARIO
		$sqlcontar = " SELECT centro_costos FROM asesor WHERE centro_costos = '".$codigo."'";
		//SE EJECUTA LA CONSULTA
		$res = pg_query($conn, $sqlcontar);
		//SE CUENTAN LOS REGISTROS TRAIDOS EN LA CONSULTA
		$total = pg_num_rows($res);
		//SE BORRA LA TABLA TEMPORAL CREADA EN UNA CONSULTA REALIZADAANTEIROMENTE
		$sqlborrar = "DROP TABLE centro_tem";
		//SE EJECUTA LA CONSULTA BNORRAR
		$borrar = pg_query($conn, $sqlborrar);
		//SE CREA UNA TABLA TEMPORAL EN LA BASE DE DATOS Y SE LE ASIGNAN LOS REGISTORS DE LA CONSULTA PARA DESPUES CONSULTAR SOLO EN ESTA TABLA
		$sqlcrear = "CREATE TABLE centro_tem AS SELECT * FROM asesor WHERE centro_costos = '".$codigo."'";
		//SE EJECUTA LA COSNULTA DE CREAR LA TABLA TEMPORAL
		$crear = pg_query($conn, $sqlcrear);
		//SE DETERMINA CUANTAS PAGINAS SE MOSTRARAN EN LA CONSULTA APROXIMA POR ENCIMA
		$paginas = ceil($total/$tamaño_pagina);
		//SE REALIZA LA CONSULTA QUE SE DESEA MOSTRAR; ESTA CONSULTA SE HACE A LA TABLA TEMPORAL CREADA
		$sqlcentro = "SELECT * FROM asesor WHERE centro_costos = '".$codigo."' LIMIT ".$tamaño_pagina." OFFSET ".$pagina."";
	}else{
		//ACA SE HACE UNA CONSULTA DE TODOS LOS ASESORES DE LA EMPRESA
		//SE CUENTAN LOS REGISTROS QUE SE TRAERAN EN LA CONSULTA
		$sqlcontar = " SELECT centro_costos FROM asesor";
		//SE EJCUTA LA CONSULTA PARA CONTAR LOS REGISTROS
		$res = pg_query($conn, $sqlcontar);
		//SE CUENTAN LOS REGISTROS DE LA COSNLTA
		$total = pg_num_rows($res);
		//SE BORRA LA TABLA TEMPORAL  QUE SE HAYA CREADO EN UNA CONSULTA REALIZADA ENATERIORMENTE
		$sqlborrar = "DROP TABLE centro_tem";
		//SE EJECUTA LA CONSULTA DE BORRAR LA TABLA TEMPORAL
		$borrar = pg_query($conn, $sqlborrar);
		//SE CREA NUEVAMENTE LA TABLA TEMPORAL CON LA COSNULTA ACTUAL
		$sqlcrear = "CREATE TABLE centro_tem AS SELECT * FROM asesor";
		//SE EJECTUA LA CONSULTA CREAR LA TABLA TEMPORAL
		$crear = pg_query($conn, $sqlcrear);
		//SE DETERMINA CUANTAS PAGINAS SE MOSTRARAN EN LA CONSULTA APROXIMA POR ENCIMA
		$paginas = ceil($total/$tamaño_pagina);
		//SE REALIZA LA CONSULTA QUE SE DESEA MOSTRAR; ESTA CONSULTA SE HACE A LA TABLA TEMPORAL CREADA
		$sqlcentro = "SELECT * FROM asesor LIMIT ".$tamaño_pagina." OFFSET ".$pagina."";
	}
	//SE EJECUTA LA CONSULTA MANDADA DE LAVERIFICACION DEL CENTRO D ECOSTOS
	$result = pg_query($conn, $sqlcentro);
	//SE VERIFICA QUE SE MUESTRE LA TABLA SOLO SI SE MOSTRARA ALGUN REGISTRO
	if($total > 0){
?>
		<!--ENCABEZADO DE LA TABLA-->
		<table class="table table-hover table-striped">
			<thead>
				<tr>
					<th>Rergistro</th>
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
				//SE RECORREN EL RESULTADO DE LA CONSULTA
				while($fila = pg_fetch_array($result)){
?>
					<!--SE ASIGANA A LA TABLA LOS REGISTROS TRAIDOS EN LA CONSULTA-->
					<tr>
						<td><?php echo $a;?></td>
						<td><?php echo $fila["doc_identidad"];?></td>
						<td><?php echo $fila["nombres"];?></td>
						<td><?php echo $fila["ape_1"];?></td>
						<td><?php echo $fila["ape_2"];?></td>
						<?php
						//SE HACE UNA COSNULTA A LA TABLA CENTRO DE COSNTOS PARA TRAER EL NOMBRE DEL CODIGO TRAIDO EN LA CONSULTA
						$sqlcentro = "SELECT nombre FROM centro_costos WHERE codigo = '".$fila['centro_costos']."'";
						//SE EJECUTA LA CONSULTA
						$res = pg_query($conn, $sqlcentro);
						//ASIGANCION DEL RESULTADO DE LA CONSULTA A LA TABLA CENTRO COSTOS
						$r = pg_fetch_array($res);
						?>
						<!--SE MUESTRA EL CODIGO Y EL NOMBRE DEL CENTRO DE COSTOS-->
						<td><?php echo $fila["centro_costos"]." - ".$r['nombre'];?></td>
						<td><?php echo $fila["estado_contraro"];?></td>
<?php
						//SE VERIFICA EL VALOR DE EXCEPCION EN LA BASE DE DATOS PARA MOSTRAR LA OPCION INDICADA
						if($fila["excep"] == 1){
?>
						<!--SI LE VALOR TRAIDO ES 1 SE MUESTRA "SI"-->
						<td><?php echo "SI";}else{?></td>
						<!--SI EL VALOR ES 2 MOSTRAMOS "NO"-->
						<td><?php echo "NO";}?></td>

					</tr>
<?php
					$a++;
					}
					//CONTRROLAMOS LA PAGIANCION
					if($total > 12){
						//SI TOTAL DE REGISTROS MAYO QUE EL NUMERO DE REGISTROS POR PAGIAN SE REALIZA LA PAGIANCION
						if($pagina > 0){
							//LA VARIABLE $pagina CONTROLA CUAL SERA EL PRIMER REGISTROQ UE SE MOSTRARA
							//SI EL REGISTRO ES DIFERENTE DE CERO INDICA QUE NO ES LA PRIMER PAGIAN, POR LO TANTO SE MUESTRA EL LINK PARA LA PAGINA ANTERIOR
							$limite = $pagina - 12;
							echo "<a class=\"anterior btn btn-success\" onclick=\"AsesorCentroCostos(".$limite.")\">Anterior</a>";	
						}else{
							echo "<a class=\"anterior btn btn-success\" onclick=\"\" disabled>Anterior</a>";
							
						}
						if($pagina < $total - 12){
							//SI EL PRIMER REGTISTRO ESTA ENTRE EL ULTIMO Y EL PRIMERO D ELA SEGUNDA PAGINA SE MOSTRARA EL LINK SIGUIENTE
							$limite = $pagina + 12;
							echo "&nbsp;<a class=\"siguiente btn btn-success\" onclick=\"AsesorCentroCostos(".$limite.")\">Siguiente</a>";
							
						}else{
							echo "&nbsp;<a class=\"siguiente btn btn-success\" onclick=\"\" disabled>Siguiente</a>";
						}
					}
	}else{
		//NO SE ENCONTRARON REGISTROS CON LOS PARAMETROS MANDADOS POR EL USUARIO
		$sqlcentro = "SELECT nombre FROM centro_costos WHERE codigo ='".$codigo."'";
		$res = pg_query($conn, $sqlcentro);
		$fila = pg_fetch_array($res);
		?>
		<!--SE MUESTRA ESTE MENSJE PARA INDICAR QUE NO HAY REGISTROS-->
		<h2>NO SE ENCONTRO NINGUN ASESOR&nbsp;QUE PERTENEZCA Al CENTRO DE COSTO&nbsp;<strong><?php echo $codigo." - ".$fila['nombre'];?></strong></h2>
		<?php
	}
	pg_close($conn);
?>
		</tbody>
</table>