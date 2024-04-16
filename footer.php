<?php
	
	if(!empty($_SESSION['nombre'])){
		if($_SESSION['rol'] != 1){
			Location: "Inicio_Sesion.php";
			
		}
		
	}else{
		
		header("Location: Inicio_Sesion.php");
		}
?>
</section>
<footer class="col-xs-12 footer">
		Excepciones de Colocadores v1.0 - Apuestas Azar S.A. &copy; 2015
</footer>
</div>

</div>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/validar.js"></script>
<script type="text/javascript" src="js/ajax.js"></script>
<script type="text/javascript">
function loadModule(div,url){
	$(this).click(function(event){
    event.preventDefault();
	});
	$(div).load(url);
}
</script>
</body>
</html>