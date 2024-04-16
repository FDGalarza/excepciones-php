<?php
//REFERNECIA FICHERO CONTROLADOR
require_once('../controlador/conexion.php');
//DECLARACION Y ASIGNACIONDE VARIABLES CON EL METODO POST
	$usuario = $_POST['usuario'];
	$pass = $_POST['password'];
	//SE ENCRIPTA LA CONTRASEÑA
     $passw=sha1($pass);
	 //CONEXION BASE DE DATOS
	 $conn = conectar_PostgreSQL('postgres', 'semana010411', '127.0.0.1', '5432', 'asesores');
	 //CONSULTA BASE DE DATOS
	 $sqlautenticar = "SELECT  rol, nombre_completo, nombreusuario, estado, intentos FROM usuarios WHERE nombreusuario ='".$usuario."' AND password='".$passw."'";
	 //SE EJECUTA LA CONSULTA
	 $result = pg_query($conn, $sqlautenticar);
//VERIFICACION CONSULTA EXITOSA	 
	 if(!$result){
		 //SI LA CONSULTA NO FUE EXITOS SE ENVIA ESTE VALOR A LA FUNSION DE AJAX
		 echo 5;
	 }else{
		 //SE CONSULTA FUE EXITOS SE CONTINUA CON EL INICIO DE SESSION Y SE VERIFICA QUE LOS DATOS INGRESADOS SEAN LOS MISMOS DE REGISTRADOS
			if(pg_num_rows($result) == 1){
				//CONSULTA PARA BUSCAR EL USUARIO QUE SE VA  A LOGUISAR
				$sqlcontar = "SELECT estado FROM usuarios WHERE nombreusuario = '".$usuario."' OR password ='".$passw."'";
				//SE EJECUTA LA COSNULTA
				$resultado = pg_query($conn, $sqlcontar);
				//SE DECLARA LA VARIABLE FIL A LA CUAL SE LE ASIGNA EL VALOR DE LA COSNULTA
				$fil = pg_fetch_array($resultado);
				//SE DECLARA LA VARIABLE ESTADO PARA VERIFICAR SI EL USUARIO ESTA ACTIVO O INACTIVO
				$estado = $fil['estado'];
				//VERIFICACION ESTADO DEL USUARIO
				if($estado == 1){
					//SI EL USUARIO ESTA ACTIVO INSERTAMOS EL VALOR CERO AL CAMPO INTENTOS FALLIDOS DE AUTENTICACION
					//EN CASO DE HABER HECHO ALGUN INTENTO FALLIDO LO ELIMINA EN EL MOMENTO DE HACER LA AUTENTICACION CORRECTA
					$sqlinsertarfallos = "UPDATE usuarios SET intentos = 0 WHERE nombreusuario ='".$usuario."' ";
					//SE EJECUTA LA CONSULTA
					$r = pg_query($conn, $sqlinsertarfallos);
					//SE INICIA LA SESSION PARA ASIGNAR LAS VARIABLES DE SESSION
					session_start();
					$fecha = date("d-m-Y H:i:s");
					$_SESSION['ultimo_ingreso'] = $fecha;
					//SE RECORREN LOS DATOS TRAIDOS EN LA CONSULTA
					while($fila = pg_fetch_array($result)){
						
						$nombre = $fila['nombre_completo'];
						$nombreusuario = $fila['nombreusuario'];
						$tipo = $fila['rol'];
						$intentos = $fila['intentos'];
						//ASIGNACION DE VARIABLES DE SESSION
						//VERIABLES DE SESION
						$_SESSION['nombre'] = $nombre;
						$_SESSION['usuario'] = $nombreusuario;
						$_SESSION['rol'] = $tipo;
						$_SESSION['intentos']= $intentos;
						$_SESSION['password']= $passw;
						
					}
					
					//SE ENVIA ESTE VALOR A LA FUNSIO DE AJAX COMO AUTENTICACION CORRECTA
					echo 1;
				}else{
					//SE ENVIA ESTE VALOR A LA FUSNION DE AJAX COMO AUTENTICACION INCORRECTA
					echo 5;
				}
				
			}else{
				//SE CONSULTA CUANTOS INTENTOS FALLIDOS DE AUTENTICACION HA REALIZADO
				$sqlcontar = "SELECT intentos FROM usuarios WHERE nombreusuario = '".$usuario."' OR password ='".$passw."'";
				//SE EJECUTA LA CONSULTA
				$res = pg_query($conn, $sqlcontar);
				//SE AQSIGNA LA CONSULTA A LA VARIABLE
				$fila = pg_fetch_array($res);
				//SE ASIGNA EL VALOR DE EL CAMPO INTENTOS A LA VARIABLE INTENTOS
				$intentos = $fila['intentos'];
				//SE AUMENTA EN UNO LA VARIABLE INTENTOS Y SE LE ASIGNA ESTE VALOR A LA VARIABLE FALLOS; SE HA HECHO UN INTENTOS FALLIDO
				$fallos = (int)$intentos + 1;
				//SE VERIFICAN CUANTOS FALLOS LLEVA HASTA ELMOMENTO SOLO SE PREMITEN TRES
				if($fallos == 3){
					//SI LA CONDICION ES VERDADERA SE INSERTA EL VALOR DE LA VARAIBLE FALLOS A LA BASE DE DATOS
					$sqlbloquiar = "UPDATE usuarios SET estado = 2, intentos = 3 WHERE nombreusuario ='".$usuario."'";
					$r = pg_query($conn, $sqlbloquiar);
					$editarestado ="UPDATE historial_usuarios SET estado = 2 WHERE nombreusuario = '".$usuario."'";
					$ejecutar = pg_query($conn, $editarestado);
					//SE ENVIA ESTE VALOR A LA FUSNION AJAX INDICANDO QUE YA HA COMPLETASO SU TERCER INTENTO FALLIDO DE AUTENTICACION
					echo 5;
				}else{
				//SE INSERTA EL VALOR DE LA FALLOS A LA BASE DE DATOS
				$sqlinsertarfallos = "UPDATE usuarios SET intentos ='".$fallos."' WHERE nombreusuario ='".$usuario."' ";
				$r = pg_query($conn, $sqlinsertarfallos);
				//SE ENCVIA ESTE VALOR A LA FUNSION AJAX INDICANDO QUE LA AUTENTICACIN FUE INCORRECTA PERO AUN NOHA COMPLETADO SUS TRES INTENTOS
				echo 2;
				}
			}
	 }
	 pg_close($conn);
?>