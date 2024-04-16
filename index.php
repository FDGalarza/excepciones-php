<?phpsession_start();
	if(!empty($_SESSION['nombre'])){
		if($_SESSION['rol'] != 1){
			Location: "Inicio_Sesion.php";
			
		}
		
	}else{
		
		header("Location: Inicio_Sesion.php");
	}
		
	require_once("header.php");?>
	<section class="col-xs-8 col-sm-9 col-md-10 col-lg-10 main-content">
	<div id="content" class="content">
		<h2 class="col-md-12 module__header">Bienvenido  <?php echo $_SESSION['nombre'];?>!</h2>
	</div>
<?php require_once("footer.php"); ?>