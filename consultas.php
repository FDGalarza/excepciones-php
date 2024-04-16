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
<h2 class="col-md-12 module__header">Consultas</h2>
<div class="col-md-12">
<div class="panel panel-default">
	<div class="panel-heading">Filtros independientes</div>
	<div class="panel-body form-inline">
		<div class=" form-group">
		<label>Excepción: </label>
		<select class="form-control"  id="Excepcion" name="Excepcion" onchange="AsesorExcepciones(0)" disabled="true">
			<option>- Excepción -</option>
			<option value="1">SI</option>
			<option value="2">NO</strong></option>
		</select>
		</div>
		<div class=" form-group">
		<label>Centro de costo: </label>
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
		<select class="form-control" name="codigo" id="codigo" onchange="AsesorCentroCostos(0)" required>
			<option value="">- Centro de costo -</option>
			<option value="APUESTAS AZAR S.A">APUESTAS AZAR S.A</option>
			<?php
			while($fila = pg_fetch_array($result)){
			?>
			<option value=<?php echo $fila["codigo"];?>><?php echo $fila["codigo"]." - ".$fila["nombre"];}pg_close($conn);?></option>
		</select>
		</div>
		<div class=" form-group">
		<label>Estado contrato: </label>
		<select class="form-control" id="contrato" name="contrato" onchange="paginacion_js(0)" disabled="true">
			<option>- Estado contrato -</option>
			<option>GENERAL</option>
			<option>ACTIVO</option>
			<option>INACTIVO</option>
		</select>
		</div>
		<div class=" form-group">
			<label>Colocador: </label>
			<input type="text" class="form-control" placeholder="Documento, nombres o apellidos" name="doc" id="doc" onkeyup="buscarAsesor(0)"  placeholder="Ingrese informacion"/>
			
		</div>
	</div>
</div>
</div>
<div class="col-md-12 user__logout" id="contenedorTabla">
	
</div>