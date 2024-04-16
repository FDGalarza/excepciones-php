<?php
$doc = $_POST['doc'];
 function conectar_PostgreSQL( $usuario, $pass, $host, $port, $bd )
    {
         $conexion = pg_connect( "user=".$usuario." "."password=".$pass." "."host=".$host." "."port=".$port." "."dbname=".$bd ) or die( "Error al conectar: ".pg_last_error() );
		 echo "ahi va  ";
		 
        return $conexion;
		
    }
	$otra = conectar_PostgreSQL('postgres', 'semana010411', '127.0.0.1', '5432', 'asesores');
	$consultar = "SELECT doc_identidad FROM asesor WHERE doc_identidad=".$doc:" ";
	pg_query($otra, $consultar);
	$documento = pg_query;
	pg_close($otra);
	if ($documento != null);{
		
		echo "Este registro ya existe";
	}