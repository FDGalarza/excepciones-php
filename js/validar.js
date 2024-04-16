function validaNumero(input)
{
//TOMO EL VALOR DEL CAMPO ENVIADO EN EL EVENTO 
  var num = input.value;
  if(isNaN(num))
  {
   /*  alert("Solo se permiten números en este campo"); */
    input.value = "";
    input.focus();
  }else{
	
  }
}
//CON ESTA FUNSIO SE VALIDA QUE NO SE PERMITAN NUMEROS, NI ESPACIOS, NI CARACTERES ESPECIALES EN UN CAMPO DE TEXTO
function validarletras(input){
//VERIFICO QUE SOLO SE PRESIONEN LETRAS O TECLAS DE CONTRO
  if(((event.keyCode < 8) && (event.keyCode >18)) || ((event.keyCode > 47) && (event.keyCode <58)))
  {
	alert("Solo se permiten letras en este campo");
	input.value = "";
    input.focus();
	event.returnValue = true;
  }
//VERIFICO QUE NO SE INSERTEN ESPACIO O CARACTERES ESPECIALES
  if((event.keyCode == 32) || (event.keyCode > 192) || event.keyCode > 194)
  {
    alert("No se permite poner espacios ni caracteres especiales en este campo");
	input.value = "";
    input.focus();
	event.returnValue = false;	
  }
}
function validarletrasusuario(input){
//VERIFICO QUE SOLO SE PRESIONEN LETRAS O TECLAS DE CONTRO
  if(((event.keyCode < 8) && (event.keyCode >18)) || ((event.keyCode > 47) && (event.keyCode <58)))
  {
	alert("Solo se permiten letras en este campo");
	input.value = "";
    input.focus();
	event.returnValue = true;
  }
//VERIFICO QUE NO SE INSERTEN ESPACIO O CARACTERES ESPECIALES
  if((event.keyCode > 192) || event.keyCode > 194)
  {
    alert("No se permite poner espacios ni caracteres especiales en este campo");
	input.value = "";
    input.focus();
	event.returnValue = false;	
  }
}
//FUNSION PARA VERIFICAR QUE SI SEA UN CORREO ELECTRONICO LO INGRESADO
function validarCorreo(){
	//SE DECLARAN VARIABLES CON LOS VALORES REGISTRADOS POR EL USUARIO
	var contador = 0;
	var correo = $('#correo').val();
	var otrocorreo = $('#correo');
	//SE RECORRE EL CORREO INGRESADO POR EL USUSARIO CON ESTE CICLO FOR 
	for(var i = 0; i <= correo.length; i++){
		var caracter = correo.charAt(i);
		//SE VERIFICA SI EN ALGUN MOMENTO EL USUARIO INGRESA EL CARACTER @ 
		if(caracter == "@"){
			//SI SE ENCUENTRA ALGUNA COINCIDENCIA SE AUMENTA LA VARIABLE CONTAODR 
			contador = 1;
		}
	//VERIFICACION DE EL VALOR DEL CONTADOR	
	}if(contador == 0){
		//SI EL VALOR DE CONTAODR ES = 0 SE MUESTRA ESTE MENSAJE; SE HA DETECTADO QUE NO SE PRESIONO LA TECLA @ EN NINGUN MOMENTO
		alert("LA INFORMACION INGRESADA NO ES UN CORREO ELECTRONICO VALIDO");
		//SE LIMPIA EL CAMPO 
		otrocorreo.val("");
		//SE HACE FOCO EN EL CAMPO
	otrocorreo.focus();
		
	}
}
//foco registro colocadores
function fococolocadores(){
	var documento = $('#doc');
	documento.focus();
}
function validarnombres(input){
//VERIFICO QUE SOLO SE PRESIONEN LETRAS O TECLAS DE CONTRO
  if(((event.keyCode < 8) && (event.keyCode >18)) || ((event.keyCode > 47) && (event.keyCode <58)))
  {
	alert("Solo se permiten letras en este campo");
	input.value = "";
    input.focus();
	event.returnValue = true;
  }
//VERIFICO QUE NO SE INSERTEN ESPACIO O CARACTERES ESPECIALES
  if((event.keyCode > 192) || event.keyCode > 194)
  {
    alert("No se permite poner espacios ni caracteres especiales en este campo");
	input.value = "";
    input.focus();
	event.returnValue = false;	
  }
}



