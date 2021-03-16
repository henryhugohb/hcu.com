$(document).ready(function(){
	$("#nombres").hide();
	$("#apellidos").hide();
	$("#apellidos").hide();
	$("#lnombres").hide();
	$("#nArchivo").hide();
	$("#hcu").focus();
});

$("#b-hcu").click(function(){
	$("#nombres").fadeOut();
	$("#nombres").val('');
	$("#lnombres").fadeOut();
	$("#apellidos").fadeOut();
	$("#apellidos").val('');
	$("#nArchivo").fadeOut();
	$("#nArchivo").val('');
	$("#hcu").fadeIn();
	$("#hcu").focus();
});

$("#hcu").keypress(function(e){
	if(e.which == 13)
	{
		$("#enviarBusqueda").click();
		return false;
	}
});

$("#b-apellidos").click(function(){
	$("#hcu").fadeOut();
	$("#hcu").val('');
	$("#nArchivo").fadeOut();
	$("#nArchivo").val('');
	$("#apellidos").fadeIn();
	$("#lnombres").fadeIn();
	$("#nombres").fadeIn();
	$("#apellidos").focus();
});

$("#nombres").keypress(function(e){
	if(e.which == 13)
	{
		$("#enviarBusqueda").click();
		return false;
	}
});

$("#apellidos").keypress(function(e){
	if(e.which == 13)
	{
		$("#enviarBusqueda").click();
		return false;
	}
});

$("#b-na").click(function(){
	$("#hcu").fadeOut();
	$("#hcu").val('');
	$("#nombres").fadeOut();
	$("#nombres").val('');
	$("#lnombres").fadeOut();
	$("#apellidos").fadeOut();
	$("#apellidos").val('');
	$("#nArchivo").fadeIn();
	$("#nArchivo").focus();
});

$("#nArchivo").keypress(function(e){
	if(e.which == 13)
	{
		$("#enviarBusqueda").click();
		return false;
	}
});

$("#t-activos").click(function(){
	$("#enviarBusqueda").click();
});

$("#t-pasivos").click(function(){
	$("#enviarBusqueda").click();
});

$("#t-todos").click(function(){
	$("#enviarBusqueda").click();
});

$("#enviarBusqueda").click(function(){
	var Vhcu,Vna,Vn,Va,Vtipo ="";
	Vhcu = $("#hcu").val();
	Vhcu = Vhcu.trim();
	Vna = $("#nArchivo").val();
	Vna = Vna.trim();
	Vn = $("#nombres").val();
	Vn = Vn.trim();
	Va = $("#apellidos").val();
	Va = Va.trim();
	Vtipo = $("input:radio[name=t-resultado]:checked").val();
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
		xmlhttp.open("GET","assets/includes/resultadoBuscar.php?vhcu="+Vhcu+"&vna="+Vna+"&vn="+Vn+"&va="+Va+"&vtipo="+Vtipo,true);
		xmlhttp.send();
		xmlhttp.onreadystatechange = function()
		{
			if(xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				$("#resultado-busqueda").html(xmlhttp.responseText);
			}
		}
	}
});