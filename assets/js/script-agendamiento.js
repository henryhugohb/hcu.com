$(document).ready(function(){
	$("#anio-reporte").focus();
});

$("#a-generar").click(function(){
	$("#r-agendas").html("<spam><b>Procesando...</b></spam>");
	if(window.XMLHttpRequest)
	{
		xmlhttp = new XMLHttpRequest();
	}
	else
	{
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.open("GET","assets/includes/rAgendamiento.php?mes="+$("#mes-reporte").val()+"&espe="+$("#especialidad-reporte").val()+"&tipo="+$("#tipo-reporte").val()+"&anio="+$("#anio-reporte").val()+"",true);
	xmlhttp.send();
	xmlhttp.onreadystatechange = function()
	{
		if(xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			$("#r-agendas").html(xmlhttp.responseText);
		}
	}
});


/*
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