$(document).ready(function(){
	$("#a-cancelar").hide();
	$("#a-eliminar").hide();
	$("#a-fecha").focus();
});

$("#a-generar").click(function(){
	//$("#a-cupos").val() = ($("#a-cupos").val()).trim();
	if($("#a-fecha").val()=="")
	{
		alert("Debe selecionar primero la fecha!");
		$("#a-fecha").focus();
	}
	else
	{
		if($("#a-h-inicio").val()=="")
		{
			alert("Debe ingresar la hora de inicio");
			$("#a-h-inicio").focus();	
		}
		else
		{
			if($("#a-h-fin").val()=="" || ($("#a-h-fin").val()<=$("#a-h-inicio").val()))
			{
				alert("Debe ingresar la hora de fin");
				$("#a-h-fin").focus();
			}
			else
			{
				if($('#a-generar').val()=="Generar")
				{
					var parametros = {
	        			fecha: $("#a-fecha").val(),
	        			locacion: $("#a-locacion").val(),
	        			hora_inicio: $("#a-h-inicio").val(),
	        			hora_fin: $("#a-h-fin").val(),
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
			        			fecha: $("#a-fecha").val(),
			        			locacion: $("#a-locacion").val(),
			        			profesional: $("#a-profesional").val(),
			        			hora_inicio: $("#a-h-inicio").val(),
			        			hora_fin: $("#a-h-fin").val(),
			        			age_codigo: $("#a-codigo").attr('alt'),
			        			tipo_trans: "modifica"
		    				}
						}
					}
				}
				$.ajax({
			        url: "assets/includes/verificaAgenda.php",
			        type: 'POST',
			        async: false,
			        data: parametros,
			        dataType: "json",
			        success: function (respuesta)
			        {
			        	if(respuesta.codigo == 1)
			          	{
			            	alert(respuesta.mensaje);
			            	//$("#narchivo").val(respuesta.data);
			          	}
			          	else
			          	{
			          		if(respuesta.codigo==2)
			          		{
			          			$('#r-agendas').html("Procesando...");
								if($("#a-generar").val()=="Generar")
								{
									var tipo_tipo = "guarda";
									var cod_cod = 0;
								}
								else
								{
									if($("#a-generar").val()=="Actualizar")
									{
										var tipo_tipo = "modifica";	
										var cod_cod = $("#a-codigo").attr("alt");
									}
								}
								var parametros_envio = {
									age_fecha: $("#a-fecha").val(),
									age_locacion: $("#a-locacion").val(),
									age_profesional: $("#a-profesional").val(),
									age_hora_inicio: $("#a-h-inicio").val(),
									age_hora_fin: $("#a-h-fin").val(),
									tipo_trans: tipo_tipo,
									age_codigo: cod_cod
								}
								$.ajax({
							        url: "assets/includes/guardarAgenda.php",
							        type: 'POST',
							        async: false,
							        data: parametros_envio,
							        dataType: "json",
							        success: function (respuesta)
							        {
							        	if(respuesta.codigo == 1)
							          	{
							            	alert(respuesta.mensaje);
							            	$("#menu51").click();
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
			          			if(respuesta.codigo==3)
			          			{	
									var tipo_tipo = "cambia_consultorio";	
									var cod_cod = $("#a-codigo").attr("alt");
									var parametros_envio = {
										age_fecha: $("#a-fecha").val(),
										age_locacion: $("#a-locacion").val(),
										age_profesional: $("#a-profesional").val(),
										age_hora_inicio: $("#a-h-inicio").val(),
										age_hora_fin: $("#a-h-fin").val(),
										tipo_trans: tipo_tipo,
										age_codigo: cod_cod
									};
									$.ajax({
								        url: "assets/includes/guardarAgenda.php",
								        type: 'POST',
								        async: false,
								        data: parametros_envio,
								        dataType: "json",
								        success: function (respuesta)
								        {
								        	if(respuesta.codigo == 1)
								          	{
								            	alert(respuesta.mensaje);
								            	$("#menu51").click();
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
			          	}
			        }, 
			        error: function (error) {
			          console.log("ERROR: " + error);
			        }
				});
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
			age_codigo: $(this).attr('value')
		}
		$.ajax({
	        url: "assets/includes/verificaAgenda.php",
	        type: 'POST',
	        async: false,
	        data: parametros_envio,
	        dataType: "json",
	        success: function (respuesta)
	        {
	        	if(respuesta.codigo == 1)
	          	{
	            	$("#a-fecha").val(respuesta.age_fecha);
	            	$("#a-fecha").css({'background-color' : '#99FF33'});
					$("#a-locacion").val(respuesta.age_locacion);
					$("#a-locacion").css({'background-color' : '#99FF33'});
					$("#a-profesional").val(respuesta.age_profesional);
					$("#a-profesional").css({'background-color' : '#99FF33'});
					$("#a-h-inicio").val(respuesta.age_hora_inicio);
					$("#a-h-inicio").css({'background-color' : '#99FF33'});
					$("#a-h-fin").val(respuesta.age_hora_fin);
					$("#a-h-fin").css({'background-color' : '#99FF33'});
					$("#a-codigo").attr('alt',respuesta.age_codigo);
					$("#a-generar").val("Actualizar");
					$("#a-cancelar").fadeIn();
					$("#a-eliminar").fadeIn();
					$("#a-fecha").focus();
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
	$("#menu51").click();
});

$("#a-eliminar").click(function(){
	var r= confirm("Esta seguro de eliminar el registro actual?");
	if(r==true)
	{
		var tipo_tipo = "elimina";	
		var cod_cod = $("#a-codigo").attr("alt");
		var parametros_envio = {
			tipo_trans: tipo_tipo,
			age_codigo: cod_cod
		}
		$.ajax({
	        url: "assets/includes/guardarAgenda.php",
	        type: 'POST',
	        async: false,
	        data: parametros_envio,
	        dataType: "json",
	        success: function (respuesta)
	        {
	        	if(respuesta.codigo == 1)
	          	{
	            	alert(respuesta.mensaje);
	            	$("#menu51").click();
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

/*$("#nArchivo").keypress(function(e){
	if(e.which == 13)
	{
		$("#enviarBusqueda").click();
		return false;
	}
});
$("#enviarBusqueda").click(function(){
	var Vhcu,Vna,Vn,Va ="";
	Vhcu = $("#hcu").val();
	Vhcu = Vhcu.trim();
	Vna = $("#nArchivo").val();
	Vna = Vna.trim();
	Vn = $("#nombres").val();
	Vn = Vn.trim();
	Va = $("#apellidos").val();
	Va = Va.trim();
	if ((Vhcu == "" ) && ( Vna == "" ) && (Vn == "") && (Va == "")) 
	{
		alert("Seleccione al menos una opcion de busqueda!");
	}
	else
	{
		$("#resultado-busqueda").html("<spam><b>Procesando...</b></spam>");
		if(window.XMLHttpRequest)
		{
			xmlhttp = new XMLHttpRequest();
		}
		else
		{
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.open("GET","assets/includes/resultadoBuscar.php?vhcu="+Vhcu+"&vna="+Vna+"&vn="+Vn+"&va="+Va,true);
		xmlhttp.send();
		xmlhttp.onreadystatechange = function()
		{
			if(xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				$("#resultado-busqueda").html(xmlhttp.responseText);
			}
		}
	}
});*/