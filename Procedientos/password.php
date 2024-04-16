<?php 
	require_once('../controlador/conexion.php');
	//TOMO POR EL METOD POST LOS VALORES ENVIADOS EN LA URL
	//CON ESTA VARIABLE SE CONTROLARA EL REGISTRO DESDE EL CUAL SE INICIARA LA CONSULTA
	$pagina =0;/*$_POST['limite']; */
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
	$sqlauditoria = "SELECT estado FROM usuarios";
	//EJECUTO LA CONSULTA A LA BASE DE DATOS
	$resultado = pg_query($conn, $sqlauditoria);
	//DETERMINO CUANTOS REGISTROS TRAERA LA BASE D EDATOS
	$total = pg_num_rows($resultado);
	//DETERMINO CUANTAS PAGINAS SE MOSTRARAN DIVIDIENDO EL NUMERO DE REGISTROS POR EL TAMAÑO D ECADA PAGINA
	//SE USA EL COMANDO ceil PARA APROXIMAR A NUMERO ENTERO
	$paginas = ceil($total / $tamaño_paginas);
	//CONSULTA BASE DE DATOS PARA TRAER LOS REGISTROS QUE SE MOSTRARAN
	if($total > 0){
	$sqlregistros = "SELECT nombreusuario FROM usuarios";
	$resultadoparcial = pg_query($conn, $sqlregistros);
	while($otrafila = pg_fetch_array($resultadoparcial)){
		$usuario = $otrafila["nombreusuario"];
		$sqlusuario = "SELECT password, estado, fecha_modificacion, nombre FROM historial_usuarios WHERE nombreusuario = '".$usuario."' ORDER BY fecha_modificacion LIMIT 1";
		$result = pg_query($conn, $sqlusuario);
	
	//VERIFICACION QUE SI ALLA REGISTROS EN LA COSNULTA REALIZADA
	
?>
		<table class="table table-hover table-striped" >
		<!--ENCABEZADO DE LA TABLA DONDE SE MOSTRARAN LOS REGISTROS-->
			<thead>
				<tr>
					<th>Registro</th>
					<th>Nombre Usuario</th>
					<th>Contraseña</th>
					<th>Estado</th>
				</tr>
			</thead>
				<tbody>
<?php	
			//SE RECORREN LAS FILAS TRAIDAS POR LA CONSULTA
			while($fila = pg_fetch_array($result)){
				if($fila["password"] != ''){
?>
				<tr>
				<!--SE AGISNAN LOS REGISTROS TRAIDOS EN LA CONSULTA A LA TABLA DONDE SE MOSTRARAN-->
					<td><?php echo $registro;?></td>
					<td><?php echo $fila["nombre"];?></td>
					<td><?php echo $usuario;?></td>
					<td><?php echo $fila["password"];?></td>
					<td><?php echo $fila["estado"];?></td>
				</tr>
<?php
				//SE AUMENTA LA VARIABLE REGISTROS PARA CONTROLAR EL CONSECUTIVO
				$registro++;
			}
			}
	}
			//VERIFICACION PARA CONDICIONAR QUE PAGINE SOLO SI EL NUMERO DE REGISTROS ES MAYOR QUE EL TAMAÑO D ELA PAGINA
			if($total > 10){
				if($pagina > 0){
					//VERIFICACION PARA HABILITAR O DESHABILITAR LA PAGINA ANTERIOR
					$limite = $pagina - 10;
					//SE DETERMINA LA URL DEL BOTON SIGUIENTE CON EL PARAMETRO PARA INDICAR EL PRIMER REGISTRO DE LA PAGINA ANTERIRO QUE SOLO ESTARA ACTIVO SI LA PAGINA ACTUAL NO ES LA PRIMERA
					echo "&nbsp;<a class=\"anterior btn btn-success\" onclick=\"passwordactuales(".$limite.")\">Anterior</a>";
				}else{
					//SE MUESTRA EL BOTON ANTERIOR DESHABILITADO EN ESTE MOMENTO SE ESTARA MOSTRANDO LA PRIMER PAGINA
					echo "&nbsp;<a class=\"anterior btn btn-success\" onclick=\"\" disabled>Anterior</a>";
				}
				//VERIFICACION PARA HABILITAR O DESHABILITAR LA PAGINA SIGUIENTE
				if($pagina < $total - 10){
					//ASIGNACION DE EL PRIMER REGISTRO DE LA PAGINA SIGUIENTE
					$limite = $pagina + 10;
					echo "&nbsp;<a class=\"siguiente btn btn-success\" onclick=\"passwordactuales(".$limite.")\">Siguiente</a>";
				}else{
					//BOTON SIGUIENTE DESHABILITADO PUES ESTAREMOS EN LA ULTIMA PAGINA
					echo "&nbsp;<a class=\"siguiente btn btn-success\" onclick=\"\" disabled>Siguiente</a>";
				}	
			
			}
				
			
	}else{
?>
			<h2>NO SE ENCONTRO NINGUNA MODIFICACIÓN A ESTE USUARIO</h2>
<?php
		}
	?>
				</tbody>
</table>