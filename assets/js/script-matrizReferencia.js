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
});

function llenarMes()
{
	var parametros = {
        ref_profesional: $("#profesional").attr('alt'),
        ref_anio: $("#anio-reporte").val(),
        tipo_trans: 'mesReferencia'
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
	$("#operaciones").hide();
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
			$("#resultado-busqueda").html(xmlhttp.responseText);
		}
	}
});

$("#eliminar-ref").click(function(){
	//alert($("#n-registro").html());
	var r= confirm("Esta seguro de eliminar el registro actual?");
	if(r==true)
	{
		var parametros = {
	        ref_codigo: $("#n-registro").html(),
	        tipo_trans: 'eliminaReferencia'
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
});