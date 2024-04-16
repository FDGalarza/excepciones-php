<?php
	session_start();
	$_SESSION['nombre'] = "FABRICIO"
	if(!empty($_SESSION['nombre'])){
		if($_SESSION['rol'] != 1){
			Location: "Inicio_Sesion.php";
			
		}
		
	}else{
		
		header("Location: Inicio_Sesion.php");
	}
		
	
?>
<!DOCTYPE HTML>
<html lang="es">
	<meta charset="UTF-8">
	<title>Excepciones de Colocadores</title>
	<link rel="stylesheet" href="css/bootstrap.min.css"/>
	<link rel="stylesheet" href="style.css" />
</head>
<body>
<div class="container-fluid">
<div class="row">
	<section class="col-xs-3 col-sm-3 col-md-2 col-lg-2 sidebar">
		<header class="header row">
			<p><span class="glyphicon glyphicon-book"></span>&nbsp;&nbsp;&nbsp;Excepciones</p>
		</header>
		<div class="user">
			<img src="img/user.jpg" alt="" class="user__thumbnail"/>
			<p class="user__displayname"><?php echo $_SESSION['nombre'];?></p>
			<a href="" class="user__logout btn btn-sm btn-success" onclick="logout(this)">Cerrar sesión</a>
			<br>
			<a href="" onclick="loadModule('#content','cambiarpassword.php')" >Cambiar Contraseña</a>
			
		</div>
		<nav class="menu-container row">
			<ul class="menu" >
				<li class="menu-item"><a href="" onclick="loadModule('#content','home.php')" ><span class="glyphicon glyphicon-home"></span>Inicio</a></li>
				<li class="menu-item"><a href="" onclick="loadModule('#content','registro_colocadores.php')"><span class="glyphicon glyphicon-plus-sign"></span>Registro</a></li>
				<li class="menu-item"><a href="" onclick="loadModule('#content','edicion_colocadores.php')"><span class="glyphicon glyphicon-pencil"></span>Edición</a></li>
				<li class="menu-item"><a href="" onclick="loadModule('#content','consultas.php')"><span class="glyphicon glyphicon-search"></span>Consultas</a></li>
				<li class="menu-item"><a href="" onclick="loadModule('#content','reportes.php')"><span class="glyphicon glyphicon-file"></span>Reportes</a></li>
				
			</ul>
		</nav>
	</section>