<?php
 //CON ESTA FUNSION ME CONECTO A LA BASE DE DATOS
	 function conectar_PostgreSQL( $usuario, $pass, $host, $port, $bd )
			{
				//CADENA DE CONEXION
					$conexion = pg_connect( "user=".$usuario." "."password=".$pass." "."host=".$host." "."port=".$port." "."dbname=".$bd ) or die( "Error al 	conectar: ".pg_last_error() );
					return $conexion;		
			}
?>