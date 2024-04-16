<?php
//FUNSION PARA EDITAR UN USUARIO DEL SISTEMA
//REFERENCIA ARCHIVO CONTROLADOR
require_once('../controlador/conexion.php');
//DECLARACION DE VARIABLES Y SIGNACION DE VALORES POR EL METODO POST
	$nombre = $_POST['nombreCompleto'];
	$correo = $_POST['correo'];
	$usuario = $_POST['nombreUsuario'];
	$pass = $_POST['password'];
	$estado = $_POST['estado'];
	$tipo = $_POST['tipo'];
    //SE ENCRIPTA LA CONTRASEÑA
     $passw=sha1($pass);
	 //VERIFICACION CAMPOS VACIOS
 if($estado == ''){
	   echo 15;
 }else{
   if($tipo == ''){
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
					//SE REALIZA LA EDICION A LA BASE DE DATOS
					$conn = conectar_PostgreSQL('postgres', 'semana010411', '127.0.0.1', '5432', 'asesores');
					$sqlusuario = "UPDATE usuarios SET correo_electronico ='".$correo."', password= '".$passw."', estado='".$estado."', rol='".$tipo."' WHERE nombre_completo = '".$nombre."'";
					$result = pg_query($conn, $sqlusuario);
					if(!$result){
						//LA CONSULTA NO SE REALIZO
						echo 2;
					}else{
						//SE BORRA HISTORIA DE ESTE USUARIO DE LA TABLA DE AUDITORIA DE USUARIOS 
						$borrarhistorial = "DELETE  FROM historial_usuarios WHERE nombreusuario = '".$usuario."'";
						//SE EJECUTA LA CONSULTA BORRAR
						$borrar = pg_query($conn, $borrarhistorial);
						//INICIA SESSION PARA UTILIZAR LAS VARIABLES DE SESSION
						session_start();
						//SE TOMA LA FECHA Y HORA DEL SISTEMA, DEBE VERIFICAR LA ZONA HORARIA EN EL ARCHIVO PHP.INI 
						$time = time();
						//FROMATO FECHA Y HORA DEL SISTEMA
						$hoy = date("d-m-Y (H:i:s)", $time);
						//GUARDAR HISTORIAL DE CAMBIOS A EL USUARIO
						$sqlhistorial = "INSERT INTO historial_usuarios(nombre, nombreusuario, password, fecha_modificacion, modificado_por, estado, rol) VALUES('".$nombre."', '".$usuario."', '".$passw."', '".$hoy."', '".$_SESSION['nombre']."', '".$estado."', '".$tipo."')";
						$ejecutar = pg_query($conn, $sqlhistorial);
						//LA CONSULTA SE RELIZO CORECTAMENT
						echo 5;
					}
					//SE CIERRA LA CONEXION CON LA BASE DE DATOS
					pg_close($conn); 
				}
			}
		}
	}
   }

?>