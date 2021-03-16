$(document).ready(function(){
	llenarInstitucion();
	llenarDatosBasicos();
	llenarCombo('tb_provincia','cod_provincia','0','pro_presentar','0','#p-pr');
	calcularEdad();
	$("#p-pr").focus();
});

function llenarInstitucion()
{
	var parametros = {
		institucion:'015689'
	}
	$.ajax({
		url: 'assets/includes/llenarInstitucion.php',
		type: 'POST',
		async: false,
		data: parametros,
		dataType: 'json',
		success: function(respuesta)
		{
			if(respuesta.codigo=='1')
			{
				$("#i-is").val(respuesta.data.ins_sistema);
				$("#i-uo").val(respuesta.data.ins_nombre);
				$("#i-cu").val(respuesta.data.ins_cod_msp);
				$("#i-pa").val(respuesta.data.ins_parroquia);
				$("#i-ca").val(respuesta.data.ins_canton);
				$("#i-pr").val(respuesta.data.ins_provincia);
			}
			else
			{
				alert(respuesta.mensaje);
			}
		},	
		error: function(error)
		{
			console.log("ERROR: "+error);
		}
	});
}

function llenarDatosBasicos()
{
	var parametros ={
		adm_na: '49414'
	}
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
				$("#i-na").val(respuesta.adm_na);
				$("#p-hc").val(respuesta.adm_hcu);
				$("#p-fa").val(respuesta.adm_fecha_admision);
				$("#p-ap").val(respuesta.adm_apellido);
				$("#p-no").val(respuesta.adm_nombre);
				$("#p-fn").val(respuesta.adm_fecha_nacimiento);
				$("#p-se").val(respuesta.adm_sexo);
			}
			else
			{
				alert(respuesta.mensaje);
			}
		},
		error: function(error) {
			console.log("ERROR: "+error);
		}
	});
}

function llenarCombo(tabla,campo1,param1,campo2,param2,combo)
{
	if(window.XMLHttpRequest)
	{
		xmlhttp = new XMLHttpRequest();
	}
	else
	{
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	//xmlhttp.open("GET","assets/includes/admision.php?tipo="+tipo,true);
	xmlhttp.open("GET","assets/includes/llenarLugar.php?tabla="+tabla+'&campo_1='+campo1+'&param_1='+param1+'&campo_2='+campo2+'&param_2='+param2+'',true);
	xmlhttp.send();
	xmlhttp.onreadystatechange = function()
	{
		if(xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			$(combo).html(xmlhttp.responseText);
		}
	}
}

$("#p-pr").click(function(){
	//event.preventDefault();
	var codigo_provincial ="";
	if($("#p-pr").val()<10)
	{
		codigo_provincial = '0'+$("#p-pr").val();
	}
	else
	{
		codigo_provincial = $("#p-pr").val();
	}
	llenarCombo('tb_canton','cod_canton','0','can_presentar',codigo_provincial,'#p-ca');
});


$("#p-pr").blur(function(){
	//event.preventDefault();
	$("#p-pr").click();
	$("#p-ca").focus();
});

$("#p-ca").click(function(){
	//event.preventDefault();
	var codigo_cantonal ="";
	if($("#p-ca").val()<1000)
	{
		codigo_cantonal = '0'+$("#p-ca").val();
	}
	else
	{
		codigo_cantonal = $("#p-ca").val();
	}
	llenarCombo('tb_parroquia','cod_parroquia','0','par_presentar',codigo_cantonal,'#p-pa');
});


$("#p-ca").blur(function(){
	//event.preventDefault();
	$("#p-ca").click();
	$("#p-pa").focus();
});

$("#p-pa").blur(function(){
	llenarCombo('tb_provincia','cod_provincia','0','pro_descripcion','0','#p-ln');
	$("#p-ba").focus();
});

$("#p-ba").blur(function(){
	$("#p-cm").focus();
});

$("#p-cm").blur(function(){
	$("#p-zo").focus();
});

$("#p-zo").blur(function(){
	$("#p-te").focus();
});

$("#p-ln").blur(function(){
	$("#p-na").focus();
});

function calcularEdad()
{
    var fecha = $("#p-fn").val();
    var values=fecha.split("-");
    var dia = values[2];
    var mes = values[1];
    var ano = values[0];

    // cogemos los valores actuales
    var fecha_hoy = new Date();
    var ahora_ano = fecha_hoy.getYear();
    var ahora_mes = fecha_hoy.getMonth()+1;
    var ahora_dia = fecha_hoy.getDate();

    // realizamos el calculo
    var edad = (ahora_ano + 1900) - ano;
    if ( ahora_mes < mes )
    {
        edad--;
    }
    if ((mes == ahora_mes) && (ahora_dia < dia))
    {
        edad--;
    }
    if (edad > 1900)
    {
        edad -= 1900;
    }
 	$("#p-ed").val(edad);   
}