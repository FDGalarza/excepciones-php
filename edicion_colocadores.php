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
<h2 class="col-md-12 module__header">Edición de colocadores</h2>
<form role="form" class="form-horizontal"  name="formulario" id="formulario" class="form-horizontal" method="post" >
	<div class="form-group">
		<label for="doc" class="col-md-2 control-label">Documento</label>
		<div class="col-md-4">
			<input type="text" class="form-control"  name="doc" id="doc"   onkeyup="validaNumero(this)" onchange="consultarAsesor()" placeholder="Documento de identidad" autofocus/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-2 control-label">Nombres</label>
		<div class="col-md-4">
			<input type="text" class="form-control"  name="nombres" id="nombres"  onchange="controlaredicion()" onkeypress="return soloLetras(event)" placeholder="Si tiene dos nombres,  por favor ingreselos"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-2 control-label">Apellidos</label>
		<div class="col-md-2">
			<input type="text" class="form-control" name="Apellido1" id="apellido1"  onchange="controlaredicion()" onkeypress="return soloLetras(event)" placeholder="Primer Apellido"/>
		</div>
		<div class="col-md-2">
			<input type="text" class="form-control" name="Apellido2" id="apellido2"  onchange="controlaredicion()" onkeypress="return soloLetras(event)" placeholder="Segundo Apellido"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-2 control-label">Centro de costo</label>
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
			<select class="form-control"  name="codigo"   id="codigo" onchange="controlaredicion()" required>
				<option  value="0">- Seleccione -</option>
				<?php while($fila = pg_fetch_array($result)){?>	
				<option value="<?php echo $fila["codigo"];?>"><?php echo $fila["codigo"]." - ".$fila["nombre"];?></option>
				<?php };pg_close($conn);?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-2 control-label">Estado contrato</label>
		<div class="col-md-3">
			<select class="form-control"  name="contrato" id="contrato" onchange="controlaredicion()">
				<option value="0">- Seleccione -</option>			 
				<option value="ACTIVO">ACTIVO</option>
				<option value="INACTIVO">INACTIVO</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-2 control-label">Excepción</label>
		<div class="col-md-3">
			<select class="form-control" name="excepcion" id="excepcion" onchange="controlaredicion()" required>
				<option value="0">- Seleccione -</option>
				<option value="1">SI</option>
				<option value="2">NO</option>
			</select>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-5 col-md-offset-2">
			<input class="btn btn-success" id="actualizar" type="submit" value="Actualizar" onclick="EditarRegistro()" disabled="true"/>
			<input class="btn btn-primary" type="reset" id="limpiar" value="Limpiar" onclick="limpiaredicioncolocadores()" disabled="true"/>
			<input class="btn btn-primary" type="button" value="Cancelar" id="cancelar" onclick="cancelarEGISTRO()"/>
		</div>
	</div>
</form>