$(document).ready(function(){
	if($("#mes").val()=='*')
	{
		$("#enviarBusqueda").hide();
	}
	else
	{
		$("#enviarBusqueda").show();
	}
	$("#mes").focus();
});

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
	xmlhttp.open("GET","assets/includes/resultadoEtareo.php?mes="+$("#mes").val()+"&profesional="+$("#profesional").html()+"",true);
	xmlhttp.send();
	xmlhttp.onreadystatechange = function()
	{
		if(xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			$("#resultado-busqueda").html(xmlhttp.responseText);
		}
	}
});