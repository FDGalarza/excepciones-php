<?php
//FUNSION PARA INSERTAR LOS DATOS DE LA CREACION DE USUARIO
//REFERENCIA AL ARCHIVO CONTROLADOR
require_once('../controlador/conexion.php');
	//DECLARACION DE VARIABLES Y ADSIGNACION DE VALORES POR EL METODO POST
	$nombre1 = $_POST['nombreCompleto'];
	$correo = $_POST['correo'];
	$usuario = $_POST['nombreUsuario'];
	$pass = $_POST['password'];
	$estado = $_POST['estado'];
	$tipo = $_POST['tipo'];
	//SE CONVIERTEN LOS CARACTERES DEL NOMBRE EN MAYUSCULAS
	$nombre = strtoupper($nombre1);
		//SE ENCRIPTA LA CONTRASEÑA 
        $passw=sha1($pass);
		$conn = conectar_PostgreSQL('postgres', 'semana010411', '127.0.0.1', '5432', 'asesores');
		//VERIFICACION DE CAMPOS VACIOS
 if($estado == ''){
	   echo 15;
 }else{
   if($tipo == ''){
	   echo 15;
   }else{
	   if($nombre == ''){
		echo 15;
	}else{
		if($correo == ''){
			echo 15;
		}else{
			if($usuario == ''){
				echo 15;
			}else{
				if($pass == ''){
					echo 15;
				}else{
					//SI NO HAY CAMPOS VACIOS SE INSERTA EL REGISTRO EN LA BASE DE DATOS
					
					$sqlusuario = "INSERT INTO usuarios(correo_electronico, nombreusuario, password, nombre_completo, estado, rol, intentos) VALUES('".$correo."','".$usuario."','".$passw."','".$nombre."','".$estado."','".$tipo."', 0)";
					$result = pg_query($conn, $sqlusuario);
					if(!$result){
						//SE ENVIA ESTE VALOR A LA FUSNION AJAX INIDCANDO QUE NO SE REALIZO LA CONSULTA
						echo 2;
					}else{
						session_start();
						//SE INSERTA EN LA TABLA historial_usuario LA MODIFICAION REALIZADA AL USUARIO
						//DECLARACION DE LA VARIABLE PARA LA FECHA
						$time = time();
						//SE TOMA LA FECHA Y HORA DEL SISTEMA, DEBE VERIFICAR LA ZONA HORARIA EN EL ARCHIVO PHP.INI 
						$hoy = date("d-m-Y (H:i:s)", $time);
						$sqlhistorial = "INSERT INTO historial_usuarios(nombre, nombreusuario, password, fecha_modificacion, modificado_por, estado, rol) VALUES('".$nombre."', '".$usuario."', '".$passw."', '".$hoy."', '".$_SESSION['nombre']."', '".$estado."', '".$tipo."')";
						$ejecutar = pg_query($conn, $sqlhistorial);
						//SE ENVIA ESTE VALOR A LA FUSNION DE AJAX INDICANDO QUE SE INSERTARON LOS DATOS
						echo 5;
					}
					//SE CIERRA LA CONEXION A LA BASE DE DATOS
					pg_close($conn); 
				}
			}
		}
	}
   }
 }
	