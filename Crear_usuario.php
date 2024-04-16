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
<h2 class="col-md-12 module__header">Crear Usuario</h2>
<form role="form" class="form-horizontal"  name="formulario" id="formulario" class="form-horizontal" method="post" >
	<div class="form-group">
		<label for="doc" class="col-md-2 control-label">Nombre Completo</label>
		<div class="col-md-4">
			<input type="text" class="form-control"  name="NombreCompleto" id="NombreCompleto"  value="" onkeypress="return soloLetras(event)" onchange="BuscarUsuario()"  placeholder="Nombre" autofocus/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-2 control-label">Correo Electronico</label>
		<div class="col-md-3">
			<input type="email" class="form-control"  name="correo" id="correo"  onkeypress="return event.keyCode!=13" value="" onchange="validarCorreo()" placeholder="usuario@correo.com"/>
		</div>
		
	</div>
	<div class="form-group">
		<label class="col-md-2 control-label">Nombre de Usuario</label>
		<div class="col-md-3">
			<input type="text" class="form-control" name="usuario" id="usuario"  onkeypress="return event.keyCode!=13" value="" onchange="usuarioRepetido()" placeholder="Usuario"/>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-2 control-label">contraseña</label>
		<div class="col-md-2">
			<input type="password" class="form-control" name="password" id="password"  onkeypress="return event.keyCode!=13" placeholder="Contraseña"/>
		</div>
		<div class="col-md-2">
			<input type="password" class="form-control" name="confirmar" id="confirmar"  onkeypress="return event.keyCode!=13" value="" onchange="validarPassword()" placeholder="Confirmar	Contraseña"/>
			
			<span class="help-block">Escriba nuevamente la contraseña</span>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-2 control-label">Estado</label>
		<div class="col-md-2">
			<select class="form-control"  name="estado" id="estado"  value="" onkeypress="return event.keyCode!=13">
				<option value="0">- Seleccione -</option>
				<option value="1">ACTIVO</option>
				<option value="2">INACTIVO</option>
			</select>
		</div>
		
		<div class="col-md-2">
			<select class="form-control"  name="rol" id="rol" value="" onkeypress="return event.keyCode!=13">
				<option value="0">- Rol -</option>
				<option value="1">ADMIN</option>
				<option value="2">USUARIO</option>
			</select>
			<span class="help-block">Seleccione el tipo de usuario</span>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-5 col-md-offset-2">
			<input class="btn btn-success" value="Registrar" onclick="crearUsuario()" id="enviar" disabled="true"/>
			<input class="btn btn-success" type="submit" value="Actualizar" id="actualizar" onclick="editarUsuario()" disabled="true"/>
			<input class="btn btn-primary" type="reset" value="Limpiar" id="limpiar" onclick="limpiarUsuario()" disabled="true"/>
			<input class="btn btn-primary" type="button" value="Cancelar" id="cancelar" onclick="cancelarusuario()"/>
		</div>
	</div>
</form>