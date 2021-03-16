$(document).ready(function(){
	$("#hcu").val("");
	$("#hcu").focus();
});

$("#hcu").keypress(function(e){
	if(e.which == 13)
	{
		$("#enviarBusqueda").click();
		return false;
	}
});

function llenarNombres()
{
	$("#apellidos").val('Buscando...');
	var parametros = {
		nArchivo: $("#hcu").val(),
		tipo_id: "hcu",
		tipo_trans: "busca-paciente"
	}
	$.ajax({
        url: "assets/includes/datosCitas.php",
        type: 'POST',
        async: false,
        data: parametros,
        dataType: "json",
        success: function (respuesta)
        {
        	if(respuesta.codigo == 1)
          	{
            	$("#apellidos").val(respuesta.mensaje);
            	$("#na").val(respuesta.n_d_archivo);
            	if(respuesta.observa_pac.trim()=="")
            	{
            		$("#observacion").val("Ninguna");
            	}
            	else
            	{
            		$("#observacion").val(respuesta.observa_pac);
            	}
            	$("#enviarBusqueda").focus();
            }
          	else
          	{
          		if(respuesta.codigo == 2)
          		{
          			$("#apellidos").val("No existen datos que mostrar");
          			$("#na").val("");
          			$("#observacion").val("");
          			$("#telefono").val("");
          			$("#tarjetero").val("");
          			$("#hcu").focus();
	          	}
          	}
        }, 
        error: function (error) {
          console.log("ERROR: " + error);
          alert(error);
        }
	});
}

function verificarTarjetero()
{
	$("#na").val($("#na").val().trim());
	var parametros ={
		adm_na: $("#na").val()
	}
	var encset=0;
	$.ajax({
		url: "assets/includes/consultaEdicion.php",
		type: "POST",
		async: false,
		data: parametros,
		dataType: "json",
		success: function(respuesta)
		{
			if(respuesta.codigo==1)
			{
				encset=1;
				$("#telefono").val('');
				$("#tarjetero").attr('Style','color:red;');
				$("#tarjetero").val('Actualizar');
			}
			else
			{
				if(respuesta.codigo==5)
				{
					encset=1;
					$("#telefono").val(respuesta.tar_telefono);
					$("#tarjetero").attr('Style','color:green;');
					$("#tarjetero").val('Ingresado');
				}
			}
		},
		error: function(error) {
			console.log("ERROR: "+error);
		}
	});
}

function buscarAgenda()
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
	xmlhttp.open("GET","assets/includes/rAgendasHistorial.php?narchivo="+$("#na").val()+"&profesional="+$("#a-profesional").val()+"",true);
	xmlhttp.send();
	xmlhttp.onreadystatechange = function()
	{
		if(xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			$("#resultado-busqueda").html(xmlhttp.responseText);
		}
	}
}

function buscarefe()
{
	$("#resultado-busqueda2").html("<spam><b>Procesando...</b></spam>");
	if(window.XMLHttpRequest)
	{
		xmlhttp2 = new XMLHttpRequest();
	}
	else
	{
		xmlhttp2 = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp2.open("GET","assets/includes/resultadoReferenciaHistorial.php?paciente="+$("#hcu").val()+"",true);
	xmlhttp2.send();
	xmlhttp2.onreadystatechange = function()
	{
		if(xmlhttp2.readyState==4 && xmlhttp2.status==200)
		{
			$("#resultado-busqueda2").html(xmlhttp2.responseText);
		}
	}
}

function buscarIcm()
{
	$("#resultado-busqueda3").html("<spam><b>Procesando...</b></spam>");
	if(window.XMLHttpRequest)
	{
		xmlhttp3 = new XMLHttpRequest();
	}
	else
	{
		xmlhttp3 = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp3.open("GET","assets/includes/resultadoEtareoHistorial.php?hcu="+$("#hcu").val()+"",true);
	xmlhttp3.send();
	xmlhttp3.onreadystatechange = function()
	{
		if(xmlhttp3.readyState==4 && xmlhttp3.status==200)
		{
			$("#resultado-busqueda3").html(xmlhttp3.responseText);
		}
	}
}

$("#enviarBusqueda").click(function(){
	llenarNombres();
	if($("#apellidos").val() != "No existen datos que mostrar")
	{
		verificarTarjetero();
		buscarAgenda();
		buscarefe();
		buscarIcm();
	}
	else
	{
		$("#resultado-busqueda").html("");
		$("#resultado-busqueda2").html("");
		$("#resultado-busqueda3").html("");
	}
});