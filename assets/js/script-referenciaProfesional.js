$(document).ready(function(){
	/*$(".frm-datos-paciente").hide();
	$(".frm-referencia").hide();
	$(".frm-narchivo").hide();
	$("#profesional-ref").focus();*/
	$("#btn-buscar").click();
	$(".frm-emergencia").hide();
});

function calculadoraEdadJs(fecha_nacimiento)
{
	if(fecha_nacimiento!=0)
	{
		fecha_hoy = "";
		fecha_hoy = $("#c-fecha-hoy").html();
		l_fechahoy = fecha_hoy.length;
		dia = fecha_hoy[8]+fecha_hoy[9];
		mes = fecha_hoy[5]+fecha_hoy[6];
		anio = fecha_hoy[0]+fecha_hoy[1]+fecha_hoy[2]+fecha_hoy[3];
		
		dia = parseInt(dia);
		mes = parseInt(mes);
		anio = parseInt(anio);

		fecha_n = "";
		fecha_n = fecha_nacimiento;
		caracteres = fecha_n.length;

		fecha_anio = fecha_n[0]+fecha_n[1]+fecha_n[2]+fecha_n[3];
		fecha_mes = fecha_n[5]+fecha_n[6];
		fecha_dia = fecha_n[8]+fecha_n[9];
		
		anio_nac = parseInt(fecha_anio);
		mes_nac = parseInt(fecha_mes);
		dia_nac = parseInt(fecha_dia);

		if((mes==mes_nac) &&(dia<dia_nac))
		{
			anio = anio-1;
		}
		if(mes<mes_nac)
		{
			anio = anio-1;	
		}

		edad = anio-anio_nac;
		return edad;
	}
	else
	{
		return 0;
	}
}

$("#btn-buscar").click(function(event){
	event.preventDefault();
	$("#narchivo").val($("#narchivo").val().trim());
	var parametros ={
		adm_na: $("#narchivo").val()
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
				$(".frm-datos-paciente").fadeIn();
				$(".frm-referencia").fadeIn();
				$("#hcus").val(respuesta.adm_hcu);
				$("#apellidop").val(respuesta.adm_apellido);
				$("#nombre1").val(respuesta.adm_nombre);
				$("#fechan").val(respuesta.adm_fecha_nacimiento);
				if(respuesta.adm_sexo=='M')
				{
					$("#lssexo").val('H');
				}
				else
				{
					$("#lssexo").val("M");
				}

				$("#apellidom").val('');
				$("#nombre2").val('');
				$("#telefono").val('');			

				$("#telefono").focus();
			}
			else
			{
				if(respuesta.codigo==5)
				{
					encset=1;
					$(".frm-datos-paciente").fadeIn();
					$(".frm-referencia").fadeIn();
					$("#hcus").val(respuesta.adm_hcu);
					$("#apellidop").val(respuesta.adm_apellido.toUpperCase());
					$("#apellidom").val(respuesta.tar_amaterno.toUpperCase());
					$("#nombre1").val(respuesta.adm_nombre.toUpperCase());
					$("#nombre2").val(respuesta.tar_nombre2.toUpperCase())
					$("#fechan").val(respuesta.adm_fecha_nacimiento);
					if(respuesta.adm_sexo=='M')
					{
						$("#lssexo").val('H');
					}
					else
					{
						$("#lssexo").val("M");
					}
					$("#telefono").val(respuesta.tar_telefono);
					$("#telefono").focus();
				}
				else
				{
					encset=0;
					$(".frm-datos-paciente").hide();
					$(".frm-referencia").hide();
					$("#comuna").val('');
					$("#direccion").val('');
					$("#cie10").val('');
					$("#diagnostico").val('');
					alert(respuesta.mensaje);
					$("#narchivo").focus();

				}
			}
		},
		error: function(error) {
			console.log("ERROR: "+error);
		}
	});
	$("#edad-actual").val(calculadoraEdadJs($("#fechan").val()));
});

$("#narchivo").blur(function(){
	$("#narchivo").val($("#narchivo").val().trim());
	var parametros ={
		adm_na: $("#narchivo").val()
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
				$(".frm-datos-paciente").fadeIn();
				$(".frm-referencia").fadeIn();
				$("#hcus").val(respuesta.adm_hcu);
				$("#apellidop").val(respuesta.adm_apellido);
				$("#nombre1").val(respuesta.adm_nombre);
				$("#fechan").val(respuesta.adm_fecha_nacimiento);
				if(respuesta.adm_sexo=='M')
				{
					$("#lssexo").val('H');
				}
				else
				{
					$("#lssexo").val("M");
				}

				$("#apellidom").val('');
				$("#nombre2").val('');
				$("#telefono").val('');			
			}
			else
			{
				if(respuesta.codigo==5)
				{
					encset=1;
					$(".frm-datos-paciente").fadeIn();
					$(".frm-referencia").fadeIn();
					$("#hcus").val(respuesta.adm_hcu);
					$("#apellidop").val(respuesta.adm_apellido.toUpperCase());
					$("#apellidom").val(respuesta.tar_amaterno.toUpperCase());
					$("#nombre1").val(respuesta.adm_nombre.toUpperCase());
					$("#nombre2").val(respuesta.tar_nombre2.toUpperCase())
					$("#fechan").val(respuesta.adm_fecha_nacimiento);
					if(respuesta.adm_sexo=='M')
					{
						$("#lssexo").val('H');
					}
					else
					{
						$("#lssexo").val("M");
					}
					$("#telefono").val(respuesta.tar_telefono);
				}
				else
				{
					encset=0;
					$(".frm-datos-paciente").hide();
					$(".frm-referencia").hide();
					$("#comuna").val('');
					$("#direccion").val('');
					$("#cie10").val('');
					$("#diagnostico").val('');
				}
			}
		},
		error: function(error) {
			console.log("ERROR: "+error);
		}
	});
	$("#edad-actual").val(calculadoraEdadJs($("#fechan").val()));
});

$("#narchivo").keypress(function(e){
	if(e.which == 13)
	{
		$("#btn-buscar").click();
		return false;
	}
});

$("#cmb-provincia").change(function(){
	$("#cmb-parroquia").html('<option value="*">Seleccione un camton</option>');
	if(window.XMLHttpRequest)
	{
		xmlhttp3 = new XMLHttpRequest();
	}
	else
	{
		xmlhttp3 = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp3.open("GET","assets/includes/comboCanton.php?provincia="+$("#cmb-provincia").val()+"",true);
	xmlhttp3.send();
	xmlhttp3.onreadystatechange = function()
	{
		if(xmlhttp3.readyState==4 && xmlhttp3.status==200)
		{
			$("#cmb-canton").html(xmlhttp3.responseText);
		}
	}
});

$("#cmb-canton").change(function(){
	if(window.XMLHttpRequest)
	{
		xmlhttp2 = new XMLHttpRequest();
	}
	else
	{
		xmlhttp2 = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp2.open("GET","assets/includes/comboParroquia.php?canton="+$("#cmb-canton").val()+"",true);
	xmlhttp2.send();
	xmlhttp2.onreadystatechange = function()
	{
		if(xmlhttp2.readyState==4 && xmlhttp2.status==200)
		{
			$("#cmb-parroquia").html(xmlhttp2.responseText);
		}
	}
});

$("#cie10").keypress(function(e){
	if(e.which == 13)
	{
		$("#btn-buscar-cie").click();
		return false;
	}
});

$("#btn-buscar-cie").click(function(event){
	event.preventDefault();
	$("#cie10").val($("#cie10").val().trim().toUpperCase());
	var parametros ={
		cie_cie: $("#cie10").val(),
		cie_sexo: $("#lssexo").val(),
		cie_edad: $("#edad-actual").val()
	}
	if($("#lssexo").val()=='H')
	{
		sexo_temp=2;
	}
	else
	{
		if($("#lssexo").val()=='M')
		{
			sexo_temp=1;	
		}
		else
		{
			sexo_temp=0;
		}
	}
	$.ajax({
		url: "assets/includes/consultaCIE10.php",
		type: "POST",
		async: false,
		data: parametros,
		dataType: "json",
		success: function(respuesta)
		{
			if(respuesta.codigo==1)
			{
				$("#diagnostico").val(respuesta.cie_descripcion);
				$("#condicion").focus();
			}
			else
			{
				alert(respuesta.mensaje);
				$("#diagnostico").val('');
				$("#cie10").focus();
			}
		},
		error: function(error) {
			console.log("ERROR: "+error);
		}
	});
});

$("#cie10").blur(function(){
	$("#cie10").val($("#cie10").val().trim().toUpperCase());
	var parametros ={
		cie_cie: $("#cie10").val(),
		cie_sexo: $("#lssexo").val(),
		cie_edad: $("#edad-actual").val()
	}
	if($("#lssexo").val()=='H')
	{
		sexo_temp=2;
	}
	else
	{
		if($("#lssexo").val()=='M')
		{
			sexo_temp=1;	
		}
		else
		{
			sexo_temp=0;
		}
	}
	$.ajax({
		url: "assets/includes/consultaCIE10.php",
		type: "POST",
		async: false,
		data: parametros,
		dataType: "json",
		success: function(respuesta)
		{
			if(respuesta.codigo==1)
			{
				$("#diagnostico").val(respuesta.cie_descripcion);
			}
			else
			{
				$("#diagnostico").val('');
			}
		},
		error: function(error) {
			console.log("ERROR: "+error);
		}
	});
});

$("#profesional-ref").change(function(){
	if($("#profesional-ref").val()!='*')
	{
		$(".frm-narchivo").fadeIn();
		$("#narchivo").val('');
		$("#narchivo").focus();
	}
	else
	{
		$(".frm-narchivo").hide();
		$(".frm-datos-paciente").hide();
		$(".frm-referencia").hide();
		$("#profesional-ref").focus();
	}
});

function prepararEnvio()
{	
	if($("#telefono").val().trim()=="" || $("#telefono").val().length<10)
	{
		alert("Debe Ingresar el numero del telefono correcto");
		$("#telefono").focus();
	}
	else
	{
		if($("#cmb-parroquia").val()=='*')
		{
			alert("Debe Ingresar el canton");
			$("#cmb-canton").focus();		
		}
		else
		{
			if($("#comuna").val().trim()=="")
			{
				alert("Debe Ingresar la comuna o el barrio");
				$("#comuna").focus();
			}
			else
			{
				if($("#direccion").val().trim()=="")
				{
					alert("Debe Ingresar las calles, sector o algun sector");
					$("#direccion").focus();
				}
				else
				{
					if($("#diagnostico").val().trim()=="")
					{
						alert("Debe Ingresar codigo del diagnostico");
						$("#cie10").focus();
					}
					else
					{
						return true;
					}
				}
			}
		}
	}
}

$("#btn-guardar").click(function(){
	if(prepararEnvio())
	{
		espaciador1 = $("#telefono").val().trim();
		espaciador2 = $("#comuna").val().trim().toUpperCase();
		espaciador3 = $("#direccion").val().trim().toUpperCase();
		espaciador4 = $("#cie10").val().trim().toUpperCase();
		if($("#control-emergencia").attr('alt')=="on")
		{
			ref_fecha_cita = "'"+$("#fecha-cita").val()+"'";
			ref_hora_cita = "'"+$("#hora-cita").val()+":00'";
			ref_medico_cita = "'"+$("#medico-cita").val()+"'";
		}
		else
		{
			ref_fecha_cita = "NULL";
			ref_hora_cita = "NULL";
			ref_medico_cita	= "NULL";
		}
		var parametros_envio = {
			ref_cedula_paciente: $("#hcus").val(),
			ref_cedula_profesional: $("#profesional-ref").val(),
			ref_unidad_refiere: 3,
			ref_especialidad_referida: $("#cmb-especialidad").val(),
			ref_unidad_referida: $("#cmb-nivel").val(),
			ref_tipo_servicio: $("#servicio").val(),
			ref_cie10: $("#cie10").val(),
			ref_diagnostico: $("#diagnostico").val(),
			ref_condicion_diagnostico: $("#condicion").val(),
			ref_sexo: $("#lssexo").val(),
			ref_edad: $("#edad-actual").val(),
			ref_telefono: espaciador1,
			/*********PARA CASOS DE EMERGENCIA*****/
			ref_fecha_cita: ref_fecha_cita,
			ref_hora_cita: ref_hora_cita,
			ref_medico_cita: ref_medico_cita,
			/********PARA TABLA 001******/
			reg_provincia:$("#cmb-provincia").val(),
			reg_canton:$("#cmb-canton").val(),
			reg_parroquia:$("#cmb-parroquia").val(),
			reg_barrio:espaciador2,
			reg_direccion:espaciador3,
			tipo_trans: "guarda"
		}
		var r= confirm("Esta seguro de guardar el registro actual?");
		if(r==true)
		{
			$.ajax({
		        url: "assets/includes/datosReferencia.php",
		        type: 'POST',
		        async: false,
		        data: parametros_envio,
		        dataType: "json",
		        success: function (respuesta)
		        {
		        	if(respuesta.codigo == 1)
		          	{
		            	alert(respuesta.mensaje);
		            	$(".frm-datos-paciente").hide();
						$(".frm-referencia").hide();
						$("#narchivo").val('');
						$("#comuna").val('');
						$("#direccion").val('');
						$("#cie10").val('');
						$("#diagnostico").val('');
						presentarReferencia($("#profesional-ref").val());
						//$("#narchivo").focus();

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
});

$("#telefono").keypress(function(e){
	if(e.which == 13)
	{
		$("#cmb-provincia").focus();
		return false;
	}
});

$("#comuna").keypress(function(e){
	if(e.which == 13)
	{
		$("#direccion").focus();
		return false;
	}
});

$("#direccion").keypress(function(e){
	if(e.which == 13)
	{
		$("#cmb-nivel").focus();
		return false;
	}
});

$("#servicio").change(function(){
	if($("#servicio").val()=='E')
	{
		$(".frm-emergencia").show();
		$("#fecha-cita").val($("#c-fecha-hoy").html());
		$("#hora-cita").val($("#c-hora-hoy").html());
		$("#medico-cita").val("");
		$("#control-emergencia").attr('alt','on');
		$("#hora-cita").focus();
	}
	else
	{
		$("#fecha-cita").val("");
		$("#hora-cita").val("");
		$("#medico-cita").val("");
		$("#control-emergencia").attr('alt','off');
		$(".frm-emergencia").hide();	
	}
});