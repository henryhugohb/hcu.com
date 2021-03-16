$(document).ready(function(){
	$("#a-cancelar").hide();
	$("#a-eliminar").hide();
	$("#a-inactivar").hide();
	$("#p-cedula").focus();
});

function validaCedula()
{
	var ncedula = $("#p-cedula").val();
	var nncedula = ncedula.length;
	if (nncedula<10 || nncedula>10)
	{
		alert("Cedula Incorrecta: Debe contener diez digitos.");
		$("#p-cedula").focus();
		return false;
	}
	else
	{
		var provincia = ncedula[0] + ncedula[1];
		if (provincia>24 || provincia<1)
		{
			alert("Cedula Incorrecta: Error en el Numero de la provincia.");
			$("#p-cedula").focus();
			return false;
		}
		else
		{
			if (ncedula[2]>5)
			{
				alert("Cedula Incorrecta: Error en tercer Digito.");
				$("#p-cedula").focus();
				return false;
			}
			else
			{
				var resultado =0;
				var acumularesultado =0;
				var dsuperior=0;
				var ultimodigito = 0;
				var decena = " ";
				for (var i = 0; i < (nncedula-1); i++)
				{
					multiplicador = i%2;
					if (multiplicador==0) {multiplicador=2;}
					resultado = ncedula[i] * multiplicador;
					if (resultado>=10){ resultado=resultado-9;}
					acumularesultado = acumularesultado + resultado;
				}
				decena = acumularesultado + "";
				decena.length;
				dsuperior = (decena[0]*10)+10;
				ultimodigito = dsuperior - acumularesultado;
				if(ultimodigito==10){ultimodigito=0;}
				if(ultimodigito!=ncedula[9])
				{
					alert("Cedula Incorrecta: Revise que este escrita correctamente.");
					$("#p-cedula").focus();
					return false;
				}
				else
				{
					return true;
				}
			}
		}
	}	
}
$("#p-cedula").keypress(function(e){
	if(e.which == 13)
	{
		if(validaCedula())
		{
			$("#p-apellidos").focus();			
		}
		return false;
	}
});

$("#p-pin").keypress(function(e){
	if(e.which == 13)
	{
		$("#p-observacion").focus();			
		return false;
	}
});

$("#p-observacion").keypress(function(e){
	if(e.which == 13)
	{
		$("#a-generar").click();			
		return false;
	}
});

$("#a-generar").click(function(){
	if($("#p-fecha").val()=="")
	{
		alert("Debe ingresar la fecha de nacimiento!");
		$("#p-fecha").focus();
	}
	else
	{
		if($("#p-apellidos").val().trim()=="")
		{
			alert("Debe ingresar los apelidos del profesional");
			$("#p-apellidos").focus();	
		}
		else
		{
			if($("#p-nombres").val().trim()=="")
			{
				alert("Debe ingresar los nombres del profesianal");
				$("#p-nombres").focus();
			}
			else
			{
				if($("#p-pin").val().trim()=="")
				{
					alert("Debe ingresar un codigo pin de 4 digitos para su ingreso al sistema");
					$("#p-pin").focus();	
				}
				else
				{
					if(!validaCedula())
					{
						alert("Debe ingresar un numero de cedula valido");
						$("#p-cedula").focus();
					}
					else
					{
						if($('#a-generar').val()=="Guardar")
						{
							var parametros = {
			        			pro_cedula: $("#p-cedula").val(),
			        			/*pro_apellidos: $("#p-apellidos").val(),
			        			pro_nombres: $("#p-nombres").val(),
			        			pro_fecha_nacimiento: $("#p-fecha").val(),
			        			pro_especialidad: $("#p-especialidad").val(),
			        			pro_pin: $("#p-pin").val(),
			        			pro_observacion: $("#p-observacion").val(),*/
			        			tipo_trans: "guarda"
			    			}
						}
						else
						{
							if($('#a-generar').val()=="Actualizar")
							{
								var r= confirm("Esta seguro de guardar los cambios?");
								if(r==true)
								{
									var parametros = {
					        			pro_cedula: $("#p-cedula").val(),
					        			/*pro_apellidos: $("#p-apellidos").val(),
					        			pro_nombres: $("#p-nombres").val(),
					        			pro_fecha_nacimiento: $("#p-fecha").val(),
					        			pro_especialidad: $("#p-especialidad").val(),
					        			pro_pin: $("#p-pin").val(),
					        			pro_observacion: $("#p-observacion").val(),
					        			*/pro_codigo: $("#a-codigo").attr('alt'),
					        			tipo_trans: "modifica"
				    				}
								}
								else
								{
									return false;
								}
							}
						}
						$.ajax({
					        url: "assets/includes/datosProfesional.php",
					        type: 'POST',
					        async: false,
					        data: parametros,
					        dataType: "json",
					        success: function (respuesta)
					        {
					        	if(respuesta.codigo == 1)
					          	{
					            	alert(respuesta.mensaje);
					          	}
					          	else
					          	{
					          		if(respuesta.codigo==2)
					          		{
					          			$('#r-agendas').html("Procesando...");
										if($("#a-generar").val()=="Guardar")
										{
											var tipo_tipo = "guarda-p";
											var cod_cod = 0;
										}
										else
										{
											if($("#a-generar").val()=="Actualizar")
											{
												var tipo_tipo = "modifica-p";	
												var cod_cod = $("#a-codigo").attr("alt");
											}
										}
										var parametros_envio = {
											pro_cedula: $("#p-cedula").val(),
						        			pro_apellidos: $("#p-apellidos").val().toUpperCase(),
						        			pro_nombres: $("#p-nombres").val().toUpperCase(),
						        			pro_fecha_nacimiento: $("#p-fecha").val(),
						        			pro_especialidad: $("#p-especialidad").val(),
						        			pro_pin: $("#p-pin").val(),
						        			pro_observacion: $("#p-observacion").val().toUpperCase(),
											tipo_trans: tipo_tipo,
											pro_codigo: cod_cod
										}
										$.ajax({
									        url: "assets/includes/datosProfesional.php",
									        type: 'POST',
									        async: false,
									        data: parametros_envio,
									        dataType: "json",
									        success: function (respuesta)
									        {
									        	if(respuesta.codigo == 1)
									          	{
									            	alert(respuesta.mensaje);
									            	$("#menu32").click();
									          	}
									          	else
									          	{
									          		alert(respuesta.mensaje);
									          	}
									        }, 
									        error: function (error) {
									          console.log("ERROR: " + error);
									        }
								    	});
					          		}
					          		else
					          		{
										alert(respuesta.mensaje);	
					          		}
					          	}
					        }, 
					        error: function (error) {
					          console.log("ERROR: " + error);
					        }
						});
					}
				}
			}
		}
	}
});

$(".a-editar").click(function(){
	var r= confirm("Esta seguro de modificar el registro actual?");
	if(r==true)
	{
		var parametros_envio = {
			tipo_trans: "consulta",
			pro_codigo: $(this).attr('alt')
		}
		$.ajax({
	        url: "assets/includes/datosProfesional.php",
	        type: 'POST',
	        async: false,
	        data: parametros_envio,
	        dataType: "json",
	        success: function (respuesta)
	        {
	        	if(respuesta.codigo == 1)
	          	{
	            	$("#p-cedula").val(respuesta.pro_cedula);
	            	$("#p-cedula").css({'background-color' : '#99FF33'});
					$("#p-apellidos").val(respuesta.pro_apellidos);
					$("#p-apellidos").css({'background-color' : '#99FF33'});
					$("#p-nombres").val(respuesta.pro_nombres);
					$("#p-nombres").css({'background-color' : '#99FF33'});
					$("#p-fecha").val(respuesta.pro_fecha_nacimiento);
					$("#p-fecha").css({'background-color' : '#99FF33'});
					$("#p-especialidad").val(respuesta.pro_especialidad);
					$("#p-especialidad").css({'background-color' : '#99FF33'});
					$("#p-pin").val(respuesta.pro_pin);
					$("#p-pin").css({'background-color' : '#99FF33'});
					$("#p-observacion").val(respuesta.pro_observacion);
					$("#p-observacion").css({'background-color' : '#99FF33'});
					$("#a-codigo").attr('alt',respuesta.pro_codigo);
					$("#a-generar").val("Actualizar");
					$("#a-cancelar").fadeIn();
					$("#a-eliminar").fadeIn();
					$("#a-inactivar").fadeIn();
					$("#p-cedula").focus();
	          	}
	          	else
	          	{
	          		alert(respuesta.mensaje);
	          	}
	        }, 
	        error: function (error) {
	          console.log("ERROR: " + error);
	        }
	    });
	}
});

$("#a-cancelar").click(function(){
	$("#menu32").click();
});

$("#a-eliminar").click(function(){
	var r= confirm("Esta seguro de eliminar el registro actual?");
	if(r==true)
	{
		var tipo_tipo = "elimina";
		var cod_cod = $("#a-codigo").attr("alt");
		var parametros_envio = {
			tipo_trans: tipo_tipo,
			pro_codigo: cod_cod
		}
		$.ajax({
	        url: "assets/includes/datosProfesional.php",
	        type: 'POST',
	        async: false,
	        data: parametros_envio,
	        dataType: "json",
	        success: function (respuesta)
	        {
	        	if(respuesta.codigo == 1)
	          	{
	            	alert(respuesta.mensaje);
	            	$("#menu32").click();
	          	}
	          	else
	          	{
	          		alert(respuesta.mensaje);
	          	}
	        }, 
	        error: function (error) {
	          console.log("ERROR: " + error);
	        }
		});
	}
});

$("#a-inactivar").click(function(){
	var r= confirm("Esta seguro de Inactivar el registro actual?");
	if(r==true)
	{
		var tipo_tipo = "inactiva";
		var cod_cod = $("#a-codigo").attr("alt");
		var parametros_envio = {
			tipo_trans: tipo_tipo,
			pro_codigo: cod_cod
		}
		$.ajax({
	        url: "assets/includes/datosProfesional.php",
	        type: 'POST',
	        async: false,
	        data: parametros_envio,
	        dataType: "json",
	        success: function (respuesta)
	        {
	        	if(respuesta.codigo == 1)
	          	{
	            	alert(respuesta.mensaje);
	            	$("#menu32").click();
	          	}
	          	else
	          	{
	          		alert(respuesta.mensaje);
	          	}
	        }, 
	        error: function (error) {
	          console.log("ERROR: " + error);
	        }
		});
	}
});

