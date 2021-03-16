//timer = setTimeout('temporizador()', 1000);

$(document).ready(function(){
	$(".c-profesional").hide();
	$(".c-d-paciente").hide();
	$(".n-cita").hide();
	$(".c-prof").hide();
	$("#l-sobre").hide();
	$("#lista-sobre").hide();
	$("#quitar-s").hide();
	//$(".sobreagenda-p").hide();
	$("#a-fecha").val($("#c-fecha-hoy").html());
	$("#a-fecha").focus();
	//temporizador();
});

/*function horaFlash()
{
	$.ajax({
	    url: "assets/includes/horaServidor.php",
	    type: 'POST',
	    async: false,
	    data: 0,
	    dataType: "json",
	    success: function (respuesta)
	    {
	    	alert("La hora es: "+respuesta.dato+"");
	    	//$("#c-hora-hoy").html(respuesta.dato);
	    }, 
	    error: function (error) {
	      console.log("ERROR: " + error);
	    }
	});
}*/

/*function temporizador()
{
	//horaFlash();
	timer = setTimeout('temporizador()', 1000);
}*/

$("#a-consultar").click(function(){
	//horaFlash();
	$(".n-cita").hide();
	$(".c-d-paciente").hide();
	$("#l-sobre").hide();
	$("#lista-sobre").hide();
	$("#quitar-s").hide();
	$("#p-edad").val('');
	if($("#a-consultar").attr('alt')=="consultarProfesional")
	{
		var parametros = {
			fecha: $("#a-fecha").val(),
			//profesional: $("#horario-prof").val(),
			tipo_trans: "consulta-agenda"
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
		        	$(".c-prof").hide();
		        	var i=0;
		        	while(i<respuesta.total)
		        	{
		        		$("#"+respuesta.datos[i]+"").show();
		        		i=i+1;
		        	}
		        	$("#todos").show();
		        	$("#todos").prop('selected','true');
		        	$(".c-profesional").fadeIn();
		        	buscarAgenda();
		      	}
		      	else
		      	{
		      		buscarAgenda();
		      		alert(respuesta.mensaje);
		      		$(".c-profesional").hide();
					$(".c-d-paciente").hide();
		      		$("#a-fecha").focus();
		      	}
		    }, 
		    error: function (error) {
		      console.log("ERROR: " + error);
		    }
		});
	}
});

$("#a-fecha").keypress(function(e){
	if(e.which == 13)
	{
		$("#a-consultar").click();
		return false;
	}
});

$("#nArchivo").keypress(function(e){
	if(e.which == 13)
	{
		busquedaDatosPaciente(1);
		return false;
	}
});

$("#nArchivo").blur(function(){
	busquedaDatosPaciente(2);
});

function busquedaDatosPaciente(tipo_bdp)
{
	if(($("#nArchivo").val()).trim()=="" || $("#nArchivo").val()==0)
	{
		if(tipo_bdp==1)
		{
			alert("Debe ingresar el numero de Identificacion!.");
			$("#apellidos").val("Numero no asignado");
			$("#nArchivo").focus();
		}
		else
		{
			if(tipo_bdp==2)
			{
				$("#apellidos").val("Numero no asignado");
			}
		}
	}
	else
	{
		if(!($("#vez").prop("checked")))
		{
			$("#apellidos").val('Buscando...');
			var parametros = {
				nArchivo: $("#nArchivo").val(),
				tipo_id: $("input:radio[name=c-tipo-id]:checked").val(),
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
		            	if($("input:radio[name=c-tipo-id]:checked").val()=="na")
		            	{
		            		if(tipo_bdp==1)
		            		{
		            			$("#apellidos").val(respuesta.mensaje);
		            			$("#c-observacion").val(respuesta.observa_pac);
		            			$("#p-edad").val(respuesta.edad_paciente);
		            			$("#c-observacion").focus();
		            		}
		            		else
		            		{
		            			if(tipo_bdp==2)
		            			{
		            				$("#apellidos").val(respuesta.mensaje);
		            			}
		            		}
		            	}
		            	else
		            	{
		            		if($("input:radio[name=c-tipo-id]:checked").val()=="hcu")
		            		{
		            			if(tipo_bdp==1)
		            			{
		            				$("#nArchivo").val(respuesta.n_d_archivo);
				            		$("#apellidos").val(respuesta.mensaje);
				            		$("#c-tipo-hcu").removeAttr("checked");
									$("#c-tipo-na").prop("checked",true);
									$("#c-observacion").val(respuesta.observa_pac);
									$("#p-edad").val(respuesta.edad_paciente);
				            		$("#c-observacion").focus();
		            			}
		            			else
		            			{
		            				if(tipo_bdp==2)
		            				{
		            					$("#nArchivo").val(respuesta.n_d_archivo);
					            		$("#apellidos").val(respuesta.mensaje);
					            		$("#c-tipo-hcu").removeAttr("checked");
										$("#c-tipo-na").prop("checked",true);
		            				}
		            			}
		            		}
		            	}
		          	}
		          	else
		          	{
		          		if(respuesta.codigo == 3)
		          		{
		          			if(tipo_bdp==1)
		          			{
		          				$("#nArchivo").val(0);
			          			$("#apellidos").val("Numero no asignado");
			          			alert(respuesta.mensaje);
		          			}
		          			else
		          			{
		          				if(tipo_bdp==2)
		          				{
		          					$("#nArchivo").val(0);
			          				$("#apellidos").val("Numero no asignado");
		          				}
		          			}
		          		}
		          		else
		          		{
		          			if(tipo_bdp==1)
		          			{
			          			$("#apellidos").val(respuesta.mensaje);
			          			$("#nArchivo").focus();
		          			}
		          			else
		          			{
		          				if(tipo_bdp==2)
		          				{
		          					$("#apellidos").val(respuesta.mensaje);
		          				}
		          			}
		          		}
		          	}
		        }, 
		        error: function (error) {
		          console.log("ERROR: " + error);
		          alert(error);
		        }
			});
		}
	}
}

$("#c-tipo-na").click(function(){
	$("#nArchivo").focus();
});

$("#c-tipo-hcu").click(function(){
	$("#nArchivo").focus();
});

$("#c-observacion").keypress(function(e){
	if(e.which == 13)
	{
		$("#a-agendar").click();
		return false;
	}
});

$("#apellidos").keypress(function(e){
	if(e.which == 13)
	{
		$("#c-observacion").focus();
		return false;
	}
});

function buscarAgenda()
{
	$("#r-agendas").html("<spam><b>Procesando...</b></spam>");
	if(window.XMLHttpRequest)
	{
		xmlhttp = new XMLHttpRequest();
	}
	else
	{
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.open("GET","assets/includes/rAgendas.php?fecha="+$("#a-fecha").val()+"&profesional="+$("#a-profesional").val()+"",true);
	xmlhttp.send();
	xmlhttp.onreadystatechange = function()
	{
		if(xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			$("#r-agendas").html(xmlhttp.responseText);
		}
	}
}

function consultarCita()
{
	var parametros = {
		age_codigo: $("#cita").html(),
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
	        	$(".c-d-paciente").show();
	        	$("#nArchivo").val(respuesta.age_narchivo);
	        	$("#apellidos").val(respuesta.age_nombres);
	        	$("#c-fecha-hoy").html(respuesta.fecha_server);
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
	        	}
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

function buscarPaciente()
{
	var parametros = {
		age_fecha: $("#a-fecha").val(),
		age_narchivo: $("#nArchivo").val(),
		age_codigo: $("#cita").html(),
		tipo_trans: "busca-cita-paciente"
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
	        	var r2= confirm("El paciente tiene las citas siguientes: "+respuesta.mensaje+" Desea agendar la cita actual?");
				if(r2==true)
				{
	      			estates = true;
	      		}
	      		else
	      		{
	      			estates =  false;
	      		}   	
	      	}
	      	else
	      	{
	      		estates =  true;
	      	}
	    }, 
	    error: function (error) {
	      console.log("ERROR: " + error);
	    }
	});
	return estates;
}

function buscarSobreagenda()
{
	var parametros = {
		sob_profesional: $("#a-profesional").val(),
		sob_fecha: $("#a-fecha").val(),
		tipo_trans: "busca-s"
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
	        	$("#l-sobre").fadeIn()  	
	      	}
	      	else
	      	{
	      		$("#l-sobre").fadeOut();
	      	}
	    }, 
	    error: function (error) {
	      console.log("ERROR: " + error);
	    }
	});
}

$("#a-profesional").change(function(){
	//$("#horario-prof").html($("#a-profesional").val());
	//alert($("#"+$("#a-profesional").val()+"").html());
	$(".c-d-paciente").hide();
	$(".n-cita").hide();
	$("#l-sobre").hide();
	$("#lista-sobre").hide();
	$("#quitar-s").hide();
	$("#p-edad").val('');
	buscarAgenda();
	buscarSobreagenda();
});

$("#a-actualizar").click(function(){
	$(".c-d-paciente").hide();
	$(".n-cita").hide();
	$("#l-sobre").hide();
	$("#lista-sobre").hide();
	$("#quitar-s").hide();
	$("#p-edad").val('');
	buscarAgenda();
	buscarSobreagenda();
});

$("#l-sobre").click(function(){
	if(window.XMLHttpRequest)
	{
		xmlhttp2 = new XMLHttpRequest();
	}
	else
	{
		xmlhttp2 = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp2.open("GET","assets/includes/rSobre.php?sob_profesional="+$("#a-profesional").val()+"&sob_fecha="+$("#a-fecha").val()+"",true);
	xmlhttp2.send();
	xmlhttp2.onreadystatechange = function()
	{
		if(xmlhttp2.readyState==4 && xmlhttp2.status==200)
		{
			$("#lista-sobre").html(xmlhttp2.responseText);
		}
	}
	$("#quitar-s").hide();
	$("#lista-sobre").fadeIn();
});

$("#quitar-s").click(function()
{
	var parametros = {
		sob_codigo: $("#quitar-s").attr('alt'),
		tipo_trans: "atiende-s"
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
	        	$("#l-sobre").click();
	      	}
	    }, 
	    error: function (error) {
	      console.log("ERROR: " + error);
	    }
	});
});

$("#vez").click(function(){
	if($("#vez").prop("checked"))
	{
		$("#nArchivo").val('000000');
		$("#nArchivo").attr('readonly','readonly');
		$("#apellidos").removeAttr('readonly');
		$("#apellidos").val('');
		$("#p-edad").val('');
		$("#apellidos").focus();
	}
	else
	{
		$("#nArchivo").removeAttr('readonly');
		$("#nArchivo").val('');
		$("#apellidos").val('');
		$("#apellidos").attr('readonly','readonly');
		$("#nArchivo").focus();
	}
});

$("#a-agendar").click(function(){
	if($("#a-agendar").val()=='Agendar')
	{
		var r= confirm("Esta seguro de modificar la cita actual?");
		if(r==true)
		{
			
			if($("#vez").prop("checked"))
			{
				var apellidoss ="";
				apellidoss = $("#apellidos").val();
				apellidoss = apellidoss.trim();
				$("#apellidos").val(apellidoss);
				if($("#apellidos").val()=="")
				{
					alert("Debe ingresar los nombres del paciente");
					$("#apellidos").focus();
				}
				else
				{
					asignarCita();
					$(".c-d-paciente").hide();
					$(".n-cita").hide();
					buscarAgenda();
					//$("#a-agendar").val('Mostrar');
				}
			}
			else
			{
				if($("#apellidos").val()=="Numero no asignado" || $("#apellidos").val()=="" || $("#nArchivo").val()=="" || $("#nArchivo").val()==0)
				{
					alert("Debe ingresar los numero de archivo del paciente");
					$("#nArchivo").focus();

				}
				else
				{
					if(buscarPaciente())
					{
						asignarCita();
						$(".c-d-paciente").hide();
						$(".n-cita").hide();
						$(".n-cita").hide();
						//alert("valor: "+$("input:radio[name=c-tipo-id]:checked").val()+"");
						//$("#c-tipo-id").val("na");
						buscarAgenda();
					}
					else
					{
						$("#nArchivo").focus();
					}
				}
			}
		}
	}
	else
	{
		if($("#a-agendar").val()=='Mostrar')
		{
			consultarCita();
			//$("#c-tipo-hcu").attr("checked",false);
			$("#c-tipo-na").attr("checked",true);
		}
	}
});

function asignarCita()
{
	var numerodevisita = "";
	if($("#vez").prop("checked"))
	{
		numerodevisita = "P";
	}
	else
	{
		numerodevisita = "S";
	}
	var parametros = {
		age_narchivo: $("#nArchivo").val(),
		age_nombres: ($("#apellidos").val()).toUpperCase(),
		age_fecha: $("#c-fecha-hoy").html(),
		age_fecha_de_cita: $("#a-fecha").val(),
		age_hora: $("#c-hora-hoy").html(),
		age_vez: numerodevisita,
		age_observacion: ($("#c-observacion").val()).toUpperCase(),
		age_codigo: $("#cita").html(),
		tipo_trans: "modifica"
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
	        	alert(respuesta.mensaje+".\nFecha: "+$("#a-fecha").val()+"\nHora: "+$("#c-horario").html()+"\nMedico: "+$("#"+$("#a-profesional").val()+"").html());
	        	//$(".c-d-paciente").hide();
	        	//buscarAgenda();
	      	}
	      	else
	      	{
	      		alert(respuesta.mensaje);
	      		//$("#nArchivo").focus();
	      	}
	    }, 
	    error: function (error) {
	      console.log("ERROR: " + error);
	    }
	});
}

$("#a-eliminar").click(function(){
	var parametros = {
		age_codigo: $("#cita").html(),
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
	        	if(respuesta.age_estado_c=="L")
	        	{
	        		alert("La cita aun no ha sido asignada");
	        	}
	        	else
	        	{
	        		if(respuesta.age_estado_c=="C")
		        	{
		        		alert("La cita ya fue confirmada, No se puede eliminar");
		        	}
		        	else
		        	{
		        		if(respuesta.age_estado_c=="A")
			        	{
			        		alert("La cita ya fue atendida, No se puede eliminar");
			        	}
			        	else
			        	{
			        		var r= confirm("Esta seguro de Eliminar la cita actual?");
							if(r==true)
							{
								var parametros = {
									age_codigo: $("#cita").html(),
									tipo_trans: "elimina-c"
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
							}
			        	}
		        	}
	        	}
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
});

function confirmacionCita()
{
	var r= confirm("Confirmar la cita actual?");
	if(r==true)
	{
		var parametros = {
			age_codigo: $("#cita").html(),
			tipo_trans: "confirma-c",
			age_fecha_c: $("#c-fecha-hoy").html(),
			age_hora_c: $("#c-hora-hoy").html()
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
	}
}

$("#a-confirmar").click(function(){
	var parametros = {
		age_codigo: $("#cita").html(),
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
	        	$("#c-fecha-hoy").html(respuesta.fecha_server);
	        	$("#c-hora-hoy").html(respuesta.hora_server);
	        	if(respuesta.age_estado_c=="L")
	        	{
	        		alert("La cita aun no ha sido asignada");
	        	}
	        	else
	        	{
	        		if(respuesta.age_estado_c=="C")
		        	{
		        		alert("La cita ya fue confirmada");
		        	}
		        	else
	        		{
	        			if(respuesta.age_estado_c=="A")
			        	{
			        		alert("Paciente ya fue atendido");
			        	}
			        	else
		        		{
		        			if($("#c-fecha-hoy").html()>$("#a-fecha").val())
			        		{
			        			alert("El Dia de la cita ya paso, No se puede confirmar");
			        		}
			        		else
			        		{
			        			if($("#c-fecha-hoy").html()<$("#a-fecha").val())
				        		{
				        			alert("El dia de la cita aun no llega. No se puede confirmar");
				        		}
				        		else
				        		{
				        			/*tiemporespuesta = tiempoTranscurrido(respuesta.age_hora_cita,respuesta.hora_server);
				        			//alert(tiemporespuesta.minutos);//tiempo de gracia para confirmar las citas
				        			if(respuesta.hora_server>respuesta.age_hora_cita && tiemporespuesta.minutos>15)
					        		{
					        			alert("La hora de la cita ya paso, No se puede confirmar");//-HS:"+respuesta.hora_server+" HC:"+respuesta.age_hora_cita+" TM:"+tiemporespuesta.minutos);
					        		}
					        		else
					        		{
					        			tiemporespuesta = tiempoTranscurrido(respuesta.hora_server, respuesta.age_hora_cita);
					        			if(parseInt(tiemporespuesta.horas)>0)
					        			{
						        			alert("Las citas se confirman maximo 1 hora antes, No se puede confirmar aun");
						        		}
						        		else
						        		{*/
						        			confirmacionCita();
						        		/*}
					        		}*/
				        		}	
			        		}
			        	}
		        	}
	        	}
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
	
	//alert("Confirmar cita?"+$("#cita").html()+"");
});

function tiempoTranscurrido(inicio,fin)
{
	var tiempo = new Array();
	inicioMinutos = parseInt(inicio.substr(3,2));
	inicioHoras = parseInt(inicio.substr(0,2));
	  
	finMinutos = parseInt(fin.substr(3,2));
	finHoras = parseInt(fin.substr(0,2));

	transcurridoMinutos = finMinutos - inicioMinutos;
	transcurridoHoras = finHoras - inicioHoras;
	  
	if (transcurridoMinutos < 0)
	{
	    transcurridoHoras--;
	    transcurridoMinutos = 60 + transcurridoMinutos;
	}
	  
	horas = transcurridoHoras;//.toString();
	minutos = transcurridoMinutos;//.toString();
	/*  
	if (horas.length < 2)
	{
	    horas = "0"+horas;
	}
	  
	if (horas.length < 2)
	{
	    horas = "0"+horas;
	}*/
	tiempo["horas"]=horas;
	tiempo["minutos"]=minutos;
	return tiempo;
}