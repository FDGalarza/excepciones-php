<?php
	session_start();
	if(!empty($_SESSION['nombre'])){
		if($_SESSION['rol'] != 1){
			Location: "Inicio_Sesion.php";
			
		}
		
	}else{
		
		header("Location: Inicio_Sesion.php");
		}
		
	
?>
<h2 class="col-md-12 module__header">Reportes</h2>
<form class="form-horizontal" role="form" action="reporte1.php" method="POST" id="formulario" target="_blank">
	<div class="form-group">

		<label for="" class="col-md-2 control-label">Centro de costo</label>
		<div class="col-md-3">
		 <?php
		require_once("controlador/conexion.php");
		$conn = conectar_PostgreSQL('postgres', 'semana010411', '127.0.0.1', '5432', 'asesores');
		if($conn){
		$consulta = "SELECT codigo, nombre FROM centro_costos ORDER BY codigo ASC";
		$result = pg_query($conn, $consulta);
		}
		else{
			echo "No existe conexion a la base de datos";
		}
		?>		
			<select name="codigo"  id="centro" class="form-control" onchange="enable()">
				<option value="">- Seleccione -</option>
				<option value="Apuestas AZAR S.A">Apuestas AZAR S.A</option>
				<?php
			while($fila = pg_fetch_array($result)){
			?>
			<option value=<?php echo $fila["codigo"];?>><?php echo $fila["codigo"]." - ".$fila["nombre"];}pg_close($conn);?></option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label for="doc" class="col-md-2 control-label">Estado de contrato</label>
		<div class="col-md-3">
		
			<select name="contrato" id="contrato" class="form-control">
			<option>- Seleccione -</option>
				<option>GENERAL</option>
				<option>ACTIVO</option>
				<option>INACTIVO</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-2 control-label">Tipo de reporte</label>
		<div class="col-md-2">
			<select name="pdf" id="tipo" class="form-control">
				<option value="3">- Seleccione -</option>
				<option value="1">PDF</option>
				<option value="0">XLS</option>
			</select>
			
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-5 col-md-offset-2">
			<input class="btn btn-success" id="reporte" onclick="formulario.submit()" value="Generar"/>
		</div>
	</div>
</form>