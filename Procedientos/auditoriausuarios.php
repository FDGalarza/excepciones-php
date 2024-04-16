<?php 
	require_once('../controlador/conexion.php');
	//TOMO POR EL METOD POST LOS VALORES ENVIADOS EN LA URL
	$usuario = $_POST['usuario'];
	//SE CONVIERTEN LOS CARACTERES DEL NOMBRE EN MAYUSCULAS
	$nombreusuario = strtoupper($usuario);
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
	$a = $pagina + 1;
	//ABRI CONEXION CON BASE DE DATOS
	$conn = conectar_PostgreSQL('postgres', 'semana010411', '127.0.0.1', '5432', 'asesores');
	//CONSULTA BASE DE DATOS PARA SABER CUANTOS REGISTROS TRAERA LA CONSULTA
	$sqlauditoria = "SELECT rol FROM historial_usuarios WHERE nombreusuario = '".$usuario."' OR nombre = '".$nombreusuario."'";
	//EJECUTO LA CONSULTA A LA BASE DE DATOS
	$resultado = pg_query($conn, $sqlauditoria);
	$rol = pg_query($conn, $sqlauditoria);
	$registro = pg_fetch_array($rol);
	$tipo = $registro["rol"];
	$total;
	if($tipo == 1){
		$sqlcontar = "SELECT * FROM historial_usuarios";
		$contar = pg_query($conn, $sqlcontar);
		$sqlregistros = "SELECT * FROM historial_usuarios ORDER BY rol ASC LIMIT ".$tamaño_paginas." OFFSET ".$pagina."";
		//DETERMINO CUANTOS REGISTROS TRAERA LA BASE D EDATOS
		$total = pg_num_rows($contar);
		//DETERMINO CUANTAS PAGINAS SE MOSTRARAN DIVIDIENDO EL NUMERO DE REGISTROS POR EL TAMAÑO D ECADA PAGINA
		//SE USA EL COMANDO ceil PARA APROXIMAR A NUMERO ENTERO
		$paginas = ceil($total / $tamaño_paginas);
		
	}else{
		//CONSULTA BASE DE DATOS PARA TRAER LOS REGISTROS QUE SE MOSTRARAN
		$sqlregistros = "SELECT * FROM historial_usuarios WHERE nombreusuario = '".$usuario."' OR nombre = '".$usuario."'";
		$sqlcontar = pg_query($conn, $sqlregistros);
		$total = pg_num_rows($sqlcontar);
		//DETERMINO CUANTAS PAGINAS SE MOSTRARAN DIVIDIENDO EL NUMERO DE REGISTROS POR EL TAMAÑO D ECADA PAGINA
		//SE USA EL COMANDO ceil PARA APROXIMAR A NUMERO ENTERO
		$paginas = ceil($total / $tamaño_paginas);
	}
	$result = pg_query($conn, $sqlregistros);
	
	//VERIFICACION QUE SI ALLA REGISTROS EN LA COSNULTA REALIZADA
	if($total > 0){
?>
		<table class="table table-hover table-striped" >
		<!--ENCABEZADO DE LA TABLA DONDE SE MOSTRARAN LOS REGISTROS-->
			<thead>
				<tr>
					<th>Registro</th>
					<th>Nombre Completo</th>
					<th>Nombre Usuario</th>
					<th>Password</th>
					<th>Tipo Usuario</th>
					<th>Estado</th>
					<th>Fecha modificai&oacute;n</th>
					<th>Modificado Por</th>
				</tr>
			</thead>
				<tbody>
<?php	
			//SE RECORREN LAS FILAS TRAIDAS POR LA CONSULTA
			while($fila = pg_fetch_array($result)){
				
?>
			
				<tr>
				<!--SE AGISNAN LOS REGISTROS TRAIDOS EN LA CONSULTA A LA TABLA DONDE SE MOSTRARAN-->
					<td><?php echo $a;?></td>
					<td><?php echo $fila["nombre"];?></td>
					<td><?php echo $fila["nombreusuario"];?></td>
					<td><?php echo "PENDIENETE";?></td>
					<td><?php if($fila["rol"] == 1){echo "ADMINISTRADOR";}else{echo "INVITADO";}?></td>
					
<?php
					if($fila["estado"] == 1){
?>						
					<td><?php echo "ACTIVO";?></td>
<?php
					}else{
?>
					<td><?php echo "INACTIVO";}?></td>
					<td><?php echo $fila["fecha_modificacion"];?></td>
					<td><?php echo $fila["modificado_por"];?></td>
				</tr>
<?php
				//SE AUMENTA LA VARIABLE REGISTROS PARA CONTROLAR EL CONSECUTIVO
				$a++;
			}
			//VERIFICACION PARA CONDICIONAR QUE PAGINE SOLO SI EL NUMERO DE REGISTROS ES MAYOR QUE EL TAMAÑO D ELA PAGINA
			if($total > 10){
				if($pagina > 0){
					//VERIFICACION PARA HABILITAR O DESHABILITAR LA PAGINA ANTERIOR
					$limite = $pagina - 10;
					//SE DETERMINA LA URL DEL BOTON SIGUIENTE CON EL PARAMETRO PARA INDICAR EL PRIMER REGISTRO DE LA PAGINA ANTERIRO QUE SOLO ESTARA ACTIVO SI LA PAGINA ACTUAL NO ES LA PRIMERA
					echo "&nbsp;<a class=\"anterior btn btn-success\" onclick=\"auditoriausuarios(".$limite.")\">Anterior</a>";
				}else{
					//SE MUESTRA EL BOTON ANTERIOR DESHABILITADO EN ESTE MOMENTO SE ESTARA MOSTRANDO LA PRIMER PAGINA
					echo "&nbsp;<a class=\"anterior btn btn-success\" onclick=\"\" disabled>Anterior</a>";
				}
				//VERIFICACION PARA HABILITAR O DESHABILITAR LA PAGINA SIGUIENTE
				if($pagina < $total - 10){
					//ASIGNACION DE EL PRIMER REGISTRO DE LA PAGINA SIGUIENTE
					$limite = $pagina + 10;
					echo "&nbsp;<a class=\"siguiente btn btn-success\" onclick=\"auditoriausuarios(".$limite.")\">Siguiente</a>";
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