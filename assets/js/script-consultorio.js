$(document).ready(function(){
	$("#a-cancelar").hide();
	$("#a-eliminar").hide();
	$("#l-descripcion").focus();
});

$("#l-descripcion").keypress(function(e){
	if(e.which == 13)
	{
		if(($("#l-descripcion").val()).trim()!="")
		{
			$("#l-observacion").focus();
		}			
		return false;
	}
});

$("#l-observacion").keypress(function(e){
	if(e.which == 13)
	{
		$("#a-generar").click();			
		return false;
	}
});

$("#a-generar").click(function(){
	if($("#l-descripcion").val()=="")
	{
		alert("Debe ingresar la descripcion del consultorio!");
		$("#l-descripcion").focus();
	}
	else
	{
		var r= confirm("Esta seguro de guardar los cambios?");
		if(r==true)
		{
			if($('#a-generar').val()=="Guardar")
			{
				var parametros = {
	    			loc_descripcion: $("#l-descripcion").val(),
					tipo_trans: "guarda"
				};
			}
			else
			{
				if($('#a-generar').val()=="Actualizar")
				{
				
					var parametros = {
	        			loc_descripcion: $("#l-descripcion").val(),
	        			loc_codigo: $("#a-codigo").attr('alt'),
	        			tipo_trans: "modifica"
    				};
				}
			}
		}
		else
		{
			return false;
		}
		$.ajax({
	        url: "assets/includes/datosConsultorio.php",
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
							loc_descripcion: $("#l-descripcion").val().toUpperCase(),
		        			loc_observacion: $("#l-observacion").val().toUpperCase(),
							tipo_trans: tipo_tipo,
							loc_codigo: cod_cod
						}
						$.ajax({
					        url: "assets/includes/datosConsultorio.php",
					        type: 'POST',
					        async: false,
					        data: parametros_envio,
					        dataType: "json",
					        success: function (respuesta)
					        {
					        	if(respuesta.codigo == 1)
					          	{
					            	alert(respuesta.mensaje);
					            	$("#menu33").click();
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
});

$(".a-editar").click(function(){
	var r= confirm("Esta seguro de modificar el registro actual?");
	if(r==true)
	{
		var parametros_envio = {
			tipo_trans: "consulta",
			loc_codigo: $(this).attr('alt')
		}
		$.ajax({
	        url: "assets/includes/datosConsultorio.php",
	        type: 'POST',
	        async: false,
	        data: parametros_envio,
	        dataType: "json",
	        success: function (respuesta)
	        {
	        	if(respuesta.codigo == 1)
	          	{
	            	$("#l-descripcion").val(respuesta.loc_descripcion);
	            	$("#l-descripcion").css({'background-color' : '#99FF33'});
					$("#l-observacion").val(respuesta.loc_observacion);
					$("#l-observacion").css({'background-color' : '#99FF33'});
					$("#a-codigo").attr('alt',respuesta.loc_codigo);
					$("#a-generar").val("Actualizar");
					$("#a-cancelar").fadeIn();
					$("#a-eliminar").fadeIn();
					$("#l-descripcion").focus();
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
	$("#menu33").click();
});

$("#a-eliminar").click(function(){
	var r= confirm("Esta seguro de eliminar el registro actual?");
	if(r==true)
	{
		var tipo_tipo = "elimina";
		var cod_cod = $("#a-codigo").attr("alt");
		var parametros_envio = {
			tipo_trans: tipo_tipo,
			loc_codigo: cod_cod
		}
		$.ajax({
	        url: "assets/includes/datosConsultorio.php",
	        type: 'POST',
	        async: false,
	        data: parametros_envio,
	        dataType: "json",
	        success: function (respuesta)
	        {
	        	if(respuesta.codigo == 1)
	          	{
	            	alert(respuesta.mensaje);
	            	$("#menu33").click();
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

