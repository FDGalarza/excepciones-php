<?php 
	//DECLARACION DE SESION INICIADA
	 session_start();
	 //SE LIMPIAN LAS VARRIABLES DE SESION INICIADAS EN EL INICIO DE SESION
	unset($_SESSION["nombre"]); 
	unset($_SESSION["usuario"]);
	unset($_SESSION["rol"]);
	//DESTRUCCION DE LA SESION INICIADA
	session_destroy();	
?>