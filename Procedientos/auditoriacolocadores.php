<?php 
	require_once('../controlador/conexion.php');
	//TOMO POR EL METOD POST LOS VALORES ENVIADOS EN LA URL
	$colocador = $_POST['colocador'];
	//CON ESTA VARIABLE SE CONTROLARA EL REGISTRO DESDE EL CUAL SE INICIARA LA CONSULTA
	$pagina =$_POST['limite'];
	/* $consecutivo = $_POST['consecutivo']; */
	//DETERMINO EL NUMERO MAXIMO DE REGISTROS POR PAGINA
	$tamaño_paginas = 10;
	//VERIFICO EL VALOR DEL PRIMER REGISTRO QUE SE MOSTRARA
	if($pagina > 0){
		//SI LA PAGIAN NO ES LA PRIMERA ASIGNO A LA VARIABLE DEL LIMITE EL VALOR DEL REGISTRO PARA INICIAR LA CONSULTA
		$pagina = $pagina;
	}else{
		//SI ES LA PRIMER PAGINA LE ASIGNO A LA VARIABLE LIMITE EL VALOR CERO
		$pagina = 0;
	}
	//VARIABLE PARA ENUMERAR LOS REGISTROS, SE ASIGNA EL VALOR DEL ULTIMO REGISTRO MOSTRADO EN LA PAGINA 
	//ANTERIOR MAS UNO PUE3S ESE SERA EL PRIMER REGISTRO QUE SE MOSTRARA EN ESTA PAGINA
	$registro = $pagina + 1;
	//ABRI CONEXION CON BASE DE DATOS
	$conn = conectar_PostgreSQL('postgres', 'semana010411', '127.0.0.1', '5432', 'asesores');
	//CONSULTA BASE DE DATOS PARA SABER CUANTOS REGISTROS TRAERA LA CONSULTA
	$sqlauditoria = "SELECT doc_identidad FROM historiar WHERE doc_identidad = '".$colocador."'";
	//EJECUTO LA CONSULTA A LA BASE DE DATOS
	$resultado = pg_query($conn, $sqlauditoria);
	//DETERMINO CUANTOS REGISTROS TRAERA LA BASE D EDATOS
	$total = pg_num_rows($resultado);
	//DETERMINO CUANTAS PAGINAS SE MOSTRARAN DIVIDIENDO EL NUMERO DE REGISTROS POR EL TAMAÑO D ECADA PAGINA
	//SE USA EL COMANDO ceil PARA APROXIMAR A NUMERO ENTERO
	$paginas = ceil($total / $tamaño_paginas);
	//CONSULTA BASE DE DATOS PARA TRAER LOS REGISTROS QUE SE MOSTRARAN
	$sqlregistros = "SELECT * FROM historiar WHERE doc_identidad = '".$colocador."' ORDER BY fecha_modificacion DESC LIMIT ".$tamaño_paginas." OFFSET ".$pagina." ";
	$result = pg_query($conn, $sqlregistros);
	//VERIFICACION QUE SI ALLA REGISTROS EN LA COSNULTA REALIZADA
	if($total > 0){
?>
		<table class="table table-hover table-striped" >
		<!--ENCABEZADO DE LA TABLA DONDE SE MOSTRARAN LOS REGISTROS-->
			<thead>
				<tr>
					<th>Registro</th>
					<th>Doc identidad</th>
					<th>centro de Costos</th>
					<th>Estado Contrato</th>
					<th>Excepci&oacute;n</th>
					<th>Fecha de modificacion</th>
					<th>Modificado POR</th>
				</tr>
			</thead>
				<tbody>
<?php	
			//SE RECORREN LAS FILAS TRAIDAS POR LA CONSULTA
			while($fila = pg_fetch_array($result)){
?>
				<tr>
				<!--SE AGISNAN LOS REGISTROS TRAIDOS EN LA CONSULTA A LA TABLA DONDE SE MOSTRARAN-->
					<td><?php echo $registro;?></td>
					<td><?php echo $fila["doc_identidad"];?></td>
<?php
					$sqlcentro = "SELECT nombre FROM centro_costos WHERE codigo = '".$fila['centro_costos']."'";
					$r = pg_query($conn, $sqlcentro);
					$f = pg_fetch_array($r);
					$Ncentro = $f['nombre'];
?>
					<td><?php echo $fila["centro_costos"]." - ".$Ncentro;?></td>
					<td><?php echo $fila["contrato"];?></td>
					<td><?php echo $fila["excepcion"];?></td>
					<td><?php echo $fila["fecha_modificacion"];?></td>
					<td><?php echo $fila["usuario_modificacion"];?></td>
					
				</tr>
<?php
				//SE AUMENTA LA VARIABLE REGISTROS PARA CONTROLAR EL CONSECUTIVO
				$registro++;
			}
			//VERIFICACION PARA CONDICIONAR QUE PAGINE SOLO SI EL NUMERO DE REGISTROS ES MAYOR QUE EL TAMAÑO D ELA PAGINA
			if($total > 10){
				if($pagina > 0){
					//VERIFICACION PARA HABILITAR O DESHABILITAR LA PAGINA ANTERIOR
					$limite = $pagina - 10;
					//SE DETERMINA LA URL DEL BOTON SIGUIENTE CON EL PARAMETRO PARA INDICAR EL PRIMER REGISTRO DE LA PAGINA ANTERIRO QUE SOLO ESTARA ACTIVO SI LA PAGINA ACTUAL NO ES LA PRIMERA
					echo "&nbsp;<a class=\"anterior btn btn-success\" onclick=\"auditoriacolocadores(".$limite.")\">Anterior</a>";
				}else{
					//SE MUESTRA EL BOTON ANTERIOR DESHABILITADO EN ESTE MOMENTO SE ESTARA MOSTRANDO LA PRIMER PAGINA
					echo "&nbsp;<a class=\"anterior btn btn-success\" onclick=\"\" disabled>Anterior</a>";
				}
				//VERIFICACION PARA HABILITAR O DESHABILITAR LA PAGINA SIGUIENTE
				if($pagina < $total - 10){
					//ASIGNACION DE EL PRIMER REGISTRO DE LA PAGINA SIGUIENTE
					$limite = $pagina + 10;
					echo "&nbsp;<a class=\"siguiente btn btn-success\" onclick=\"auditoriacolocadores(".$limite.")\">Siguiente</a>";
				}else{
					//BOTON SIGUIENTE DESHABILITADO PUES ESTAREMOS EN LA ULTIMA PAGINA
					echo "&nbsp;<a class=\"siguiente btn btn-success\" onclick=\"\" disabled>Siguiente</a>";
				}	
			}
				
			
	}else{
		//CONSULTA LA BASE DE DATOS PARA CONFIRMAR QUE EL ASEOSR BUSCADO SI EXISTA
		$sqlasesor = "SELECT nombres, ape_1, ape_2 FROM asesor WHERE doc_identidad = '".$colocador."'";
		$res = pg_query($conn, $sqlasesor);
		$fil = pg_fetch_array($res);
		//VERIFICO LA EXIXTENCIA DEL ASEOSR BUSCADO
		if(pg_num_rows($res) > 0){
		//SI EL ASEOSR SI EXIXTE PERO NO HAY MODIFICACIONES RECIENTES SALE UN MENSAJE CONFIRMANDO QEU EXISTE PARE NO HAY MODIFICACIONES
?>
		<h2>AL ASESOR &nbsp;<strong><?php echo $fil["nombres"]." ".$fil["ape_1"]." ".$fil["ape_2"];?> </strong>SE ENCONTRO REGISTRADO PERO NO SE ENCONTRARON MODIFICAIONES REALIZADAS A LA INFORMACION REGISTRADA EN LA BASE DE DATOS</h2>
<?php
		}else{
			//SI EL ASESOR BUISCADO NO EXISTE SALE MENSAJE CONFIRMANDO QUE EL REGISTRO NO EXISTE
?>
			<h2>NO SE ENCONTRO NINGUN ASESOR CON ESTE DOCUMENTO DE IDENTIDAD VERIFIQUE LA INFORMACION INGRESADA</h2>
<?php
		}
	}
	?>
				</tbody>
</table>