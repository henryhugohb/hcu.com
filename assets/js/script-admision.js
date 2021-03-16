$(document).ready(function(){
	$(".frm-ced-repre").hide();
});

$("#txt-cedula").keypress(function(e){
	if(e.which == 13)
	{
		validaCedula("#txt-cedula");
		return false;
	}
});

function validaCedula(txt_control)
{
	var ncedula = $(""+txt_control+"").val();
	var nncedula = ncedula.length;
	if (nncedula<10 || nncedula>10)
	{
		alert("Cedula Incorrecta: Debe contener diez digitos.");
		$(txt_control).focus();
		return false;
	}
	else
	{
		var provincia = ncedula[0] + ncedula[1];
		if (provincia>24 || provincia<1)
		{
			alert("Cedula Incorrecta: Error en el Numero de la provincia.");
			$(txt_control).focus();
			return false;
		}
		else
		{
			if (ncedula[2]>10)/*se cambio el if (ncedula[2]>5) por que daba error*/
			{
				alert("Cedula Incorrecta: Error en tercer Digito.");
				$(txt_control).focus();
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
					$(txt_control).attr('style','background-color: red;');
					return false;
				}
				else
				{
					$(txt_control).attr('style','background-color: white;');
					return true;
				}
			}
		}
	}	
}

function llenarNumerodearchivo()
{
	$.ajax({
		url: "assets/includes/llenarNumerodearchivo.php",
		type: 'POST',
		async: false,
		data: "",
		dataType: "json",
		success: function(respuesta)
		{
			if(respuesta.codigo == 1)
          	{
            	if($("#titulo-admision").attr("alt")!="insertar")
          		{
            		$("#narchivo").val(respuesta.contenido);
            	}
            	$("#btn-guardar").show();
          	}
          	else
          	{
          		if(respuesta.codigo==0)
          		{
          			$("#narchivo").val(respuesta.contenido);
            		$("#btn-guardar").show();
          		}
          	}
        }, 
        error: function (error) {
          console.log("ERROR: " + error);
        }
	});
}

function verificaExistencia()
{
	var parametros = {
        hcumsp: $("#hcus").val() 
    }

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
            	alert(respuesta.mensaje);
            	$("#narchivo").val(respuesta.data);
          	}
          	else
          	{
          		if(respuesta.codigo==2)
          		{
          			llenarNumerodearchivo();
          		}
          		else
          		{
          			alert(respuesta.mensaje);	
          		}
          	}
        }, 
        error: function (error) {
          console.log("ERROR: " + error);
        }
    });
}

function prepararEnvio()
{	
	if($("#titulo-admision").attr("alt")=="ad-cedula" || $("#titulo-admision").attr("alt")=="ad-inscrito" || $("#titulo-admision").attr("alt")=="insertar")
	{
		var ncedula ,espaciador1, espaciador2,espaciador3, espaciador4 ="";
		espaciador1 = $("#apellidop").val();
		espaciador1 = espaciador1.trim();
		espaciador2 = $("#apellidom").val();
		espaciador2 = espaciador2.trim();
		espaciador3 = $("#nombre1").val();
		espaciador3 = espaciador3.trim();
		espaciador4 = $("#nombre2").val();
		espaciador4 = espaciador4.trim();
		if((espaciador1 == "") && (espaciador2 == ""))
		{
			alert("Debe Ingresar al menos un apellido");
			$("#apellidop").focus();
		}
		else
		{
			if((espaciador3 == "") && (espaciador4 == ""))
			{
				alert("Debe Ingresar al menos un nombre");
				$("#nombre1").focus();
			}
			else
			{
				if($("#fechan").val()=="")
				{
					alert("Debe Ingresar su fecha de nacimiento");
					$("#fechan").focus();
				}
				/*****modificacion 20-04-2016***/
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
							if($("#p-telefono").val().trim()=="" || $("#p-telefono").val().length<10)
							{
								alert("Debe Ingresar el numero de telefono correcto.");
								$("#p-telefono").focus();
							}
							else
							{
								if($(".frm-ced-repre").attr('alt')=="on")
								{
									if($("#n-representante").val().trim()=="")
									{
										alert("Debe Ingresar el nombre del representante");
										$("#n-representante").focus();
									}
									else
									{
										if($("#cd-representante").val().trim()=="" || $("#p-telefono").val().length<10)
										{
											alert("Debe Ingresar la cedula del representante");
											$("#cd-representante").focus();
										}
										else
										{
											precadena5 = $("#lsprovincias").val();
											var precadenafecha = $("#fechan").val();
											if ($("#titulo-admision").attr("alt")=="ad-cedula"  || $("#titulo-admision").attr("alt")=="insertar")
											{
												ncedula = $("#txt-cedula").val();
												if(validaCedula("#txt-cedula"))
												{
													if(validaCedula("#cd-representante"))
													{
														espaciador1 = espaciador1.trim().toUpperCase();
														espaciador2 = espaciador2.trim().toUpperCase();
														espaciador3 = espaciador3.trim().toUpperCase();
														espaciador4 = espaciador4.trim().toUpperCase();
														var parametros_envio = {
															adm_fecha_admision: $("#fecha-dia").html(),
															adm_na: $("#narchivo").val(),
															adm_apellido: espaciador1+" "+espaciador2,
															adm_nombre: espaciador3+" "+espaciador4,
															adm_hcu: ncedula,
															adm_fecha_nacimiento: $("#fechan").val(),
															adm_sexo: $("#lssexo").val(),
															adm_fecha_cita_ultima: $("#fecha-dia").html(),
															adm_fecha_cita_proxima: $("#fecha-dia").html(),
															adm_estado: 'A',
															/**para tabla tarjetero_unidad**/
															tar_apaterno: espaciador1.toLowerCase(),
															tar_amaterno: espaciador2.toLowerCase(),
															tar_nombre1: espaciador3.toLowerCase(),
															tar_nombre2: espaciador4.toLowerCase(),
															tar_nombrepadre: $("#nombre-padre").val().trim().toLowerCase(),
															tar_nombremadre: $("#nombre-madre").val().trim().toLowerCase(),
															tar_edad: calculadoraEdadJs($("#fechan").val()),
															tar_telefono: $("#p-telefono").val(),
															tar_representante: $("#n-representante").val().trim().toLowerCase(),
															tar_cedrepresentante: $("#cd-representante").val()
														}
														return parametros_envio;
													}
													else
													{
														return 0;
													} 
												}
												else
												{
													return 0;
												}
											}
											else
											{
												if ($("#titulo-admision").attr("alt")=="ad-inscrito")
												{
													var precadena1, precadena2, precadena3, precadena4, precadena5, precadena6, precadena7, precadena8, precadena9 ="";
													if(espaciador1 == "")
													{
														precadena1 = espaciador2;
														precadena1 = precadena1.toUpperCase();
														precadena1 = precadena1[0]+precadena1[1];
														precadena2 = "0";
													}
													else
													{
														if (espaciador2 == "")
														{
															precadena1 = espaciador1;
															precadena1 = precadena1.toUpperCase();
															precadena1 = precadena1[0]+precadena1[1];
															precadena2 = "0";
														}
														else
														{
															precadena1 = espaciador1;
															precadena1 = precadena1.toUpperCase();
															precadena1 = precadena1[0]+precadena1[1];
															precadena2 = espaciador2;
															precadena2 = precadena2.toUpperCase();
															precadena2 = precadena2[0];
														}
													}
													if(espaciador3 == "")
													{
														precadena3 = espaciador4;
														precadena3 = precadena3.toUpperCase();
														precadena3 = precadena3[0]+precadena3[1];
														precadena4 = "0";
													}
													else
													{
														if (espaciador4 == "")
														{
															precadena3 = espaciador3;
															precadena3 = precadena3.toUpperCase();
															precadena3 = precadena3[0]+precadena3[1];
															precadena4 = "0";
														}
														else
														{
															precadena3 = espaciador3;
															precadena3 = precadena3.toUpperCase();
															precadena3 = precadena3[0]+precadena3[1];
															precadena4 = espaciador4;
															precadena4 = precadena4.toUpperCase();
															precadena4 = precadena4[0];
														}
													}
													precadena5 = $("#lsprovincias").val();
													var precadenafecha = $("#fechan").val();
													precadena6 = precadenafecha[0]+precadenafecha[1]+precadenafecha[2]+precadenafecha[3];
													precadena7 = precadenafecha[5]+precadenafecha[6];
													precadena8 = precadenafecha[8]+precadenafecha[9];
													precadena9 = precadenafecha[2];
													espaciador1 = espaciador1.toUpperCase();
													espaciador2 = espaciador2.toUpperCase();
													espaciador3 = espaciador3.toUpperCase();
													espaciador4 = espaciador4.toUpperCase();
													var parametros_envio = {
														adm_fecha_admision: $("#fecha-dia").html(),
														adm_na: $("#narchivo").val(),
														adm_apellido: espaciador1+" "+espaciador2,
														adm_nombre: espaciador3+" "+espaciador4,
														adm_hcu: (precadena3 + precadena4 + precadena1 + precadena2 + precadena5 + precadena6 + precadena7 + precadena8+precadena9+""),
														adm_fecha_nacimiento: $("#fechan").val(),
														adm_sexo: $("option").attr('value'),
														adm_fecha_cita_ultima: $("#fecha-dia").html(),
														adm_fecha_cita_proxima: $("#fecha-dia").html(),
														adm_estado: 'A',
														/**para tabla tarjetero_unidad**/
														tar_apaterno: espaciador1.toLowerCase(),
														tar_amaterno: espaciador2.toLowerCase(),
														tar_nombre1: espaciador3.toLowerCase(),
														tar_nombre2: espaciador4.toLowerCase(),
														tar_nombrepadre: $("#nombre-padre").val().toLowerCase(),
														tar_nombremadre: $("#nombre-madre").val().toLowerCase(),
														tar_edad: calculadoraEdadJs($("#fechan").val()),
														tar_telefono: $("#p-telefono").val(),
														tar_representante: $("#n-representante").val(),
														tar_cedrepresentante: $("#cd-representante").val()
													}
													return parametros_envio;
												}
											}	
										}
									}
								}
								else
								{
									precadena5 = $("#lsprovincias").val();
									var precadenafecha = $("#fechan").val();
									if ($("#titulo-admision").attr("alt")=="ad-cedula"  || $("#titulo-admision").attr("alt")=="insertar")
									{
										ncedula = $("#txt-cedula").val();
										if(validaCedula("#txt-cedula"))
										{
											espaciador1 = espaciador1.trim().toUpperCase();
											espaciador2 = espaciador2.trim().toUpperCase();
											espaciador3 = espaciador3.trim().toUpperCase();
											espaciador4 = espaciador4.trim().toUpperCase();
											var parametros_envio = {
												adm_fecha_admision: $("#fecha-dia").html(),
												adm_na: $("#narchivo").val(),
												adm_apellido: espaciador1+" "+espaciador2,
												adm_nombre: espaciador3+" "+espaciador4,
												adm_hcu: ncedula,
												adm_fecha_nacimiento: $("#fechan").val(),
												adm_sexo: $("#lssexo").val(),
												adm_fecha_cita_ultima: $("#fecha-dia").html(),
												adm_fecha_cita_proxima: $("#fecha-dia").html(),
												adm_estado: 'A',
												/**para tabla tarjetero_unidad**/
												tar_apaterno: espaciador1.toLowerCase(),
												tar_amaterno: espaciador2.toLowerCase(),
												tar_nombre1: espaciador3.toLowerCase(),
												tar_nombre2: espaciador4.toLowerCase(),
												tar_nombrepadre: $("#nombre-padre").val().trim().toLowerCase(),
												tar_nombremadre: $("#nombre-madre").val().trim().toLowerCase(),
												tar_edad: calculadoraEdadJs($("#fechan").val()),
												tar_telefono: $("#p-telefono").val(),
												tar_representante: $("#n-representante").val().trim().toLowerCase(),
												tar_cedrepresentante: $("#cd-representante").val()
											}
											return parametros_envio; 
										}
										else
										{
											
											return 0;
										}
									}
									else
									{
										if ($("#titulo-admision").attr("alt")=="ad-inscrito")
										{
											var precadena1, precadena2, precadena3, precadena4, precadena5, precadena6, precadena7, precadena8, precadena9 ="";
											if(espaciador1 == "")
											{
												precadena1 = espaciador2;
												precadena1 = precadena1.toUpperCase();
												precadena1 = precadena1[0]+precadena1[1];
												precadena2 = "0";
											}
											else
											{
												if (espaciador2 == "")
												{
													precadena1 = espaciador1;
													precadena1 = precadena1.toUpperCase();
													precadena1 = precadena1[0]+precadena1[1];
													precadena2 = "0";
												}
												else
												{
													precadena1 = espaciador1;
													precadena1 = precadena1.toUpperCase();
													precadena1 = precadena1[0]+precadena1[1];
													precadena2 = espaciador2;
													precadena2 = precadena2.toUpperCase();
													precadena2 = precadena2[0];
												}
											}
											if(espaciador3 == "")
											{
												precadena3 = espaciador4;
												precadena3 = precadena3.toUpperCase();
												precadena3 = precadena3[0]+precadena3[1];
												precadena4 = "0";
											}
											else
											{
												if (espaciador4 == "")
												{
													precadena3 = espaciador3;
													precadena3 = precadena3.toUpperCase();
													precadena3 = precadena3[0]+precadena3[1];
													precadena4 = "0";
												}
												else
												{
													precadena3 = espaciador3;
													precadena3 = precadena3.toUpperCase();
													precadena3 = precadena3[0]+precadena3[1];
													precadena4 = espaciador4;
													precadena4 = precadena4.toUpperCase();
													precadena4 = precadena4[0];
												}
											}
											precadena5 = $("#lsprovincias").val();
											var precadenafecha = $("#fechan").val();
											precadena6 = precadenafecha[0]+precadenafecha[1]+precadenafecha[2]+precadenafecha[3];
											precadena7 = precadenafecha[5]+precadenafecha[6];
											precadena8 = precadenafecha[8]+precadenafecha[9];
											precadena9 = precadenafecha[2];
											espaciador1 = espaciador1.trim().toUpperCase();
											espaciador2 = espaciador2.trim().toUpperCase();
											espaciador3 = espaciador3.trim().toUpperCase();
											espaciador4 = espaciador4.trim().toUpperCase();
											var parametros_envio = {
												adm_fecha_admision: $("#fecha-dia").html(),
												adm_na: $("#narchivo").val(),
												adm_apellido: espaciador1+" "+espaciador2,
												adm_nombre: espaciador3+" "+espaciador4,
												adm_hcu: (precadena3 + precadena4 + precadena1 + precadena2 + precadena5 + precadena6 + precadena7 + precadena8+precadena9+""),
												adm_fecha_nacimiento: $("#fechan").val(),
												adm_sexo: $("option").attr('value'),
												adm_fecha_cita_ultima: $("#fecha-dia").html(),
												adm_fecha_cita_proxima: $("#fecha-dia").html(),
												adm_estado: 'A',
												/**para tabla tarjetero_unidad**/
												tar_apaterno: espaciador1.toLowerCase(),
												tar_amaterno: espaciador2.toLowerCase(),
												tar_nombre1: espaciador3.toLowerCase(),
												tar_nombre2: espaciador4.toLowerCase(),
												tar_nombrepadre: $("#nombre-padre").val().trim().toLowerCase(),
												tar_nombremadre: $("#nombre-madre").val().trim().toLowerCase(),
												tar_edad: calculadoraEdadJs($("#fechan").val()),
												tar_telefono: $("#p-telefono").val(),
												tar_representante: $("#n-representante").val().trim().toLowerCase(),
												tar_cedrepresentante: $("#cd-representante").val()
											}
											return parametros_envio;
										}
									}	
								}
							}
						}
					}
				}
			}
		}
	}
	else
	{
		if($("#titulo-admision").attr("alt")=="ad-no-inscrito")
		{
			var espaciador1, espaciador2,espaciador3, espaciador4 ="";
			espaciador1 = $("#madreapellidop").val();
			espaciador1 = espaciador1.trim();
			espaciador2 = $("#madreapellidom").val();
			espaciador2 = espaciador2.trim();
			espaciador3 = $("#madrenombre1").val();
			espaciador3 = espaciador3.trim();
			espaciador4 = $("#madrenombre2").val();
			espaciador4 = espaciador4.trim();
			if((espaciador1 == "") && (espaciador2 == ""))
			{
				alert("Debe Ingresar al menos un apellido");
				$("#madreapellidop").focus();
			}
			else
			{
				if(espaciador3 == "")
				{
					alert("Debe Ingresar el nombre de la Madre");
					$("#madrenombre1").focus();
				}
				else
				{
					if(espaciador4 == 0 || isNaN(espaciador4))
					{
						alert("Debe Ingresar el numero de orden de hijos nacidos vivos");
						$("#madrenombre2").focus();
					}
					else
					{
						if($("#fechan").val()=="")
						{
							alert("Debe Ingresar su fecha de nacimiento");
							$("#fechan").focus();
						}
						else
						{
							var precadena1, precadena2, precadena3, precadena4, precadena5, precadena6, precadena7, precadena8, precadena9 ="";
							if(espaciador1 == "")
							{
								precadena1 = espaciador2;
								precadena1 = precadena1.toUpperCase();
								precadena1 = precadena1[0]+precadena1[1];
								precadena2 = "0";
							}
							else
							{
								if (espaciador2 == "")
								{
									precadena1 = espaciador1;
									precadena1 = precadena1.toUpperCase();
									precadena1 = precadena1[0]+precadena1[1];
									precadena2 = "0";
								}
								else
								{
									precadena1 = espaciador1;
									precadena1 = precadena1.toUpperCase();
									precadena1 = precadena1[0]+precadena1[1];
									precadena2 = espaciador2;
									precadena2 = precadena2.toUpperCase();
									precadena2 = precadena2[0];
								}
							}
							if(espaciador3 == "")
							{
								precadena3 = espaciador4;
								precadena3 = precadena3.toUpperCase();
								precadena3 = precadena3[0]+precadena3[1];
								precadena4 = "0";
							}
							else
							{
								if (espaciador4 == "")
								{
									precadena3 = espaciador3;
									precadena3 = precadena3.toUpperCase();
									precadena3 = precadena3[0]+precadena3[1];
									precadena4 = "0";
								}
								else
								{
									precadena3 = espaciador3;
									precadena3 = precadena3.toUpperCase();
									precadena3 = precadena3[0]+precadena3[1];
									precadena4 = espaciador4;
									precadena4 = precadena4.toUpperCase();
									precadena4 = precadena4[0];
								}
							}
							precadena5 = $("#lsprovincias").val();
							var precadenafecha = $("#fechan").val();
							precadena6 = precadenafecha[0]+precadenafecha[1]+precadenafecha[2]+precadenafecha[3];
							precadena7 = precadenafecha[5]+precadenafecha[6];
							precadena8 = precadenafecha[8]+precadenafecha[9];
							precadena9 = precadenafecha[2];
							espaciador1 = espaciador1.trim().toUpperCase();
							espaciador2 = espaciador2.trim().toUpperCase();
							espaciador3 = espaciador3.trim().toUpperCase();
							espaciador4 = espaciador4.trim().toUpperCase();
							var parametros_envio = {
								adm_fecha_admision: $("#fecha-dia").html(),
								adm_na: $("#narchivo").val(),
								adm_apellido: espaciador1+" "+espaciador2,
								adm_nombre: espaciador3+" "+espaciador4,
								adm_hcu: (precadena3 + precadena4 + precadena1 + precadena2 + precadena5 + precadena6 + precadena7 + precadena8+precadena9+""),
								adm_fecha_nacimiento: $("#fechan").val(),
								adm_sexo: $("option").attr('value'),
								adm_fecha_cita_ultima: $("#fecha-dia").html(),
								adm_fecha_cita_proxima: $("#fecha-dia").html(),
								adm_estado: 'A',
								/**para tabla tarjetero_unidad**/
								tar_apaterno: espaciador1.toLowerCase(),
								tar_amaterno: espaciador2.toLowerCase(),
								tar_nombre1: espaciador3.toLowerCase(),
								tar_nombre2: espaciador4.toLowerCase(),
								tar_nombrepadre: $("#nombre-padre").val().trim().toLowerCase(),
								tar_nombremadre: $("#nombre-madre").val().trim().toLowerCase(),
								tar_edad: calculadoraEdadJs($("#fechan").val()),
								tar_telefono: $("#p-telefono").val(),
								tar_representante: $("#n-representante").val().trim().toLowerCase(),
								tar_cedrepresentante: $("#cd-representante").val()
							}
							return parametros_envio;
						}
					}
				}
			}
		}
	}
}

function generarHcumsp()
{
	if($("#titulo-admision").attr("alt")=="ad-cedula" || $("#titulo-admision").attr("alt")=="ad-inscrito"  || $("#titulo-admision").attr("alt")=="insertar")
	{
		var ncedula ,espaciador1, espaciador2,espaciador3, espaciador4 ="";
		espaciador1 = $("#apellidop").val();
		espaciador1 = espaciador1.trim();
		espaciador2 = $("#apellidom").val();
		espaciador2 = espaciador2.trim();
		espaciador3 = $("#nombre1").val();
		espaciador3 = espaciador3.trim();
		espaciador4 = $("#nombre2").val();
		espaciador4 = espaciador4.trim();
		if((espaciador1 == "") && (espaciador2 == ""))
		{
			alert("Debe Ingresar al menos un apellido");
			$("#apellidop").focus();
		}
		else
		{
			if((espaciador3 == "") && (espaciador4 == ""))
			{
				alert("Debe Ingresar al menos un nombre");
				$("#nombre1").focus();
			}
			else
			{
				if($("#fechan").val()=="")
				{
					alert("Debe Ingresar su fecha de nacimiento");
					$("#fechan").focus();
				}
				else
				{
					precadena5 = $("#lsprovincias").val();
					var precadenafecha = $("#fechan").val();
					if ($("#titulo-admision").attr("alt")=="ad-cedula" || $("#titulo-admision").attr("alt")=="insertar")
					{
						ncedula = $("#txt-cedula").val();
						if(validaCedula("#txt-cedula"))
						{
							return ncedula;
						}
						else
						{
							return 0;
						}
					}
					else
					{
						if ($("#titulo-admision").attr("alt")=="ad-inscrito")
						{
							var precadena1, precadena2, precadena3, precadena4, precadena5, precadena6, precadena7, precadena8, precadena9 ="";
							if(espaciador1 == "")
							{
								precadena1 = espaciador2;
								precadena1 = precadena1.toUpperCase();
								precadena1 = precadena1[0]+precadena1[1];
								precadena2 = "0";
							}
							else
							{
								if (espaciador2 == "")
								{
									precadena1 = espaciador1;
									precadena1 = precadena1.toUpperCase();
									precadena1 = precadena1[0]+precadena1[1];
									precadena2 = "0";
								}
								else
								{
									precadena1 = espaciador1;
									precadena1 = precadena1.toUpperCase();
									precadena1 = precadena1[0]+precadena1[1];
									precadena2 = espaciador2;
									precadena2 = precadena2.toUpperCase();
									precadena2 = precadena2[0];
								}
							}
							if(espaciador3 == "")
							{
								precadena3 = espaciador4;
								precadena3 = precadena3.toUpperCase();
								precadena3 = precadena3[0]+precadena3[1];
								precadena4 = "0";
							}
							else
							{
								if (espaciador4 == "")
								{
									precadena3 = espaciador3;
									precadena3 = precadena3.toUpperCase();
									precadena3 = precadena3[0]+precadena3[1];
									precadena4 = "0";
								}
								else
								{
									precadena3 = espaciador3;
									precadena3 = precadena3.toUpperCase();
									precadena3 = precadena3[0]+precadena3[1];
									precadena4 = espaciador4;
									precadena4 = precadena4.toUpperCase();
									precadena4 = precadena4[0];
								}
							}
							precadena5 = $("#lsprovincias").val();
							var precadenafecha = $("#fechan").val();
							precadena6 = precadenafecha[0]+precadenafecha[1]+precadenafecha[2]+precadenafecha[3];
							precadena7 = precadenafecha[5]+precadenafecha[6];
							precadena8 = precadenafecha[8]+precadenafecha[9];
							precadena9 = precadenafecha[2];
							return (precadena3 + precadena4 + precadena1 + precadena2 + precadena5 + precadena6 + precadena7 + precadena8+precadena9+"");
						}
					}	
				}
			}
		}
	}
	else
	{
		if($("#titulo-admision").attr("alt")=="ad-no-inscrito")
		{
			var espaciador1, espaciador2,espaciador3, espaciador4 ="";
			espaciador1 = $("#madreapellidop").val();
			espaciador1 = espaciador1.trim();
			espaciador2 = $("#madreapellidom").val();
			espaciador2 = espaciador2.trim();
			espaciador3 = $("#madrenombre1").val();
			espaciador3 = espaciador3.trim();
			espaciador4 = $("#madrenombre2").val();
			espaciador4 = espaciador4.trim();
			if((espaciador1 == "") && (espaciador2 == ""))
			{
				alert("Debe Ingresar al menos un apellido");
				$("#madreapellidop").focus();
			}
			else
			{
				if(espaciador3 == "")
				{
					alert("Debe Ingresar el nombre de la Madre");
					$("#madrenombre1").focus();
				}
				else
				{
					if(espaciador4 == 0 || isNaN(espaciador4))
					{
						alert("Debe Ingresar el numero de orden de hijos nacidos vivos");
						$("#madrenombre2").focus();
					}
					else
					{
						if($("#fechan").val()=="")
						{
							alert("Debe Ingresar su fecha de nacimiento");
							$("#fechan").focus();
						}
						else
						{
							var precadena1, precadena2, precadena3, precadena4, precadena5, precadena6, precadena7, precadena8, precadena9 ="";
							if(espaciador1 == "")
							{
								precadena1 = espaciador2;
								precadena1 = precadena1.toUpperCase();
								precadena1 = precadena1[0]+precadena1[1];
								precadena2 = "0";
							}
							else
							{
								if (espaciador2 == "")
								{
									precadena1 = espaciador1;
									precadena1 = precadena1.toUpperCase();
									precadena1 = precadena1[0]+precadena1[1];
									precadena2 = "0";
								}
								else
								{
									precadena1 = espaciador1;
									precadena1 = precadena1.toUpperCase();
									precadena1 = precadena1[0]+precadena1[1];
									precadena2 = espaciador2;
									precadena2 = precadena2.toUpperCase();
									precadena2 = precadena2[0];
								}
							}
							if(espaciador3 == "")
							{
								precadena3 = espaciador4;
								precadena3 = precadena3.toUpperCase();
								precadena3 = precadena3[0]+precadena3[1];
								precadena4 = "0";
							}
							else
							{
								if (espaciador4 == "")
								{
									precadena3 = espaciador3;
									precadena3 = precadena3.toUpperCase();
									precadena3 = precadena3[0]+precadena3[1];
									precadena4 = "0";
								}
								else
								{
									precadena3 = espaciador3;
									precadena3 = precadena3.toUpperCase();
									precadena3 = precadena3[0]+precadena3[1];
									precadena4 = espaciador4;
									precadena4 = precadena4.toUpperCase();
									precadena4 = precadena4[0];
								}
							}
							precadena5 = $("#lsprovincias").val();
							var precadenafecha = $("#fechan").val();
							precadena6 = precadenafecha[0]+precadenafecha[1]+precadenafecha[2]+precadenafecha[3];
							precadena7 = precadenafecha[5]+precadenafecha[6];
							precadena8 = precadenafecha[8]+precadenafecha[9];
							precadena9 = precadenafecha[2];
							return (precadena3 + precadena4 + precadena1 + precadena2 + precadena5 + precadena6 + precadena7 + precadena8+precadena9+"");
						}
					}
				}
			}
		}
	}
}

$("#btn-generar").click(function(event){
	event.preventDefault();	
	if (generarHcumsp()==0)
	{
		$("#txt-cedula").focus();
	}
	else
	{
		$("#hcus").val(generarHcumsp());
		verificaExistencia();
	}
});

$("#btn-guardar").click(function(event){
	event.preventDefault();
	var r= confirm("Esta seguro de guardar el registro actual?");
	if(r==true)
	{
		if (prepararEnvio()==0)
		{
			//$("#txt-cedula").focus();
		}
		else
		{
			$.ajax({
		        url: "assets/includes/guardarAdmision.php",
		        type: 'POST',
		        async: false,
		        data: prepararEnvio(),
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
	$.ajax({
        url: "assets/includes/guardarAdmisionTarjetero.php",
        type: 'POST',
        async: false,
        data: prepararEnvio(),
        dataType: "json",
        success: function (respuesta)
        {
        	if(respuesta.codigo == 1)
          	{
            	$("#admision").hide();
            	$("#admision-guardada").fadeIn();
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

$("#btn-generar001").click(function(event){
	event.preventDefault();
	alert("Funcion no disponible por el momento.")
	/*$("#admision").fadeIn();
	$("#admision-guardada").hide();
	if(window.XMLHttpRequest)
	{
		xmlhttp = new XMLHttpRequest();
	}
	else
	{
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}
	xmlhttp.open("POST","assets/includes/001.php",true);
	xmlhttp.send();
	xmlhttp.onreadystatechange = function()
	{
		if(xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			$("#admision").html(xmlhttp.responseText);
		}
	}*/
	/*if (generarHcumsp()==0)
	{
		$("#txt-cedula").focus();
	}
	else
	{
		$("#hcus").val(generarHcumsp());
		verificaExistencia();
	}*/
});

$("#fechan").keypress(function(e){
	if(e.which == 13)
	{
		$("#edad-actual").val(calculadoraEdadJs($("#fechan").val()));
		if($("#edad-actual").val()>150)
		{
			alert("Error en la fecha de nacimiento");
			$(".frm-ced-repre").hide();
			$("#fechan").focus();
		}
		else
		{
			if($("#edad-actual").val()<5)
			{
				$(".frm-ced-repre").fadeIn();
				$("#n-representante").focus();
			}
			else
			{
				$(".frm-ced-repre").hide();
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
		$(".frm-ced-repre").hide();
	}
	else
	{
		if($("#edad-actual").val()<5)
		{
			$(".frm-ced-repre").fadeIn();
			$(".frm-ced-repre").attr('alt','on');
		}
		else
		{
			$(".frm-ced-repre").hide();
			$(".frm-ced-repre").attr('alt','off');
		}	
	}
});

function calculadoraEdadJs(fecha_nacimiento)
{
		fecha_hoy = "";
		fecha_hoy = $("#fecha-dia").html();
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

$("#cd-representante").keypress(function(e){
	if(e.which == 13)
	{
		validaCedula("#cd-representante");
		return false;
	}
});