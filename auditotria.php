<?php
	//SE CONTROLA QUE SI NO SE HA INICIADO SESSION ESTA PAGINA NO S EPUEDA VER SI INGRESAN LA RUTA EN EL NAVEGADOR
	session_start();
	if(!empty($_SESSION['nombre'])){
		if($_SESSION['rol'] != 1){
			//si no se ha iniciado sesion lo redireccioan al la pagina de login
			Location: "Inicio_Sesion.php";
			
		}
		
	}else{
		
		header("Location: Inicio_Sesion.php");
		}
	
?>
<h2 class="col-md-12 module__header">Auditorias</h2>
<div class="col-md-10">
<div class="panel panel-default">
	<div class="panel-heading"><strong><h3>Consultas</h3></strong></div>
	<div class="panel-body form-inline">
		
		<div class="form-group">
			<div class="col-md-4" >
				<label class="col-md-2 control-label"><strong><h4>Colocadores</h4></strong></label>
				<input type="text" class="form-control"name="colocadorauditoria" id="colocadorauditoria"placeholder="Documento" value="" onkeyup="validaNumero(this)" onchange="auditoriacolocadores(0)" required   />
			</div>
		</div>
		<div class="form-group">
			<div class="col-md-4" >
				<label class="col-md-2 control-label"><strong><h4>Usuarios</h4></strong></label>
				<input type="text" class="form-control"name="usuarioauditoria" id="usuarioauditoria"placeholder="Nombre usuario" value="" onkeyup="" onchange="auditoriausuarios(0)" required   />
			</div>
		</div>
	</div>
	</div>
</div>
</div>
<div class="col-md-12 user__logout" id="contenedorTabla">
	
</div>