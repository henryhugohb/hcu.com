$(document).ready(function(){
	if($("#mes").attr('alt')==0)
	{
		$("#anio-reporte").focus();
		$("#mes").hide();
		$("#enviarBusqueda").hide();
	}
	else
	{
		if($("#mes").attr('alt')==1)
		{
			llenarMes();
			$("#enviarBusqueda").show();
			$("#mes").focus();
		}
		else
		{
			llenarMes();
			$("#enviarBusqueda").show();
			$("#anio-reporte").focus();	
		}
	}
	$("#operaciones").hide();
	$("#datos-cita").hide();
});

function llenarMes()
{
	var parametros = {
        ref_anio: $("#anio-reporte").val(),
        tipo_trans: 'mesReferenciaTotal'
    }

    $.ajax({
        url: "assets/includes/datosReferencia.php",
        type: 'POST',
        async: false,
        data: parametros,
        dataType: "json",
        success: function (respuesta)
        {
        	if(respuesta.codigo == 1)
          	{
            	$("#mes").html(respuesta.mensaje);
          	}
          	else
          	{
          		$("#mes").html(respuesta.mensaje);
          	}
        }, 
        error: function (error) {
          console.log("ERROR: " + error);
        }
    });
}


$("#enviarBusqueda").click(function(){
	$("#resultado-busqueda").html("<spam><b>Procesando...</b></spam>");
	if(window.XMLHttpRequest)
	{
		xmlhttp = new XMLHttpRequest();
	}
	else
	{
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.open("GET","assets/includes/resultadoReferencia.php?fecha="+$("#anio-reporte").val()+"-"+$("#mes").val()+"&profesional="+$("#profesional").html()+"",true);
	xmlhttp.send();
	xmlhttp.onreadystatechange = function()
	{
		if(xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			$("#operaciones").hide();
			$("#datos-cita").hide();
			$("#resultado-busqueda").html(xmlhttp.responseText);
		}
	}
});

$("#mostrar-cita").click(function(){
	$("#datos-cita").show();
	$("#fecha-cita").focus();
});

$("#guarda-cita").click(function(){
	if($("#fecha-cita").val()==0)
	{
		alert("Ingrese una fecha valida");
		$("#fecha-cita").focus();	
	}
	else
	{
		if($("#hora-cita").val()==0)
		{
			alert("Ingrese una hora valida");
			$("#hora-cita").focus();	
		}
		else
		{
			if($("#medico-cita").val().trim()=="")
			{
				alert("Ingrese el nombre del profesional");
				$("#medico-cita").focus();	
			}
			else
			{
				var r = confirm("Esta seguro de guardar el registro?");
				if(r==true)
				{
					//alert("No tienes permisos para realizar la operacion");

					var parametros = {
				        ref_codigo: $("#n-referencia").html(),
				        ref_fecha_cita: $("#fecha-cita").val(),
				        ref_hora_cita: $("#hora-cita").val(),
				        ref_especialista_nombre: $("#medico-cita").val().trim().toUpperCase(),
				        tipo_trans: 'asignarCita'
				    }

				    $.ajax({
				        url: "assets/includes/datosReferencia.php",
				        type: 'POST',
				        async: false,
				        data: parametros,
				        dataType: "json",
				        success: function (respuesta)
				        {
				        	if(respuesta.codigo == 1)
				          	{
				            	alert(respuesta.mensaje);
				            	$("#enviarBusqueda").click();
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
			}
		}
	}
	//alert("aun no programado");
});

$("#medico-cita").keypress(function(e){
	if(e.which == 13)
	{
		$("#guarda-cita").click();
		return false;
	}
});

$("#estado-cita").click(function(){
	var r = confirm("Esta seguro de cambiar el Estado?");
	if(r==true)
	{
		//alert("No tienes permisos para realizar la operacion");

		var parametros = {
	        ref_codigo: $("#n-referencia").html(),
	        ref_estado_ref: $("#r-estado").val(),
			tipo_trans: 'estadoCita'
	    }

	    $.ajax({
	        url: "assets/includes/datosReferencia.php",
	        type: 'POST',
	        async: false,
	        data: parametros,
	        dataType: "json",
	        success: function (respuesta)
	        {
	        	if(respuesta.codigo == 1)
	          	{
	            	alert(respuesta.mensaje);
	            	$("#enviarBusqueda").click();
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
	//alert("aun no programado");
});