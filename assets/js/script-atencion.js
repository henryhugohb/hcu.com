//timer = setTimeout('temporizador()', 1000);
$(document).ready(function(){
	$(".c-d-paciente").hide();
	$(".n-cita").hide();
	$(".login-p").hide();
	$("#login-i").hide();
	$("#a-profesional").focus();
	$(".fecha-b").hide();
	$("#a-ver-grupo").hide();
	$("#a-ver-referencia").hide();
	$("#r-agendas").hide();
	//$(".datos-cita").hide();
	/*$(".c-d-paciente").hide();
	$(".n-cita").hide();
	$(".c-prof").hide();
	$("#a-fecha").val($("#c-fecha-hoy").html());
	$("#a-fecha").focus();
	//temporizador();*/
});

$("#p-pin").keypress(function(e){
	if(e.which == 13)
	{
		if($("#p-pin").val()!="" && $("#p-pin").val().length==4)
		{
			$("#p-validar").click();
		}			
		return false;
	}
});

$("#a-profesional").change(function(){
	$(".fecha-b").hide();
	$("#r-agendas").html("");
	$(".n-cita").hide();
	$(".c-d-paciente").hide();
	$("#a-ver-grupo").hide();
	$("#a-ver-referencia").hide();
	if($("#a-profesional").val()!="*")
	{
		$("#login-i").fadeOut();
		$(".login-p").fadeIn();
		$("#p-pin").val("");
		$("#p-pin").focus();
	}
	else
	{
		$(".login-p").fadeOut();
		$("#login-i").fadeOut();
	}
	//$("#horario-prof").html($("#a-profesional").val());
	//$(".c-d-paciente").hide();
	//$(".n-cita").hide();
	//buscarAgenda();
});

$("#p-validar").click(function(){
	if($("#p-pin").val()=="" || $("#p-pin").val().length<4)
	{
		alert("Debe ingresar el pin de seguridad debe contener 4 numeros!");
		$("#p-pin").focus();
	}
	else
	{
		$("#login-i").fadeIn();
		var parametros = {
			pro_cedula: $("#a-profesional").val(),
			pro_pin: $("#p-pin").val(),
			tipo_trans: "valida"
		}
		$.ajax({
	        url: "assets/includes/datosAtencion.php",
	        type: 'POST',
	        async: false,
	        data: parametros,
	        dataType: "json",
	        success: function (respuesta)
	        {
	        	if(respuesta.codigo == 2)
	          	{
	            	$("#login-i").fadeOut();
	            	alert(respuesta.mensaje);
	            	$("#especialidad-prof").html('');
	            	$("#p-pin").focus();
	          	}
	          	else
	          	{
	          		if(respuesta.codigo==1)
	          		{
	          			$("#login-i").fadeOut();
	          			$(".login-p").fadeOut();
	          			$(".fecha-b").fadeIn();
	          			$("#a-ver-grupo").fadeIn();
	          			$("#a-ver-referencia").fadeIn();
	          			$("#a-fecha").val($("#c-fecha-hoy").html());
	          			$("#especialidad-prof").html(respuesta.especialidad);
	          			$("#a-fecha").focus();
	          		}
	          		else
	          		{
						alert(respuesta.mensaje);
						$("#especialidad-prof").html('');
						$("#login-i").fadeOut();	
	          		}
	          	}
	        }, 
	        error: function (error) {
	          console.log("ERROR: " + error);
	        }
		});
	}
});

$("#a-consultar").click(function(){
	$(".n-cita").hide();
	$(".c-d-paciente").hide();
	buscarAgenda();
});

$("#a-fecha").keypress(function(e){
	if(e.which == 13)
	{
		$("#a-consultar").click();
		return false;
	}
});

function buscarAgenda()
{
	$("#r-agendas").fadeIn();
	$("#r-agendas").html("<spam><b>Procesando...</b></spam>");
	if(window.XMLHttpRequest)
	{
		xmlhttp = new XMLHttpRequest();
	}
	else
	{
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.open("GET","assets/includes/rCitas.php?fecha="+$("#a-fecha").val()+"&profesional="+$("#a-profesional").val()+"",true);
	xmlhttp.send();
	xmlhttp.onreadystatechange = function()
	{
		if(xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			$("#r-agendas").html(xmlhttp.responseText);
		}
	}
}

function atencionDeCita()
{
	var r= confirm("Atender la cita actual?");
	if(r==true)
	{
		var parametros = {
			age_codigo: $("#cita").attr('alt'),
			age_vez: $("#primera-c").attr('alt'),
			age_narchivo: $("#n-archivo").attr('alt'),
			tipo_trans: "atender-c",
			age_fecha_c: $("#c-hora-c").attr('alt'),
			age_fecha_a: $("#c-fecha-hoy").html(),
			age_hora_a: $("#c-hora-hoy").html(),
			age_tipo: $("input:radio[name=c-tipo-id]:checked").val()
		};
		$.ajax({
		    url: "assets/includes/datosAtencion.php",
		    type: 'POST',
		    async: false,
		    data: parametros,
		    dataType: "json",
		    success: function (respuesta)
		    {
		    	if(respuesta.codigo == 1)
		      	{
		        	alert(respuesta.mensaje);
		        	$(".c-d-paciente").hide();
		        	$(".n-cita").hide();
		        	buscarAgenda();
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
		if(($("#p-edad").val()>4) && ($("#especialidad-prof").html()=="1" || $("#especialidad-prof").html()=="9" || $("#especialidad-prof").html()=="4" || $("#especialidad-prof").html()=="11"))
		{
			var parametros = {
				mge_na:$("#info-paciente-na").html(),
				mge_edad:$("#p-edad").val(),
				mge_imc:$("#e-estado-nutricional").val(),
				mge_visita:$("#e-visita").val(),
				mge_profesional: $("#a-profesional").val(),
				tipo_trans: "guardaEtareo"
			};
			$.ajax({
			    url: "assets/includes/datosAtencion.php",
			    type: 'POST',
			    async: false,
			    data: parametros,
			    dataType: "json",
			    success: function (respuesta)
			    {
			    	if(respuesta.codigo == 1)
			      	{
			        	
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

function buscarCitaConfirmada()
{
	var parametros = {
		age_codigo: $("#cita").attr('alt'),
		tipo_trans: "busca-cita"
	};
	$.ajax({
	    url: "assets/includes/datosAtencion.php",
	    type: 'POST',
	    async: false,
	    data: parametros,
	    dataType: "json",
	    success: function (respuesta)
	    {
	    	if(respuesta.codigo == 1)
	      	{
	        	$("#c-hora-c").attr('alt',respuesta.age_fecha_c);
	        	$("#estado-c").attr('alt',respuesta.age_estado_c);
	        	$("#primera-c").attr('alt',respuesta.age_vez);
	        	$("#n-archivo").attr('alt',respuesta.age_narchivo);
	      	}	      	
	      	else
	      	{
	      		$("#c-hora-c").attr('alt',"false");
	      		$("#estado-c").attr('alt',"false");
	      		$("#primera-c").attr('alt',"false");
	      		$("#n-archivo").attr('alt',"false");
	      	}
	    }, 
	    error: function (error) {
	      console.log("ERROR: " + error);
	    }
	});	
}

$("#e-guardar").click(function(){
	$("#a-atender").click();
});
/**modificacion 26-08-2016 function buscarIMC*/
$("#e-cancelar").click(function(){
	$("#a-consultar").click();
});

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
	xmlhttp3.open("GET","assets/includes/resultadoEtareoHistorial.php?hcu="+$("#info-paciente-hcu").html()+"",true);
	xmlhttp3.send();
	xmlhttp3.onreadystatechange = function()
	{
		if(xmlhttp3.readyState==4 && xmlhttp3.status==200)
		{
			$("#resultado-busqueda3").html(xmlhttp3.responseText);
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
	xmlhttp2.open("GET","assets/includes/resultadoReferenciaHistorial.php?paciente="+$("#info-paciente-hcu").html()+"",true);
	xmlhttp2.send();
	xmlhttp2.onreadystatechange = function()
	{
		if(xmlhttp2.readyState==4 && xmlhttp2.status==200)
		{
			$("#resultado-busqueda2").html(xmlhttp2.responseText);
		}
	}
}

function buscarCedula()
{
	var parametros ={
		adm_na: $("#info-paciente-na").html().trim()
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
				$("#info-paciente-hcu").html(respuesta.adm_hcu);
			}
			else
			{
				if(respuesta.codigo==5)
				{
					$("#info-paciente-hcu").html(respuesta.adm_hcu);
				}
				else
				{
					$("#info-paciente-hcu").html(respuesta.adm_hcu);
				}
			}
		},
		error: function(error) {
			console.log("ERROR: "+error);
		}
	});
}

$("#a-atender").click(function(){
	if($("#a-atender").val()=="Atender")
	{
		buscarCitaConfirmada();
		if($("#estado-c").attr('alt')=="L")
		{
			alert("La cita esta libre no se puede atender");
		}
		else
		{
			if($("#estado-c").attr('alt')=="A")
			{
				alert("La cita ya fue atendida");
			}
			else
			{
				/**aqui**/
				consultarCita();
				busquedaDatosPaciente();
				if(($("#p-edad").val()>4) && ($("#especialidad-prof").html()=="1" || $("#especialidad-prof").html()=="9" || $("#especialidad-prof").html()=="4" || $("#especialidad-prof").html()=="11"))
				{
					$("#comboEstadoNutri").show();
					$("#e-visita").show();
					$("#r-agendas").hide();
					llenaComboEstadoNutricional();	
				}	
				else
				{
					$("#comboEstadoNutri").hide();
					$("#e-visita").hide();
					$("#r-agendas").hide();
					llenaComboEstadoNutricional();
				}
				
				$("#tipo-atender").fadeIn();
				$("#c-tipo-p").prop("checked",true);
				$("#c-tipo-p").focus();
				$("#a-atender").val("Guardar");
				$(".n-cita").hide();
				buscarCedula();
				buscarIcm();
				buscarefe();
			}
		}	
	}
	else
	{
		if($("#a-atender").val()=="Guardar")
		{
			/************************PERMITE ATENDER SOLO CITAS DEL DIA*********************/
			if($("#c-fecha-hoy").html()!=$("#a-fecha").val())
			{
				alert("No se puede atender una cita que no es para hoy");
			}
			else
			{
				atencionDeCita();
			}
			/******************************************************************************/
			
			/*****PERMITE ATENDER CITAS DE CUALQUIER DIA*******
			atencionDeCita();
			***************************************/
		}
	}
	
});

function consultarCita()
{
	var parametros = {
		age_codigo: $("#cita").attr('alt'),
		tipo_trans: "busca-cita"
		};
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
	        	//$(".c-d-paciente").show();
	        	$("#info-paciente-na").html(respuesta.age_narchivo);
	        	$("#info-paciente-nombres").html(" - "+respuesta.age_nombres);
	        	/*$("#c-fecha-hoy").html(respuesta.fecha_server);
	        	$("#c-hora-hoy").html(respuesta.hora_server);
				$("#c-horario").html(respuesta.age_hora_cita);
				if(respuesta.age_observacion=="")
				{
					$("#c-observacion").val("");	
				}
				else
				{
					$("#c-observacion").val(respuesta.age_observacion);
				}	        	
	        	if(respuesta.age_narchivo == 0 && respuesta.age_nombres != '')
	        	{
	        		$("#vez").prop("checked",true);
	        		$("#apellidos").removeAttr('readonly');
					$("#nArchivo").attr('readonly','readonly');
	        		$("#a-agendar").val('Agendar');
	        		$("#apellidos").focus();	
	        	}
	        	else
	        	{
	        		if(respuesta.age_nombres == ''){ $("#nArchivo").val(''); }
	        		$("#vez").prop("checked",false);
					$("#nArchivo").removeAttr('readonly');
					$("#apellidos").attr('readonly','readonly');
	        		$("#a-agendar").val('Agendar');
	        		$("#nArchivo").focus();
	        	}*/
	      	}
	      	else
	      	{
	      		alert(respuesta.mensaje);
	      		$("#a-agendar").focus();
	      	}
	    }, 
	    error: function (error) {
	      console.log("ERROR: " + error);
	    }
	});
}
function busquedaDatosPaciente()
{
	var parametros = {
		nArchivo: $("#info-paciente-na").html(),
		tipo_id: 'na',
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
            	$("#p-edad").val(respuesta.edad_paciente);
          	}
          	else
          	{
          		$("#p-edad").val("0");
          	}
        }, 
        error: function (error) {
          console.log("ERROR: " + error);
          alert(error);
        }
	});
}

function llenaComboEstadoNutricional()
{
	if(window.XMLHttpRequest)
	{
		xmlhttp4 = new XMLHttpRequest();
	}
	else
	{
		xmlhttp4 = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp4.open("GET","assets/includes/comboEstadoNutricional.php?edad="+$("#p-edad").val()+"",true);
	xmlhttp4.send();
	xmlhttp4.onreadystatechange = function()
	{
		if(xmlhttp4.readyState==4 && xmlhttp4.status==200)
		{
			$("#comboEstadoNutri").html(xmlhttp4.responseText);
		}
	}
}

$("#a-ver-grupo").click(function(){
	presentarGrupoEtareo($("#a-profesional").val());
});

$("#a-ver-referencia").click(function(){
	presentarReferencia($("#a-profesional").val());
});

$("#a-referir").click(function(){
	consultarCita();
	if($("#info-paciente-na").html()=='0')
	{
		alert("El paciente no tiene historial dentro de la institucion, No se puede referir");
	}
	else
	{
		presentarReferenciaProfesional($("#a-profesional").val(),$("#info-paciente-na").html());
	}
});
