<?php
	//Se verifiaca si hay alguna sesion iniciada
	if(!empty($_SESSION['nombre'])){
		//si ya hay sesion iniciada se redireccina a la pagina principal del sitio
		header("location:index.php");
	}
?>
<!DOCTYPE HTML>
<html lang="es"> 
<head> 
<meta charset="UTF-8">
	<title>Login</title>
	<link rel="stylesheet" href="css/bootstrap.min.css"/>
	<link rel="stylesheet" href="style.css" />
</head> 
<body style="background-color: #363C47;"> 
<div class="container-login">
	<h2>Excepciones</h2>
	<form role="form" class="form-horizontal"  name="formulario" id="formulario" method="POST" action="">
		<p>
			<div class="input-group" >
				<div class="input-group-addon"><span class="glyphicon glyphicon-user"></span></div>
				<input type="text" class="form-control"  name="usuario" id="usuario" onkeypress="return event.keyCode!=13" onchange="usuariobloqueado()" placeholder="Usuario" autofocus/>
			</div>
		</p>
		<p>
		<div class="input-group">
			<div class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></div>
			<input type="password" class="form-control"  name="password" id="password"  onkeypress="return event.keyCode!=13" placeholder="Contraseña"/>
		</div>
		</p>
		
		<p class="text-center">
			<input class="btn btn-success" type="button" id="aceptar" onclick="autenticar()" value="Aceptar"/>
			<input class="btn btn-primary" type="button" value="Cancelar" onclick="log()"/>
		</p>
	</form>
</div>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/validar.js"></script>
<script type="text/javascript" src="js/ajax.js"></script>
</body> 

</html>