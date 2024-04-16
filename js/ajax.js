function objetoAjax(){
	var xmlhttp=false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
 
	try {
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	} catch (E) {
		xmlhttp = false;
	}
}
 
if (!xmlhttp && typeof XMLHttpRequest!="undefined") {
	  xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}

var $codigo;
var $contrato

			function consultarcentro(){
			var codigo = $("#codigo").val();
			var centrodecosto = $("#centro");
			if(codigo != "NULL"){
				//INSTACION EL OBJETO AJAX
				ajax = objetoAjax();
				//USAMOS EL METODO POST AL ARCHIVO QUE RELAIZARA LA IOPERACION
				ajax.open("POST","Procedientos/consultar_centro.php",true);
				ajax.onreadystatechange = function() {
					if (ajax.readyState==1) {
						centrodecosto.val("CARGANDO CENTRO DE COSTOS");
					}
						if (ajax.readyState==4) {
							centrodecosto.val(ajax.responseText);
						}
					}		
						ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
						ajax.send("codigo="+codigo)
				}	
			}	
			//FUNSION PARA CONSULTAR ASESORES POR NUMERO DE CEDULA
function consultarAsesor(){
	var documento = $('#doc').val();
	var documentoVaciar = $('#doc');
	var nom1 = $('#nombres');
	var ape1 = $('#apellido1');
	var ape2 = $('#apellido2');
	var centrocostos = $('#codigo');
	var contrato = $('#contrato');
	var excepcion = $('#excepcion');
	var elemento;
	var array = [];
		if(documento != "NULL"){
			//INSTACION EL OBJETO AJAX
			ajax = objetoAjax();
			//USAMOS EL METODO POST AL ARCHIVO QUE RELAIZARA LA OPERACION
			ajax.open("POST","Procedientos/consultar_cedula.php",true);
			ajax.onreadystatechange = function() {
				if (ajax.readyState==1) {
					nom1.val("Cargando");
				}		
					if (ajax.readyState==4) {	
						
						if (ajax.responseText == 0){
						alert("NO EXISTE NINGUN REGISTRO CON ESTE DOCUMENTO");
						documentoVaciar.val("");
						nom1.val("");
						ape1.val("");
						ape2.val("");
						centrocostos.val(0);			
						contrato.val(0);
						excepcion.val(0);
						documentoVaciar.focus();
						documentoVaciar.val("");
					}else{
						var elemento = ajax.responseText;
						array = elemento.split(',');
						var exc = parseInt(array[5]);
						var cod = parseInt(array[3]);
						//ASIGNO VALORES A LOS CAMPOS			
						nom1.val(array[0]);
						ape1.val(array[1]);
						ape2.val(array[2]);
						centrocostos.val(cod);			
						contrato.val(array[4]);
						excepcion.val(exc);	
						documentoVaciar.attr("readonly", true)
						$('#cancelar').attr("disabled", true);
						$('#limpiar').attr("disabled", false);
						$('#actualizar').attr("disabled", true);
					} 
					}
					
												
								
				}
					ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
					ajax.send("doc="+documento)						
		}	
}

//FUNSIO PARA CONSULTAR ASESORES SEGUN EL ESTADO DEL CONTRATO	
	function AsesorEstadoContrato(pos){
		var contrato = $('#contrato').val();
		codigo;
		var mostrarestado = $('#contrato');
		var tabla = $('#contenedorTabla');
			if(contrato != null){
				//INSTANCIO EL OBJETO AJAX
				ajax = objetoAjax();
				//USAMOS EL METODO POST AL ARCHIVO QUE REALIZARA LA OPERACION
				ajax.open("POST","Procedientos/backap.php", true);
				ajax.onreadystatechange = function(){
					if(ajax.readyState == 1){
						mostrarestado.val("RECOPILANDO LA INFORMACION");
					}
					if(ajax.readyState == 4){	
						
						var data = ajax.responseText;
						tabla.html(data);
						
					}
				}
				ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
				ajax.send("contrato="+contrato, "codigo="+codigo);
				
				
			}
	}
	function AsesorCentroCostos(limite){
	var codigo = $('#codigo').val();
	var tabla = $('#contenedorTabla');
	var excepcion = $('#Excepcion');
	var contrato = $('#contrato');
	var url = "Procedientos/consultarAsesorCcostos.php";
	
	ajax = objetoAjax();
	ajax.open("POST", "Procedientos/consultarAsesorCcostos.php", true);
	ajax.onreadystatechange= function(){
	$.post(url, { limite:limite, codigo:codigo}, function (responText){
		tabla.html(responText);
		excepcion.attr("disabled", false);
		contrato.attr("disabled", false);
	});
	}
		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		ajax.send("&codigo="+codigo);
	} 
				//FUNSION PARA LISTAR LOS ASESORES TENIENDO EN CUENTA SI SON EXCEPCIONES O NO
			function AsesorExcepciones(limite){
				var excepcion = $('#Excepcion').val();
				var tabla = $('#contenedorTabla');
				var url = "Procedientos/consultarExcepciones.php";
					//INSTANCIO EL OBJETO AJAX
					ajax = objetoAjax();
					//USAMOS EL METODO POST AL ARCHIVO QUE REALIZARA LA OPERACION
					ajax.open("POST","Procedientos/consultarExcepciones.php", true);
					ajax.onreadystatechange= function(){
						$.post(url, { limite:limite, excepcion:excepcion}, function (responText){
							tabla.html(responText);
							
						});
					}
						ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
						ajax.send("&excepcion="+excepcion);
			}
				//FUNSION PARA FILTRA ASEOSR POR NUMERO DE CEDULA
				function buscarAsesor(limite){
				var doc = $('#doc').val();
				var tabla = $('#contenedorTabla');
				var url = "Procedientos/Filtrar_asesor.php"
					//INSTANCIO EL OBJETO AJAX
					ajax = objetoAjax();
					//USAMOS EL METODO POST AL ARCHIVO QUE REALIZARA LA OPERACION
					ajax.open("POST","Procedientos/Filtrar_asesor.php", true);
					ajax.onreadystatechange = function(){
						$.post(url, {limite:limite, documento:doc}, function (responText){
								tabla.html(responText);
							});
						}
								ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
								ajax.send("documento="+doc);	
					}
				
				//CON ESTA FUNSION SE LLENA LA LISTA DE EMPLEADOS AL CARGAR EL MODULO DE OCNSULTAS
				function llenarAsesores(){
				var doc = $('#doc').val();
				var tabla = $('#contenedorTabla');
					if(doc != null){
						//INSTANCIO EL OBJETO AJAX
						ajax = objetoAjax();
						//USAMOS EL METODO POST AL ARCHIVO QUE REALIZARA LA OPERACION
						ajax.open("POST","Procedientos/cargarAsesores.php", true);
						ajax.onreadystatechange = function(){
							if(ajax.readyState == 1){
								//mostrarestado.val("RECOPILANDO LA INFORMACION");
							}
									if(ajax.readyState == 4){	
									var data = ajax.responseText;
									
									tabla.html(data);
								}
							}
								ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
								ajax.send("documento="+doc);	
					}
				}
				//FUNSION REPORTES CENTRO DE COSTOS
				function ReporteCentroCostos(){
				codigo = $('#codigo').val();
				var mostrarestado = $('#codigo');
				var tabla = $('#contenedorTabla');
				if(codigo != null){
					//INSTANCIO EL OBJETO AJAX
					ajax = objetoAjax();
					//USAMOS EL METODO POST AL ARCHIVO QUE REALIZARA LA OPERACION
					ajax.open("POST","Procedientos/reportePDF", true);
					ajax.onreadystatechange = function(){
						if(ajax.readyState == 1){
							mostrarestado.val("RECOPILANDO LA INFORMACION");
						}
						if(ajax.readyState == 4){
							
						}
					}
					ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
					ajax.send("codigo="+codigo);	
				}
			}
			function validarRegistro(){
				var doc = $('#doc').val();
				var documento = $('#doc');
					if(doc != null){
						//INSTANCIO EL OBJETO AJAX
						ajax = objetoAjax();
						//USAMOS EL METODO POST AL ARCHIVO QUE REALIZARA LA OPERACION
						ajax.open("POST","Procedientos/verificarRegistro.php", true);
						ajax.onreadystatechange = function(){
							if(ajax.readyState == 1){
								//mostrarestado.val("RECOPILANDO LA INFORMACION");
							}
							   if(ajax.readyState == 4){	
							   var nombre = (ajax.responseText);
							   if(nombre == 1 || nombre == 2){
								  var confirmar=confirm("ESTE REGISTRO YA ESXISTE EN LA BASE DE DATOS, DESEAS EDITAR SU INFORMACION");
								  documento.val("");
								  documento.focus();
								  if(confirmar){
									 loadModule('#content','edicion_colocadores.php');
									 alert("POR FAVOR DIGITE NUEVAMENTE EL NUMERO DEL DOCUMENTO PARA VER LA INFORMACION DEL REGISTRO");
									 documento.focus();
								  }else{
									  loadModule('#content','registro_colocadores.php');
									   documento.attr("focus", true);
									   $('#registrar').attr("disabled", false);
										$('#limpiar').attr("disabled", false);
										$('#cancelar').attr("disabled", true);
									 
								  }
							  }else{
								  $('#registrar').attr("disabled", false);
								  $('#limpiar').attr("disabled", false);
								  $('#cancelar').attr("disabled", true);
							  }
						    }
						}
							ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
							ajax.send("documento="+doc);	
					}
				}	
				//INSERTAR REGISTRO
				function insertarRegistro(){
					//DECLARO VARIABLES ASIGNANDOLE  LOS VALORES MANDADOS DE EL FORM
					var doc = $('#doc').val();
					var nom1 = $('#nombre1').val();
					var ape1 = $('#apellido1').val();
					var ape2 = $('#apellido2').val();
					var centrocostos = $('#codigo').val();
					var contrato = $('#contrato').val();
					var excepcion = $('#excepcion').val();
					//DEVALOR VARABLES PARA TOMAR LOS CAMPOS DE EL FORMULARIO PARA LIMPIARLOS
					var documento = $('#doc');
					var nombre1 = $('#nombre1');
					var nombre2 = $('#nombre2');
					var apellido1 = $('#apellido1');
					var apellido2 = $('#apellido2');
					var centro_costos = $('#codigo');
					var cont = $('#contrato');
					var excep = $('#excepcion');
					var mostrar = $('#label');
					if(doc != null || nom1 != null || ape1 != null || centrocostos != null || contrato != null || excepcion != null){
					   //INSTANCAIO EL OBJETO AJAX
						ajax = objetoAjax();
						//USO EL METODO POST PARA SEDER LAS VARIABLOE AL ARCHIVO PHP QUE EJECUTARA LA CONSULTA
						ajax.open("POST", "procedientos/insertar_asesor.php");
						ajax.onreadystatechange = function(){
							if(ajax.readyState == 1){
								mostrar.val("PROCESANDO INFORMACION");
							}
							if(ajax.readyState == 4){
								if(ajax.responseText == 5){
									alert("REGISTRO CREADO");
									loadModule('#content','registro_colocadores.php');
									documento.focus();
									$('#registrar').attr("disabled", true);
								  $('#limpiar').attr("disabled", true);
								  $('#cancelar').attr("disabled", false);
								}
								if(ajax.responseText == 15){
									alert("ALGUNO DE LOS CAMPOS NO SE HA LLENADO");
								}
								if(ajax.responseText == 2){
									alert("SE HA PRESENTADO ALGUN ERROR Y EL REGISTRO NO PUDO SER GUARDADO POR FAVOR VERIFIQUE");
								}	
							}
						}
						   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
					       ajax.send("&doc="+doc+"&nombre1="+nom1+"&Apellido1="+ape1+"&Apellido2="+ape2+"&codigo="+centrocostos+"&contrato="+contrato+"&excepcion="+excepcion);	
						   
					}
				}
				//FUNCION PARA EDITAR REGISTRO
				function EditarRegistro(){
				//DECLARO VARIABLES ASIGNANDOLE  LOS VALORES MANDADOS DE EL FORM
					var doc = $('#doc').val();
					var nom1 = $('#nombres').val();
					var ape1 = $('#apellido1').val();
					var ape2 = $('#apellido2').val();
					var centrocostos = $('#codigo').val();
					var contrato = $('#contrato').val();
					var excepcion = $('#excepcion').val();
					//DEVALOR VARABLES PARA TOMAR LOS CAMPOS DE EL FORMULARIO PARA LIMPIARLOS
					var documento = $('#doc');
					var nombre1 = $('#nombre1');
					var nombre2 = $('#nombre2');
					var apellido1 = $('#apellido1');
					var apellido2 = $('#apellido2');
					var centro_costos = $('#codigo');
					var cont = $('#contrato');
					var excep = $('#excepcion');
					var mostrar = $('#label');
					if(doc != null || nom1 != null || ape1 != null || centrocostos != null || contrato != null || excepcion != null){
					   //INSTANCAIO EL OBJETO AJAX
						ajax = objetoAjax();
						//USO EL METODO POST PARA SEDER LAS VARIABLOE AL ARCHIVO PHP QUE EJECUTARA LA CONSULTA
						ajax.open("POST", "procedientos/Editar.php");
						ajax.onreadystatechange = function(){
							if(ajax.readyState == 1){
								mostrar.val("PROCESANDO INFORMACIÓN");
							}
							if(ajax.readyState == 4){
								if(ajax.responseText == 5){
									alert("EL REGISTRO FUE EDITADO");
									loadModule('#content','edicion_colocadores.php');
									documento.focus();
								}
								if(ajax.responseText == 15){
									alert("ALGUNO DE LOS CAMPOS NO SE HA LLENADO");
								}
								if(ajax.responseText == 2){
									alert("SE HA PRESENTADO ALGÚN ERROR Y EL REGISTRO NO PUDO SER GUARDADO POR FAVOR VERIFIQUE");
								}	
							}
						}
						   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
					       ajax.send("&doc="+doc+"&nombre1="+nom1+"&Apellido1="+ape1+"&Apellido2="+ape2+"&codigo="+centrocostos+"&contrato="+contrato+"&excepcion="+excepcion);	
						   
					}
				}
				//FUNSION PARA GENERAR REPORTES
				function generarReportes(){
				//DECLARO VARIABLES ASIGNANDOLE  LOS VALORES MANDADOS DE EL FORM
					var codigo = $('#codigo').val();
					var contrato = $('#contrato').val();
					
					if(codigo != null || contrato != null){
					   //INSTANCAIO EL OBJETO AJAX
						ajax = objetoAjax();
						//USO EL METODO POST PARA SEDER LAS VARIABLOE AL ARCHIVO PHP QUE EJECUTARA LA CONSULTA
						ajax.open("POST", "procedientos/reporte1.php");
						ajax.onreadystatechange = function(){
							if(ajax.readyState == 1){
								
							}
							if(ajax.readyState == 4){
								if(ajax.responseText == 5){
									alert("REGISTRO ACTUALIZADO");
									loadModule('#content','edicion_colocadores.php');
									/* documento.val("");
									nombre1.val("");
									nombre2.val("");
									apellido1.val("");
									apellido2.val("");
									cont.val(0);
									centro_costos.val(0);
									excep.val(0);
									documento.focus();*/
								}
								if(ajax.responseText == 15){
									alert("POR FAVOR VERIFIQUE ALGUNO DE LOS CAMPOS NO SE HA LLENADO");
								}
								if(ajax.responseText == 2){
									alert("SE HA PRESENTADO ALGÚN ERROR Y EL REGISTRO NO PUDO SER GUARDADO POR FAVOR VERIFIQUE");
								}	
							}
						}
						   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
					       ajax.send("&codigo="+doc+"&contrato="+nom1);	
						   
					}
				}
				//CREAR USUARIO
				function crearUsuario(){
					//DECLARO VARIABLES ASIGNANDOLE  LOS VALORES MANDADOS DE EL FORM
					var nombreCompleto = $('#NombreCompleto').val();
					var nombreCompletoFco = $('#NombreCompleto');
					var correo = $('#correo').val();
					var password = $('#password').val();
					var nombreUsuario = $('#usuario').val();
					var estado = $('#estado').val();
					var rol = $('#rol').val();
					if(nombreCompleto != null){
					   //INSTANCAIO EL OBJETO AJAX
						ajax = objetoAjax();
						//USO EL METODO POST PARA SEDER LAS VARIABLOE AL ARCHIVO PHP QUE EJECUTARA LA CONSULTA
						ajax.open("POST", "procedientos/CrearUsuario.php");
						ajax.onreadystatechange = function(){
							if(ajax.readyState == 1){
								
							}
							if(ajax.readyState == 4){
								if(ajax.responseText == 5){
									alert("REGISTRO GUARDADO");
									loadModule('#content','Crear_Usuario.php');
									nombreCompletoFco.focus();
									
								}
								if(ajax.responseText == 15){
									alert("POR FAVOR VERIFIQUE ALGUNO DE LOS CAMPOS NO SE HA LLENADO");
								}
								if(ajax.responseText == 2){
									alert("SE HA PRESENTADO ALGUN ERROR Y EL REGISTRO NO PUDO SER GUARDADO POR FAVOR VERIFIQUE");
								}	
							}
						}
						   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
					       ajax.send("&nombreCompleto="+nombreCompleto+"&correo="+correo+'&password='+password+'&nombreUsuario='+nombreUsuario+'&estado='+estado+'&tipo='+rol);	
						   
					}
				}
				//USUARIO REPETIDO
				function usuarioRepetido(){
			       var usuario = $('#usuario').val();
				   var otrousuario = $('#usuario');
				   if(usuario != null){
					   //INSTANCAIO EL OBJETO AJAX
						ajax = objetoAjax();
						//USO EL METODO POST PARA SEDER LAS VARIABLOE AL ARCHIVO PHP QUE EJECUTARA LA CONSULTA
						ajax.open("POST", "procedientos/validar_usuario.php");
						ajax.onreadystatechange = function(){
						  if(ajax.readyState == 1){							
						   }
							  if(ajax.readyState == 4){
								if(ajax.responseText == 10){
									alert("EL NOMBRE DE USUARIO NO ESTA DSIPONIBLE");
									otrousuario.val("");
									otrousuario.focus();
								}
								if(ajax.responseText == 12){

								}
								if(ajax.responseText == 2){
									alert("SE HA PRESENTADO ALGúN ERROR DE CONEXIÓN");
								}
							}
						 }
						   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
					       ajax.send("&usuario="+usuario);		   
					}
				   
				}
				
//VALIDAR CONTRASEÑA
function validarPassword(){
	var pass1 = $('#password').val();
	var pass2 = $('#confirmar').val();
	var pass_1 = $('#password');
	var pass_2 = $('#confirmar');
	if(pass1 != pass2){
		alert("LAS CONTASEÑAS NO COINCIDEN POR FAVOR ESCRIBALAS NUEVAMENTE");
		pass_1.val("");
		pass_2.val("");
		pass_1.focus();
		
	}
}
//FNCION BUSCAR USUARIO
function BuscarUsuario(){
	var nombreCompleto = $('#NombreCompleto').val();
    var nombre_Completo = $('#NombreCompleto');
	var correo = $('#correo');
	var password = $('#password');
	var nombreUsuario = $('#usuario');
	var estado = $('#estado');
	var rol = $('#rol');
	
	if(nombreCompleto != null || imail != null){
	   //INSTANCAIO EL OBJETO AJAX
	   ajax = objetoAjax();
    	//USO EL METODO POST PARA SEDER LAS VARIABLOE AL ARCHIVO PHP QUE EJECUTARA LA CONSULTA
	   ajax.open("POST", "procedientos/BuscarUsuario.php");
    	ajax.onreadystatechange = function(){
	   if(ajax.readyState == 1){
	   }
	     if(ajax.readyState == 4){
				
		   if (ajax.responseText == 0){
						$('#limpiar').attr("disabled", false);
						$('#cancelar').attr("disabled", true);
						$('#enviar').attr("disabled", false);
						$('#actualizar').attr("disabled", true);
					}else{
						 alert("ESTE EMPLEADO YA CREO UN USUARIO ANTEIORMENTE");
						
						elemento = ajax.responseText;
						array = elemento.split(',');
						var exc = parseInt(array[3]);
						var cod = parseInt(array[4]);
						//ASIGNO VALORES A LOS CAMPOS			
						nombre_Completo.val(array[0]);
						correo.val(array[1]);
						nombreUsuario.val(array[2]);
						estado.val(exc);	
						rol.val(cod); 
						$('#NombreCompleto').attr("readonly", true);
						nombreUsuario.attr("readonly", true);
						correo.attr("readonly", true);
						$('#limpiar').attr("disabled", false);
						$('#actualizar').attr("disabled", false);
						$('#cancelar').attr("disabled", true);
					}
					
		     			
	       }
			 
			 
		 }
	}
		  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		  ajax.send("&nombreCompleto="+nombreCompleto);	
						   
    }

//EDITAR USUARIO
function editarUsuario(){
	var nombreCompleto = $('#NombreCompleto').val();
	var correos = $('#correo').val();
	var passwords = $('#password').val();
	var nombreUsuarios = $('#usuario').val();
	var estados = $('#estado').val();
	var rols = $('#rol').val();
	var correo = $('#correo');
	var password = $('#password');
	var nombreUsuario = $('#usuario');
	var estado = $('#estado');
	var rol = $('#rol');
	
	if(nombreCompleto != null || imail != null){
	   //INSTANCAIO EL OBJETO AJAX
	   ajax = objetoAjax();
    	//USO EL METODO POST PARA SEDER LAS VARIABLOE AL ARCHIVO PHP QUE EJECUTARA LA CONSULTA
	   ajax.open("POST", "procedientos/editarUsuario.php");
    	ajax.onreadystatechange = function(){
	   if(ajax.readyState == 1){
	   }
	     if(ajax.readyState == 4){
		  
		   if(ajax.responseText == 5){
		     alert("EL USAUARIO FUE EDITADO");
			 $('#editar').attr("disabled", true);
				$('#reset').attr("disabled", false);
		      loadModule('#content','Crear_usuario.php');	
	       }
			 if(ajax.responseText == 15){
			    alert("ALGuNO DE LOS CAMPOS NO SE HA LLENADO");
			  }
			  if(ajax.responseText == 2){
			    alert("SE HA PRESENTADO ALGÚN ERROR Y EL REGISTRO NO PUDO SER GUARDADO POR FAVOR VERIFIQUE");
			   }	
		 }
	   }
		  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		  ajax.send("nombreCompleto="+nombreCompleto+"&correo="+correos+"&password="+passwords+"&nombreUsuario="+nombreUsuarios+"&estado="+estados+"&tipo="+rols);	
						   
    }
}
//LIMPIAR USUARIO
function limpiarUsuario(){
	var nombreCompleto = $('#NombreCompleto');
	var correo = $('#correo');
	var password = $('#password');
	var nombreUsuario = $('#usuario');
	var estado = $('#estado');
	var rol = $('#rol');
	nombreCompleto.val(""),
	correo.val("");
	password.val("");
	nombreUsuario.val("");
	estado.val(0);
	rol.val(0);
	nombreCompleto.focus();
	$('#NombreCompleto').attr("readonly", false);
	correo.attr("readonly", false);
	nombreUsuario.attr("readonly", false);
	$('#actualizar').attr("disabled", true);
	$('#limpiar').attr("disabled", true);
	$('#cancelar').attr("disabled", false);
	$('#enviar').attr("disabled", true);
}
//CANCELAR USUARIO
function cancelarusuario(){
	loadModule('#content','home.php');
}
//FUNCION AUTENTICAR
function autenticar(){
	//Declaro las variables y les asigno los valores que se han ingresado en los campos por medi de el id
	var usuario = $('#usuario').val();
	var password = $('#password').val();
	var usuarios = $('#usuario');
	var passwords = $('#password');
	var error = $('#error');
			if(usuario != "NULL"){
				//INSTACION EL OBJETO AJAX
				ajax = objetoAjax();
				//USAMOS EL METODO POST AL ARCHIVO QUE RELAIZARA LA IOPERACION
				ajax.open("POST","Procedientos/validaringreso.php",true);
				ajax.onreadystatechange = function() {
						//Si el procedimiento se realiza correctamete entra por aca
						if (ajax.readyState==4) {
							if(ajax.responseText == 1){
								//Se muesta alerta de sesion iniciada
								alert("HAZ INICIADO SESION");
								//Despues de iniciar sesion se redireccina al ussuario a la pagina de inicio del sitio
								window.location="index.php";
							}
							if(ajax.responseText == 2){
									//Si la autenticacion es incorrecta se limpian los campos
								passwords.val("");
								usuarios.val("");
								usuarios.focus();
							}
							if(ajax.responseText == 5){
								alert("HAZ EXCEDIDO EL NÚMERO MÁXIMO DE AUTENTICACIONES ERRÓNEAS PERMITIDAS ; USUARIO BOQUEADO");
								passwords.val("");
								usuarios.val("");
								usuarios.focus;
							}	
							/* //verifico si la respuesa recibida es 1 se inicia la sesion 
							if(ajax.responseText == 1){
								//Se muesta alerta de sesion iniciada
								alert("HAZ INICIADO SESION");
								//Despues de iniciar sesion se redireccina al ussuario a la pagina de inicio del sitio
								window.location="index.php";
							}else{
								//Si la autenticacion es incorrecta se limpian los campos
								passwords.val("");
								usuarios.val("");
							} */
									
									
								
						}
				}
					
							
						ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
						//Se le envian los valores a la funsion PHP que realizara la autenticacion con la base de datos
						ajax.send("usuario="+usuario+"&password="+password);
				}	
			}
//FUNSION CERRAR CESSION
function logout(e){
	$(this).click(function(event){
		event.preventDefault();
	});
	//se declara el objeto ajax
	ajax = objetoAjax();
	//Se declara la funsion GET para tomar los datos de la  sesion que esta inicada para hacer el logout
	ajax.open("GET", "procedientos/cerrarsesion.php");
	//se recibe la informacion mandada por la funsin php que realizara el cierre de sesion
	ajax.onreadystatechange = function(){
		if(ajax.readyState == 4){
			//Se redirecciona a la pagina de login despues de realizar el cierre de sesion
			window.location="Inicio_Sesion.php";
		}
	}
		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		//Se declara null el metodo send por que en este caso no se enviara informacion
		ajax.send();
}	
//FUNSION PARAPAGINACION DE LAS CONSULTAS
function paginacion_js(limite, consecutivo){
	var contrato = $('#contrato').val();
	var tabla = $('#contenedorTabla');
	var url = "procedientos/filtrar.php";
	
	ajax = objetoAjax();
	ajax.open("POST", "procedientos/filtrar.php", true);
	ajax.onreadystatechange= function(){
	$.post(url, { limite:limite, contrato:contrato, consecutivo:consecutivo}, function (responText){
		tabla.html(responText);
	});
	}
		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		ajax.send("&contrato="+contrato);
} 
//FUNCION PARA REPORTES
function generarReportes(){
	var reporte = $('#tipo').val();
	var centro = $('#centro').val;
	var contrato = $('#contrato').val;
	var reporteTipo = $('#tipo');
	var centroCostos = $('#centro');
	var contratoTipo = $('#contrato');
	if(centro != null){
	   //INSTANCAIO EL OBJETO AJAX
	   ajax = objetoAjax();
    	//USO EL METODO POST PARA SEDER LAS VARIABLOE AL ARCHIVO PHP QUE EJECUTARA LA CONSULTA
	   ajax.open("POST", "procedientos/reporte1.php");
    	ajax.onreadystatechange = function(){
	   if(ajax.readyState == 1){
	   }
	     if(ajax.readyState == 4){
		   
		 }
	   }
		  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		  ajax.send("&codigo="+centro+"&contrato="+contrato+'&pdf='+reporte);	
						   
    }
}
//CANCELAR REGISTRO
function cancelarEGISTRO(){
	var nombre = $('#Nombres')
	loadModule('#content','home.php');
	nombre.focus();
	
}
//FUNCION PARA LIMPIAR LOGIN
function log(){
	var usuario = $('#usuario');
	var password = $('#password');
		usuario.val("");
		password.val("");
		usuario.focus();
		usuario.attr("readonly", false);
		password.attr("readonly", false);
		
}
//ACTIVIAR BOTON REPORTES
function enable(){
	$('#reporte').attr("disabled", false);
}
function limpiarregistrocolocadores(){
	var documento = $('#doc');
	var nombre1 = $('#nombre1');
	var apellido1 = $('#apellido1');
	var apellido2 = $('#apellido2');
	var centro_costos = $('#codigo');
	var cont = $('#contrato');
	var excep = $('#excepcion');
	var mostrar = $('#label');
		documento.val("");
		nombre1.val("");
		apellido1.val("");
		apellido2.val("");
		centro_costos.val(0);
		cont.val(0);
		excep.val(0);
		documento.focus();
		$('#registrar').attr("disabled", true);
		$('#limpiar').attr("disabled", true);
		$('#cancelar').attr("disabled", false);
}
function limpiaredicioncolocadores(){
	var documento = $('#doc');
	var nombre1 = $('#nombres');
	var apellido1 = $('#apellido1');
	var apellido2 = $('#apellido2');
	var centro_costos = $('#codigo');
	var cont = $('#contrato');
	var excep = $('#excepcion');
	var mostrar = $('#label');
		documento.val("");
		nombre1.val("");
		apellido1.val("");
		apellido2.val("");
		centro_costos.val(0);
		cont.val(0);
		excep.val(0);
		documento.focus();
		$('#actualizar').attr("disabled", true);
		$('#limpiar').attr("disabled", true);
		$('#cancelar').attr("disabled", false);
		documento.attr("readonly", false);
}
//FUNCION PARA VERIFICAR USUARIO BLOQUEADO
function usuariobloqueado(){
	var usuario = $('#usuario').val();
	var usuariobloqueado = $('#usuario');
	var password = $('#password');
	if(usuario != null || imail != null){
	   //INSTANCAIO EL OBJETO AJAX
	   ajax = objetoAjax();
    	//USO EL METODO POST PARA SEDER LAS VARIABLOE AL ARCHIVO PHP QUE EJECUTARA LA CONSULTA
	   ajax.open("POST", "procedientos/bloquear.usuario.php");
    	ajax.onreadystatechange = function(){
	   if(ajax.readyState == 1){
	   }
	     if(ajax.readyState == 4){
		    if(ajax.responseText == 5){
				alert("USUARIO BLOQUEADO");
				usuariobloqueado.val("");
				usuariobloqueado.attr("readonly", true);
				password.attr("readonly", true);
				$('#autenticar').attr("disabled", true);
			}
		   
		 }
	   }
		  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		  ajax.send("usuario="+usuario);	
						   
   }
}
//FUNSION PARA VALIDAR QUE EL USUARIO QUE VA A CAMBIAR SU CONTRASEÑA SI SEA CORRECTO
function validarcambiopassword(){
	var usuario = $('#usuario').val();
	var usuariofoco = $('#usuario');
	var password1 = $('#passwordactual1');
	var password2 = $('#passwordactual1').val();
	var array = [];
		if(usuario != "NULL"){
			//INSTACION EL OBJETO AJAX
			ajax = objetoAjax();
			//USAMOS EL METODO POST AL ARCHIVO QUE RELAIZARA LA OPERACION
			ajax.open("POST","Procedientos/verificarcontrasena.php",true);
			ajax.onreadystatechange = function() {
				if (ajax.readyState==1) {
					nom1.val("Cargando");
				}		
					if (ajax.readyState==4) {	
						
						if (ajax.responseText == 10){
							$('#passwordnuevo').attr("readonly", false);
							$('#confirmarnuevo').attr("readonly", false);
							$('#passwordnuevo').focus();
							$('#cancelar').attr("disabled", false);
						
						}else{
							alert("LA CONTRASEÑA ACTUAL NO COINCIDE CON LA INGRESADA");	
							$('#passwordnuevo').attr("readonly", true);
							$('#confirmarnuevo').attr("readonly", true);
							password1.val("");
							password1.focus();
						} 
					}				
				}
					ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
					ajax.send("usuario="+usuario+"&password2="+password2);						
		}	
}
//FUSNION PARA VALIDAR CONTRASEÑAS IGUALES EN EL MODULO DE CAMBIO DE CONTRASEÑA
function comparar(){
	var pass1 = $('#passwordnuevo').val();
	var pass2 = $('#confirmarnuevo').val();
	var pass_1 = $('#passwordnuevo');
	var pass_2 = $('#confirmarnuevo');
	if(pass1 != pass2){
		alert("!!LAS CONTRASEÑAS NO COINCIDEN!!, POR FAVOR ESCRIBALAS NUEVAMENTE");
		pass_1.val("");
		pass_2.val("");
		pass_1.focus();
		
	}else{
		$('#cambiar').attr("disabled", false);
		$('#cancelar').attr("disabled", true);
	}
}
//USUARIO CAMBIA CONTRAASEÑA
function editarcontrasena(){
	//declaro la variable tomando el valor de la contraseña
	var pass1 = $('#passwordnuevo').val();
	var usuarios = $('#usuario').val();
	//declaro las variables tomando los otros campos del modulo cambiar contraseña
	var pass_1 = $('#passwordnuevo');
	var pass_2 = $('#confirmarnuevo');
	var usuario = $('#usuario');
	var contrasena = $('#passwordactual1');
	if(pass1 != null || imail != null){
	   //INSTANCAIO EL OBJETO AJAX
	   ajax = objetoAjax();
    	//USO EL METODO POST PARA SEDER LAS VARIABLOE AL ARCHIVO PHP QUE EJECUTARA LA CONSULTA
	   ajax.open("POST", "procedientos/editarpassword.php");
    	ajax.onreadystatechange = function(){
		   if(ajax.readyState == 1){
		   }
		   if(ajax.readyState == 4){
				if(ajax.responseText == 2){
					alert("!!!CONTRASEÑA ACTUALIZADA!!!!");
					pass_1.val("");
					pass_1.val("");
					pass_2.val("");
					/* usuario.val(""); */
					contrasena.val("");
					$('#cambiar').attr("disabled", true);
					$('#limpiar').attr("disabled", true);
					$('#cancelar').attr("disabled", false);
					$('#passwordnuevo').attr("readonly", true);
					$('#confirmarnuevo').attr("readonly", true);
					usuario.focus();
				}else{
					alert("SE PRESENTO UN ERROR EN EL CAMBIO DE LA CONTRASEÑA, POR FAVOR VERIFIQUE LOS DATOS");
				}
			 }
		  
		  
		}
	   
		  ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		  ajax.send("usuario="+usuarios+"&pass1="+pass1);	
						   
    }
}
//FUNSION PARA BORAR LOS CAMPOS DE EL MODULO CAMBIAR CONTRASEÑA
function limpiarcambiarcontraseña(){
	//declaro la variable tomando el valor de la contraseña
	var pass1 = $('#passwordnuevo').val();
	var usuarios = $('#usuario').val();
	//declaro las variables tomando los otros campos del modulo cambiar contraseña
	var pass_1 = $('#passwordnuevo');
	var pass_2 = $('#confirmarnuevo');
	var usuario = $('#usuario');
	var contrasena = $('#passwordactual1');
	contrasena.val("");
	pass_1.val("");
	pass_2.val("");
	pass_1.attr("readonly", true);
	pass_2.attr("readonly", true);
	$('#cambiar').attr("disabled", true);
	$('#limpiar').attr("disabled", true);
	$('#cancelar').attr("disabled", false);
	
}
function longitudpassword(){
	var contador = 0;
	var letras = 0;
	var password = $('#passwordnuevo').val();
	var otropassword = $('#passwordnuevo');
	contador =  password.length;	
	if(contador < 5){
		alert("LA CONTRASEÑA DEBE CONTENER MÍNIMO 5 CARACTERES");
		otropassword.val("");
		otropassword.focus();
	}
}
function longitudpassword2(){
	var contador = 0;
	var password = $('#password').val();
	var otropassword = $('#password');
	contador =  password.length;	
	if(contador < 5){
		alert("LA CONTRASEÑA DEBE CONTENER MÍNIMO 5 CARACTERES");
		otropassword.val("");
		otropassword.focus();
	}
}
//FUNSION PARA MOSTRAR LA AUDITORIA DE COLOCADORES
function auditoriacolocadores(limite, consecutivo){
	var colocador = $('#colocadorauditoria').val();
	var tabla = $('#contenedorTabla');
	var url = "procedientos/auditoriacolocadores.php";
	
	ajax = objetoAjax();
	ajax.open("POST", "procedientos/auditoriacolocadores.php", true);
	ajax.onreadystatechange= function(){
	$.post(url, { limite:limite, colocador:colocador, consecutivo:consecutivo}, function (responText){
		tabla.html(responText);
	});
	}
		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		ajax.send("&colocador="+colocador);
} 
//FUNSION PARA CONTROALR QUE SEIMPRE QUE HAYA UNA EDICION DE COLOCADORES MODIFIQUEN ALGUNO DE LOS CAMPO, DE LO CANTRARIO NO PEMRITIRA GUARDAR
function controlaredicion(){
	$('#cancelar').attr("disabled", true);
	$('#limpiar').attr("disabled", false);
	$('#actualizar').attr("disabled", false);
}
//+++++++++++++++++++++++++++++++++
 function soloLetras(e){
 key = e.keyCode || e.which;
 tecla = String.fromCharCode(key).toLowerCase();
 letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
 especiales = [8,37,39,46];

 tecla_especial = false
 for(var i in especiales){
     if(key == especiales[i]){
  tecla_especial = true;
  break;
            } 
 }
 
        if(letras.indexOf(tecla)==-1 && !tecla_especial)
     return false;
     }
//auditoria usuario
function auditoriausuarios(limite, consecutivo){
	var usuario = $('#usuarioauditoria').val();
	var usuario_nombre = $('#usuarioauditoria');
	var tabla = $('#contenedorTabla');
	var url = "procedientos/auditoriausuarios.php";
	
	ajax = objetoAjax();
	ajax.open("POST", "procedientos/auditoriausuarios.php", true);
	ajax.onreadystatechange= function(){
	$.post(url, { limite:limite, usuario:usuario, consecutivo:consecutivo}, function (responText){
		
		tabla.html(responText);
	
	});
	}
		ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
		ajax.send("&usuario="+usuario);
}



