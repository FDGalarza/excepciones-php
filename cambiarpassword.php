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
<h2 class="col-md-12 module__header">Cambiar Contraseña</h2>
<form role="form" class="form-horizontal"  name="formulario" id="formulario" class="form-horizontal" method="post" >
	<div class="form-group">
		<label class="col-md-2 control-label">Nombre de usuario</label>
		<div class="col-md-4">
			<input type="text" class="form-control"  name="usuario" id="usuario"  onkeypress="return event.keyCode!=13" value="<?php echo $_SESSION['usuario'];?>" onchange="" placeholder="Usuario" readonly />
		</div>
		
	</div>
	<div class="form-group">
		<label class="col-md-2 control-label">contraseña Actual</label>
		<div class="col-md-2">
			<input type="password" class="form-control" id="passwordactual1" onchange="validarcambiopassword()"   placeholder="Contraseña"value="" />
		</div>
		<div class="col-md-2">
			<input type="hidden" class="form-control" id="passwordactual2"  onkeypress="return event.keyCode!=13" placeholder="Contraseña" value="" />
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-2 control-label">contraseña Nueva</label>
		<div class="col-md-2">
			<input type="password" class="form-control" name="password" id="passwordnuevo" onchange="longitudpassword()"  placeholder="Contraseña" readonly />
		</div>
		<div class="col-md-2">
			<input type="password" class="form-control" name="confirmar" id="confirmarnuevo"  onkeypress="return event.keyCode!=13" value="" onchange="comparar()" placeholder="Confirmar" readonly />
			
			<span class="help-block">Confirme su nueva contraseña</span>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-5 col-md-offset-2">
			<input class="btn btn-success" type="submit" value="Actualizar" id="cambiar" onclick="editarcontrasena()" disabled="true"/>
			<input class="btn btn-primary" type="button" value="Cancelar" id="cancelar" onclick="cancelarusuario()"/>
		</div>
	</div>
</form>