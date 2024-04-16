<?php
session_start();
	if(!empty($_SESSION['nombre'])){
		if($_SESSION['rol'] != 1){
			Location: "Inicio_Sesion.php";
			
		}
		
	}else{
		
		header("Location: Inicio_Sesion.php");
		}
	/* require_once("lib/PHPExcel/PHPExcel.php"); */
	require_once("controlador/conexion.php");
	require_once('fpdf17/fpdf.php');
		$centro = $_POST['codigo'];
		$contrato = $_POST['contrato'];
		/* $reporte = $_POST['excel']; */
		$reportepdf = $_POST['pdf'];
		if($reportepdf == 1){
			$centro = $_POST['codigo'];
	$contrato = $_POST['contrato'];
	/* $excepcion = $_POST['Excepcion']; */
	$pdf=new FPDF(); //Aqui el constructor de la clase, es para iniciarlo. 
	$otropdf = new FPDF;
	$pdf->Open(); //El Open, no recuerdo bien para que se usa!! jejejeje pero... creo que es para abrir lo arriba creado. 
	$pdf->AddPage(); //Agregas una pagina nueva... 
	$pdf->SetTitle('Listados asesores'); //El titulo! 
	$pdf->SetFillColor(0,0,0); 
	$pdf->SetTextColor(48, 26, 238);
	$pdf->Image('logo.gif',150,10,40);
	$conn = conectar_PostgreSQL('postgres', 'semana010411', '127.0.0.1', '5432', 'asesores');
	$control = $centro;
	$otrocontrol = $centro;
	/* $controlExcep = $excepcion; */
	while($control != "Apuestas AZAR S.A"){
		if($contrato == "ACTIVO" || $contrato == "INACTIVO"){
			$sqlreportes = "SELECT * FROM asesor WHERE centro_costos ='".$centro."' AND estado_contraro ='".$contrato."'";
		}else{
			$sqlreportes = "SELECT * FROM asesor WHERE centro_costos ='".$centro."'";
		}
		$control =  "Apuestas AZAR S.A";
	}
	while($otrocontrol == "Apuestas AZAR S.A"){
		
		if($contrato == "ACTIVO" || $contrato == "INACTIVO"){
			
			$sqlreportes = "SELECT * FROM asesor WHERE estado_contraro ='".$contrato."'";
		}else{
			$sqlreportes = "SELECT * FROM asesor";
		}
		$otrocontrol =  "Apuestas";
	}
	
	
	
		
		

	
	
		$result = pg_query($conn, $sqlreportes);
			if(pg_num_rows($result) == false){
?>
			
			<script type="text/javascript">alert("NO SE ENCONTRARON REGISTROS CON LOS PARAMETROS DADOS, NO SE PUEDE GENERAR EL REPORTE SOLICITADO; POR FAVOR VERIFIQUE SI REALIZO CORRECTAMENTE LA SELECION DE LOS PARAMETROS"); window.location="index.php";</script>;
<?php
			}else{
			
		$filas = pg_num_rows($result);
			$bin=0; //Esta es... como nuestra variable bandera... mas adelante veras su uso. (Bueno, es solo para formato) 
			$i=0; //Contador... 
			$n = 1;
			$pdf->SetFont('helvetica','B',16); //Algo de formato! 
			/* $fila = 1;
			$columna = 1;
			
 */
				while($i < 1){
				
					$pdf->Cell(195,7, utf8_decode('REPORTE ASESORES'),0, 0 , 'C' );
					$pdf->SetLineWidth(0.01);
					$pdf->Ln();
					$pdf->Ln();
					$pdf->SetTextColor(73, 67, 67);
					
					if($centro == "Apuestas AZAR S.A"){
						$pdf->Cell(195,5, utf8_decode('APUESTAS AZAR S.A'),0, 0 , 'C' );
					}else{
						$fila = pg_fetch_array($result);
						$valor = $fila['centro_costos'];
						$sqlcentro = "SELECT nombre FROM centro_costos WHERE codigo='".$centro."'";
						$res = pg_query($conn, $sqlcentro);
						$fila = pg_fetch_array($res);
						$Ncentro = $fila["nombre"];
					$pdf->Cell(195,5, utf8_decode($centro." - ".$Ncentro),0, 0 , 'C' );
					}
					$pdf->Ln();
					$pdf->Ln();
					$pdf->Ln();
					$pdf->SetFont('courier','B',12);
					$fecha = date("d/m/y");
					$pdf->Cell(50,7, utf8_decode('GENERADO POR:'),0, 0 , 'L' );
					$pdf->Cell(30,7, utf8_decode($_SESSION['nombre']) ,0, 0 , 'L' );
					$pdf->Ln();
					$pdf->Cell(50,7, utf8_decode('FECHA DEL REPORTE:'),0, 0 , 'L' );
					$pdf->Cell(30,7, utf8_decode($fecha) ,0, 0 , 'L' );
					$pdf->Ln();
					$pdf->Ln();
					$pdf->SetFont('helvetica','B',10);
					
					$pdf->Cell(7,5, utf8_decode(''),1, 0 , 'C' );
					$pdf->Cell(30,5, utf8_decode('DOCUMENTO'),1, 0 , 'C' );
					$pdf->Cell(40,5, utf8_decode('NOMBRES'),1, 0 , 'C' );
					$pdf->Cell(45,5, utf8_decode('APELLIDOS'),1, 0 , 'C' );
					
					$pdf->Cell(45,5, utf8_decode('ESTADO CONTRATO'),1, 0 , 'C' );
					$pdf->Cell(25,5, utf8_decode('EXCEPCION'),1, 0 , 'C' );
					$pdf->Ln();
					$i++;
				}
				$pdf->SetFont('courier','B',10);
					$i=0;
			while($i<$filas){
						
						$pdf->Cell(7,5, utf8_decode($n),1, 0 , 'C' );
						$valor = pg_fetch_result($result, $i, 0); //DOCUMENTO Esta funcion recorre una fila, con $i podemos recorrerlas todas. (OJO!! Solo estamos poniendo el valor de la columna 0) 
						$pdf->Cell(30,5, utf8_decode($valor),1, 0 , 'C' );
						
						$valor1 = pg_fetch_result($result, $i, 6);//NOMBRES
						$pdf->Cell(40,5, utf8_decode($valor1),1, 0 , 'C' );
						
						$valor2 = pg_fetch_result($result, $i, 1);
						$valor1 = pg_fetch_result($result, $i, 2);
						$pdf->Cell(45,5, utf8_decode($valor2. "  ".$valor1),1, 0 , 'C' );
						
						$valor1 = pg_fetch_result($result, $i, 4);
						$pdf->Cell(45,5, utf8_decode($valor1),1, 0 , 'C' );
						
						$valor2 = pg_fetch_result($result, $i, 5);
						if($valor2 == 1){
							$pdf->Cell(25,5, utf8_decode('SI'),1, 0 , 'C' );
						}else{
							$pdf->Cell(25,5, utf8_decode('NO'),1, 0 , 'C' );
						}
						$bin=!$bin; //Cambiamos el valor de $bin, si es 0 lo hace 1 y si es 1 lo hace 0. Solo un poco de logica matematica. 
						$pdf->Ln();
			/* $n++;
			$fila++;
			$columna++; */
			$n++;	
			$i++; //Incrementamos nuestro contador 
			
	} 
	
	
	
$pdf->Output(); //Y nuestro resultado final!!! Aqui mostramos el PHP 
			}
			}else{
				if($reportepdf == 0){
				
				$control = $centro;
	$otrocontrol = $centro;
	$fecha = date("d/m/y");
				$conexion = conectar_PostgreSQL('postgres', 'semana010411', '127.0.0.1', '5432', 'asesores');
				while($control != "Apuestas AZAR S.A"){
		if($contrato == "ACTIVO" || $contrato == "INACTIVO"){
			$consulta2 = "SELECT * FROM asesor WHERE centro_costos ='".$centro."' AND estado_contraro ='".$contrato."'";
		}else{
			$consulta2 = "SELECT * FROM asesor WHERE centro_costos ='".$centro."'";
		}
		$control =  "Apuestas AZAR S.A";
	}
	while($otrocontrol == "Apuestas AZAR S.A"){
		
		if($contrato == "ACTIVO" || $contrato == "INACTIVO"){
			
			$consulta2 = "SELECT * FROM asesor WHERE estado_contraro ='".$contrato."'";
		}else{
			$consulta2 = "SELECT * FROM asesor";
		}
		$otrocontrol =  "Apuestas";
	}
				//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
					
		/* $consulta2="SELECT * FROM asesor"; */
		$ejecutar2=pg_exec($conexion, $consulta2);
		$registro2=pg_num_rows($ejecutar2);
		if ($registro2==0) {
			?>
		<script>
		alert("NO HAZ SELECCIONADO NINGUN PARAMETRO");
		window.location="index.php";
		</script>'
		<?PHP
		}else
		{
			header('Content-type: application/vnd.ms-excel');
			header("Content-Disposition: attachment; filename=Listado_asesores.xls");
			header("Pragma: no-cache");
			header("Expires: 0");
		echo "<table border=0.5 readonly='readonly'>\n";
			echo "<tr>\n";
				echo "<th colspan=8><h2><strong>APUESTAS AZAR S.A</strong></h2></th>\n";
			echo "</tr>\n";
				echo "<tr>\n";
					echo "<th colspan=8><h3>REPORTE ASESORES</h3></th>\n";
				echo "</tr>\n";
			
				
			echo "<tr>\n";
$sqlcentro = "SELECT nombre FROM centro_costos WHERE codigo ='".$centro."'";
$r = pg_query($conexion, $sqlcentro);
$f = pg_fetch_array($r);
$n = $f['nombre'];
			if($centro == "Apuestas AZAR S.A" ){
				echo "<th colspan=8>GENERAL</th>\n";
			}else{
				echo "<th colspan=8>".$centro." - ".$n."</th>\n";
			}
			echo "<tr>";
				echo "<td colspan=8>Impreso Por:"."     ".$_SESSION['nombre']."</td>\n";
			echo "</tr>";
			echo "<tr>\n";
			
				echo "<td colspan=8><h4>Fecha de impresi&oacute;n:"."    ".$fecha."</td>\n";
				
				
			echo "</tr>\n";
			echo "<tr>\n";
			echo "</tr>\n";
			

					echo "<tr>\n";
						
						echo "<th>No</th>\n";
						echo "<th>DOCUMENTO</th>\n";
						echo "<th>NOMBRES</th>\n";
						echo "<th>PRIMER APELLIDO</th>\n";
						echo "<th>SEGUNDO APELLIDO</th>\n";
						if($centro == "Apuestas AZAR S.A"){
						echo "<th>CENTRO DE CONSTOS</th>\n";
						}
						echo "<th>ESTADO CONTRATO</th>\n";
						echo "<th>EXCEPCIONES</th>\n";
					echo "</tr>\n";
		$row=0;
		do
		{
			$myrow=pg_fetch_row($ejecutar2,$row);
			$row++;
			$n0=$myrow["0"];//DOCUMENTO
			$n1=$myrow["6"];//NOMBRES
			$n2=$myrow["1"];//APELLIDO UNO
			$n3=$myrow["2"];//APELLIDO DOS
			$n4=$myrow["3"];//CENTRO DE COSTOS
			$n5=$myrow["4"];//ESTADO CONTRATO
			$n6=$myrow["5"];//EXCEPCIONES
			
						echo "<tr>";
							echo "<td align=center>".$row."</td>";
							echo "<td align=center width=\"50px\">".$n0."</td>\n";
							echo "<td align=center>".$n1."</td>\n";
							echo "<td align=center>".$n2."</td>\n";
							echo "<td align=center>".$n3."</td>\n";
							/* echo "<td align=center>".$n4."</td>\n"; */
								$sqlcentro = "SELECT nombre FROM centro_costos WHERE codigo ='".$n4."'";
								$resultaqdo = pg_query($conexion, $sqlcentro);
								$valor = pg_fetch_array($resultaqdo);
								$Ncentro = $valor['nombre'];
								if($centro == "Apuestas AZAR S.A"){
							echo "<td align=center>".$n4." - ".$Ncentro."</td>\n";
								}
							echo "<td align=center>".$n5."</td>\n";
							if($n6 == 1){
								echo "<td align=center>SI</td>\n";
							}else{
								echo "<td align=center>NO</td>\n";
							}
							echo "</tr>";
		}//finDo
		while($row < $registro2);	
	echo "</table>\n";
		}//fin else
			if ($registro2<>0){
		}
			}//
			
			}
	
?>
			

	
	
	