<?php 
//CONESTA FUSNION SE CONTROLA QUE EN EL CAMBIO DE CONTRASEÑA POR PARTE DEL USUSARIO SEA EL USUARIO CONRRECTO QUIEN CAMBIARA LA CONTRASEÑA
	//REFERENCIA DEL FICHERO CONTROLADOR
	require_once('../controlador/conexion.php');
	//DECLARACION DE LAS VARIABLES Y SE LE ASIGNAN LAS CONTRASEÑAS QUE SE COMPARARAN
	$pass1 = $_POST['password1'];
	$pass2 = $_POST['password2'];
	//SE ENCRIPTA LA CONTRASEÑA INGRESADA POR EL SUSARIO
	$password = sha1($pass1);/* sha1($pass); */
	//SE COMPARAN CONTRASEÑAS, LA DE LA BASE DE DATOS CON LA INGRESADA POR EL USUARIO EN EL MOMENTO DEL CAMBIO
	if($password == $pass2){
		//SE ENVIA ESTE VALOR INDICANDO CONTRASEÑAS IGUALES
		echo 10;
	}else{
		//SE ENVIA ESTE VALOR INDICANDO CONTRAQSEÑAS INCORRECTAS
		echo $password."   ".$pass1;
	}
?>