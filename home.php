<?php
	session_start();/*
	if(!empty($_SESSION['nombre'])){
		if($_SESSION['rol'] != 1){
			Location: "Inicio_Sesion.php";
			
		}
		
	}else{
		
		header("Location: Inicio_Sesion.php");
	}
		 */
	
?>
<h2 class="col-md-12 module__header"> <?php if(!empty($_SESSION['nombre'])){echo $_SESSION['nombre'] ;}?></h2>