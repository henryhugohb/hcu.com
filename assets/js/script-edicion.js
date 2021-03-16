$(document).ready(function(){
	$("#narchivo").focus();
});

function verificaExistencia()
{

	var parametros = {
        hcumsp: $("#hcus").val() 
    }
    var responsive=0;

    $.ajax({
        url: "assets/includes/verificaExistencia.php",
        type: 'POST',
        async: false,
        data: parametros,
        dataType: "json",
        success: function (respuesta)
        {
        	if(respuesta.codigo == 1)
          	{
	            if(respuesta.data == $("#narchivo").val())
	            {
	            	responsive = 1;
	            }
	            else
	            {
	            	alert("Ya existe el paciente: "+$("#hcus").val()+" con el Numero de archivo: "+respuesta.data);
	            	$("#hcus").focus();
	            	responsive = 0;
	            }
          	}
          	else
          	{
          		if(respuesta.codigo==2)
          		{
          			responsive = 1;
          		}
          	}
        }, 
        error: function (error) {
          console.log("ERROR: " + error);
        }
    });
    return responsive;
}

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
				$(".frm-todo").fadeIn();
				$("#hcus").val(respuesta.adm_hcu);
				$("#fechaadm").val(respuesta.adm_fecha_admision);
				$("#apellidos").val(respuesta.adm_apellido);
				$("#nombres").val(respuesta.adm_nombre);
				$("#fechan").val(respuesta.adm_fecha_nacimiento);
				$("#lssexo").val(respuesta.adm_sexo);
				$("#fechauc").val(respuesta.adm_fecha_cita_ultima);
				$("#fechapc").val(respuesta.adm_fecha_cita_proxima);
				$("#observacion").val(respuesta.adm_observacion);

				$("#amaterno").val('');
				$("#nombre2").val('');
				$("#nombre-padre").val('');
				$("#nombre-madre").val('');
				$("#p-telefono").val('');
				$("#n-representante").val('');
				$("#cd-representante").val('');

				$("#narchivo").prop('disabled','disabled');
				$("#fechaadm").focus();
			}
			else
			{
				if(respuesta.codigo==5)
				{
					encset=1;
					$(".frm-todo").fadeIn();
					$("#hcus").val(respuesta.adm_hcu);
					$("#fechaadm").val(respuesta.adm_fecha_admision);
					$("#apellidos").val(respuesta.adm_apellido.toUpperCase());
					$("#amaterno").val(respuesta.tar_amaterno.toUpperCase());
					$("#nombres").val(respuesta.adm_nombre.toUpperCase());
					$("#nombre2").val(respuesta.tar_nombre2.toUpperCase())
					$("#fechan").val(respuesta.adm_fecha_nacimiento);
					$("#lssexo").val(respuesta.adm_sexo);
					$("#fechauc").val(respuesta.adm_fecha_cita_ultima);
					$("#fechapc").val(respuesta.adm_fecha_cita_proxima);
					$("#observacion").val(respuesta.adm_observacion.toUpperCase());
					$("#nombre-padre").val(respuesta.tar_nombrepadre.toUpperCase());
					$("#nombre-madre").val(respuesta.tar_nombremadre.toUpperCase());
					$("#p-telefono").val(respuesta.tar_telefono);
					$("#n-representante").val(respuesta.tar_representante.toUpperCase());
					$("#cd-representante").val(respuesta.tar_cedrepresentante);
					$("#narchivo").prop('disabled','disabled');
					$("#fechaadm").focus();
				}
				else
				{
					encset=0;
					alert(respuesta.mensaje);
					$("#narchivo").focus();
					$(".frm-todo").hide();
				}
			}
		},
		error: function(error) {
			console.log("ERROR: "+error);
		}
	});
	$("#edad-actual").val(calculadoraEdadJs($("#fechan").val()));
	if($("#edad-actual").val()<5 && encset==1)
	{
		$("#frm-ced-repre").fadeIn();
	}
	else
	{
		$("#frm-ced-repre").hide();
	}
});

$("#narchivo").keypress(function(e){
	if(e.which == 13)
	{
		$("#btn-buscar").click();
		return false;
	}
});

function validaCedula(txt_control)
{
	var ncedula = $(txt_control).val();
	var nncedula = ncedula.length;
	if(nncedula<=10)
	{
		if (nncedula<10 || nncedula>10)
		{
			alert("Cedula Incorrecta: Debe contener diez digitos.");
			$(txt_control).attr('style','background-color: #FF69B4;');
			return false;
		}
		else
		{
			var provincia = ncedula[0] + ncedula[1];
			if (provincia>24 || provincia<1)
			{
				alert("Cedula Incorrecta: Error en el Numero de la provincia.");
				$(txt_control).attr('style','background-color: #FF69B4;');
				return false;
			}
			else
			{
				if (ncedula[2]>6)/*se cambio el if (ncedula[2]>5) por que daba error*/
				{
					alert("Cedula Incorrecta: Error en tercer Digito.");
					$(txt_control).attr('style','background-color: #FF69B4;');
					return false;
				}
				else
				{
					var resultado =0;
					var acumularesultado =0;
					var dsuperior=0;
					var ultimodigito = 0;
					var decena = " ";
					for (var i = 0; i < (nncedula-1); i++)
					{
						multiplicador = i%2;
						if (multiplicador==0) {multiplicador=2;}
						resultado = ncedula[i] * multiplicador;
						if (resultado>=10){ resultado=resultado-9;}
						acumularesultado = acumularesultado + resultado;
					}
					decena = acumularesultado + "";
					decena.length;
					dsuperior = (decena[0]*10)+10;
					ultimodigito = dsuperior - acumularesultado;
					if(ultimodigito==10){ultimodigito=0;}
					if(ultimodigito!=ncedula[9])
					{
						alert("Cedula Incorrecta: Revise que este escrita correctamente.");
						$(txt_control).attr('style','background-color: #FF69B4;');
						return false;
					}
					else
					{
						$(txt_control).attr('style','background-color: #FFFFFF;');
						return true;
					}
				}
			}
		}
	}	
}

$("#hcus").keypress(function(e){
	if(e.which == 13)
	{
		if($("#hcus").val().length==10)
		{
			if(validaCedula("#hcus"))
			{
				$("#apellidos").focus();
			}
		}
		else
		{
			alert("Ingrese el numero de cedula");
			$("#hcus").focus();	
		}
		return false;
	}
});

$("#hcus").blur(function(){
	validaCedula("#hcus");
});

$("#cd-representante").keypress(function(e){
	if(e.which == 13)
	{
		if($("#cd-representante").val().length==10)
		{
			if(validaCedula("#cd-representante"))
			{
				$("#lssexo").focus();
			}
		}
		else
		{
			alert("Ingrese el numero de cedula");
			$("#cd-representante").focus();	
		}
		return false;
	}
});

$("#cd-representante").blur(function(){
	validaCedula("#cd-representante");
});

$("#fechan").keypress(function(e){
	if(e.which == 13)
	{
		$("#edad-actual").val(calculadoraEdadJs($("#fechan").val()));
		if($("#edad-actual").val()>150)
		{
			alert("Error en la fecha de nacimiento");
			$("#frm-ced-repre").hide();
			$("#fechan").focus();
		}
		else
		{
			if($("#edad-actual").val()<5)
			{
				$("#frm-ced-repre").fadeIn();
				$("#n-representante").focus();
			}
			else
			{
				$("#frm-ced-repre").hide();
				$("#lssexo").focus();
			}	
		}
		return false;
	}
});

$("#fechan").blur(function(){
	$("#edad-actual").val(calculadoraEdadJs($("#fechan").val()));
	if($("#edad-actual").val()>150)
	{
		alert("Error en la fecha de nacimiento");
		$("#frm-ced-repre").hide();
	}
	else
	{
		if($("#edad-actual").val()<5)
		{
			$("#frm-ced-repre").fadeIn();
			$("#frm-ced-repre").attr('alt','on');
		}
		else
		{
			$("#frm-ced-repre").hide();
			$("#frm-ced-repre").attr('alt','off');
		}	
	}
});

function prepararEnvio()
{	
	if($("#apellidos").val().trim()=="" && $("#amaterno").val().trim()=="")
	{
		alert("Debe Ingresar al menos un apellido del paciente");
		$("#apellidos").focus();
	}
	else
	{
		if($("#nombres").val().trim()=="" && $("#nombre2").val().trim()=="")
		{
			alert("Debe Ingresar al menos un nombre del paciente");
			$("#nombres").focus();
		}
		else
		{
			if($("#nombre-padre").val().trim()=="")
			{
				alert("Debe Ingresar el nombre del padre");
				$("#nombre-padre").focus();
			}
			else
			{
				if($("#nombre-madre").val().trim()=="")
				{
					alert("Debe Ingresar el nombre de la madre");
					$("#nombre-madre").focus();
				}
				else
				{
					if($("#fechan").val()==0)
					{
						alert("Debe Ingresar la fecha de nacimiento");
						$("#fechan").focus();
					}
					else
					{
						if($("#p-telefono").val().trim()=="" || ($("#p-telefono").val().length>1 && $("#p-telefono").val().length<10))
						{
							alert("Debe Ingresar el numero del telefono correcto");
							$("#p-telefono").focus();
						}
						else
						{
							if(validaCedula("#hcus"))
							{
								if($("#edad-actual").val()<5)
								{
									if($("#n-representante").val().trim()=="")
									{
										alert("Debe Ingresar el nombre del representante");
										$("#n-representante").focus();
									}
									else
									{
										if(validaCedula("#cd-representante"))
										{
											return true;
										}
									}
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
		}
	}			
}

$("#btn-guardar").click(function(){
	if(prepararEnvio())
	{
		espaciador1 = $("#apellidos").val().trim().toUpperCase();
		espaciador2 = $("#amaterno").val().trim().toUpperCase();
		espaciador3 = $("#nombres").val().trim().toUpperCase();
		espaciador4 = $("#nombre2").val().trim().toUpperCase();
		var parametros_envio = {
			adm_fecha_admision: $("#fechaadm").val(),
			adm_na: $("#narchivo").val(),
			adm_apellido: espaciador1+' '+espaciador2,
			adm_nombre: espaciador3+' '+espaciador4,
			adm_hcu: $("#hcus").val(),
			adm_fecha_nacimiento: $("#fechan").val(),
			adm_sexo: $("#lssexo").val(),
			adm_fecha_cita_ultima: $("#fechauc").val(),
			adm_fecha_cita_proxima: $("#fechapc").val(),
			adm_estado: 'A',
			adm_observacion: $("#observacion").val().trim().toUpperCase(),
			/***********para tabla tarjetero***********/
			tar_apaterno: espaciador1.toLowerCase(),
			tar_amaterno: espaciador2.toLowerCase(),
			tar_nombre1: espaciador3.toLowerCase(),
			tar_nombre2: espaciador4.toLowerCase(),
			tar_nombrepadre: $("#nombre-padre").val().trim().toLowerCase(),
			tar_nombremadre: $("#nombre-madre").val().trim().toLowerCase(),
			tar_edad: $("#edad-actual").val(),
			tar_telefono: $("#p-telefono").val(),
			tar_representante: $("#n-representante").val().trim().toLowerCase(),
			tar_cedrepresentante: $("#cd-representante").val()
		}
		var r= confirm("Esta seguro de guardar el registro actual?");
		if(r==true)
		{
			$.ajax({
		        url: "assets/includes/actualizarAdmision.php",
		        type: 'POST',
		        async: false,
		        data: parametros_envio,
		        dataType: "json",
		        success: function (respuesta)
		        {
		        	if(respuesta.codigo == 1)
		          	{
		            	guardaTarjetero();
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

function guardaTarjetero()
{
	espaciador1 = $("#apellidos").val().trim().toUpperCase();
	espaciador2 = $("#amaterno").val().trim().toUpperCase();
	espaciador3 = $("#nombres").val().trim().toUpperCase();
	espaciador4 = $("#nombre2").val().trim().toUpperCase();
	var parametros_envio = {
		adm_fecha_admision: $("#fechaadm").val(),
		adm_na: $("#narchivo").val(),
		adm_apellido: espaciador1+' '+espaciador2,
		adm_nombre: espaciador3+' '+espaciador4,
		adm_hcu: $("#hcus").val(),
		adm_fecha_nacimiento: $("#fechan").val(),
		adm_sexo: $("#lssexo").val(),
		adm_fecha_cita_ultima: $("#fechauc").val(),
		adm_fecha_cita_proxima: $("#fechapc").val(),
		adm_estado: 'A',
		adm_observacion: $("#observacion").val().trim().toUpperCase(),
		/***********para tabla tarjetero***********/
		tar_apaterno: espaciador1.toLowerCase(),
		tar_amaterno: espaciador2.toLowerCase(),
		tar_nombre1: espaciador3.toLowerCase(),
		tar_nombre2: espaciador4.toLowerCase(),
		tar_nombrepadre: $("#nombre-padre").val().trim().toLowerCase(),
		tar_nombremadre: $("#nombre-madre").val().trim().toLowerCase(),
		tar_edad: $("#edad-actual").val(),
		tar_telefono: $("#p-telefono").val(),
		tar_representante: $("#n-representante").val().trim().toLowerCase(),
		tar_cedrepresentante: $("#cd-representante").val()
	}
	$.ajax({
        url: "assets/includes/actualizarAdmisionTarjetero.php",
        type: 'POST',
        async: false,
        data: parametros_envio,
        dataType: "json",
        success: function (respuesta)
        {
        	if(respuesta.codigo == 1)
          	{
            	$("#edicion").hide();
            	$("#edicion-guardada").fadeIn();
            	$("#mensaje-guardado").html(respuesta.mensaje);
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

$("#p-telefono").keypress(function(e){
	if(e.which == 13)
	{
		if($("#p-telefono").val().trim()!="")
		{
			$("#fechauc").focus();
			return false;
		}
	}
});

$("#fechauc").keypress(function(e){
	if(e.which == 13)
	{
		if($("#fechauc").val()!="")
		{
			$("#fechapc").focus();
			return false;
		}
	}
});

$("#fechapc").keypress(function(e){
	if(e.which == 13)
	{
		if($("#fechapc").val()!="")
		{
			$("#observacion").focus();
			return false;
		}
	}
});

$("#observacion").keypress(function(e){
	if(e.which == 13)
	{
		$("#btn-guardar").focus();
		return false;
	}
});

$("#fechaadm").keypress(function(e){
	if(e.which == 13)
	{
		if($("#fechaadm").val()!="")
		{
			$("#hcus").focus();
			return false;
		}
	}
});

$("#apellidos").keypress(function(e){
	if(e.which == 13)
	{
		$("#amaterno").focus();
		return false;
	}
});

$("#amaterno").keypress(function(e){
	if(e.which == 13)
	{
		$("#nombres").focus();
		return false;
	}
});

$("#nombres").keypress(function(e){
	if(e.which == 13)
	{
		$("#nombre2").focus();
		return false;
	}
});

$("#nombre2").keypress(function(e){
	if(e.which == 13)
	{
		$("#nombre-padre").focus();
		return false;
	}
});

$("#nombre-padre").keypress(function(e){
	if(e.which == 13)
	{
		if($("#nombre-padre").val().trim()!="")
		{
			$("#nombre-madre").focus();
			return false;
		}
	}
});

$("#nombre-madre").keypress(function(e){
	if(e.which == 13)
	{
		if($("#nombre-madre").val().trim()!="")
		{
			$("#fechan").focus();
			return false;
		}
	}
});

$("#btn-ap-separar").click(function(){
	var npalabras=0;
	npalabras = $("#apellidos").val().split(" ").length;
	if($("#amaterno").val().trim()=="")
	{
		if(npalabras>=2)
		{
			tnombres=$("#apellidos").val().split(" ");
			for(ij=0;ij<(npalabras);ij++)
			{
				if(ij==0)
				{
					$("#apellidos").val(tnombres[ij]);
				}
				else
				{
					if(npalabras==2)
					{
						$("#amaterno").val(tnombres[ij]);
					}
					else
					{
						$("#amaterno").val($("#amaterno").val()+" "+tnombres[ij]);
					}	
				}
			}
		}
	}
});
$("#btn-no-separar").click(function(){
	var npalabras=0;
	npalabras = $("#nombres").val().split(" ").length;
	if($("#nombre2").val().trim()=="")
	{
		if(npalabras>=2)
		{
			tnombres=$("#nombres").val().split(" ");
			for(ij=0;ij<(npalabras);ij++)
			{
				if(ij==0)
				{
					$("#nombres").val(tnombres[ij]);
				}
				else
				{
					if(npalabras==2)
					{
						$("#nombre2").val(tnombres[ij]);
					}
					else
					{
						$("#nombre2").val($("#nombre2").val()+" "+tnombres[ij]);
					}	
				}
			}
		}
	}
});
$("#btn-a-padres").click(function(){
	if($("#nombre-padre").val().trim()=="")
	{
		$("#nombre-padre").val($("#apellidos").val())
	}
	if($("#nombre-madre").val().trim()=="")
	{
		$("#nombre-madre").val($("#amaterno").val())
	}
});