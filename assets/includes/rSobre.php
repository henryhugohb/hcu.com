<!DOCTYPE html>
<html>
	<head>
		<script src="assets/js/jquery-1.11.2.min.js"></script>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
		<style>
			section
			{
				background-color: #dadada;
				font-family: arial;
			}
			#t-resultado
			{
				background-color: white;
				text-align: center;
			}
			.t-header
			{
				background-color: #045FB4;
				color: white;	
			}
			.btn-atender-s:hover
			{
				font-weight: bold;
				cursor: pointer;
			}
		</style>
	</head>
	<body>
		<section>
		<?php
			include("conexion.php");
			$conexion = conectar_bd();
			$consulta = "SELECT * FROM tb_sobreagenda WHERE sob_estado_s='P' "
						."AND sob_profesional = '".$_GET['sob_profesional']
						."' AND sob_fecha = '".$_GET['sob_fecha']."'";
			$resultado = mysql_query($consulta,$conexion);
			if($resultado)
			{
				if(mysql_num_rows($resultado)!=0)
				{
					echo '<table id="t-resultado" border="1">';
					echo '<tr>';
					echo '<td class="t-header">Hora</td>';
					echo '<td class="t-header">Datos</td>';
					echo '<td class="t-header">Opciones</td>';
					echo '</tr>';
					while($row = mysql_fetch_assoc($resultado))
					{
						echo "<tr class='linea-reg'>";
						echo "<td>".$row['sob_hora']."</td>";
						echo "<td>".$row['sob_datos']."</td>";
						echo "<td>";
						echo '<span class="btn-atender-s" alt="'.$row['sob_codigo'].'">';
						echo 'Aceptar';
						echo '<span/>';
						echo "</td>";
						echo "</tr>";
					}
					echo '</table>';
				}
			}
			mysql_close($conexion);
		?>	
		</section>
		<script>
			$(".btn-atender-s").click(function(){
				$("#quitar-s").attr('alt',$(this).attr('alt'));
				$("#quitar-s").attr('value',"Quitar registro "+$(this).attr('alt')+"?");
				$("#quitar-s").fadeIn();
				$("#quitar-s").focus();
				//atenderSobreagenda();
			});
			/*$(document).ready(function(){
				$("#quitar-s").hide();
			});
			$(".a-editar").click(function(){
				$("#a-atender").val('Atender');
				$("#cita").html($(this).html());
				$("#cita").attr('alt',$(this).attr('alt'));
				$(".n-cita").fadeOut();
				$(".n-cita").fadeIn();
				$(".c-d-paciente").hide();
				$("#a-agendar").focus();
				//$("#hora-seleccionada").va();
				/*var r= confirm("Esta seguro de modificar el registro actual?");
				if(r==true)
				{
					alert($(this).attr('value'));
				}
			});
			$("#s-sobreagendar").click(function(){
				$(".sobreagendar").fadeIn();
				$("#s-datos").val("");
				$("#s-datos").focus();
			});
			$("#s-datos").keypress(function(e){
				if(e.which == 13)
				{
					if($("#s-datos").val().trim()!="")
					{
						$("#s-enviar").click();
					}
					else
					{
						alert("Ingrese los datos del paciente a sobreagendar");
						$("#s-datos").focus();
					}			
					return false;
				}
			});
			$("#s-enviar").click(function(){
				if($("#s-datos").val().trim()!="")
				{
					var parametros = {
						sob_profesional: $("#a-profesional").val(),
						sob_datos: ($("#s-datos").val()).toUpperCase(),
						tipo_trans: "solicitar-sobreagenda"
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
					        	$(".sobreagendar").hide();
					        	$("#mensaje-s").fadeIn();
					        	$("#m-sobreagenda").html(respuesta.mensaje);
					        	$("#m-sobreagenda").fadeOut(10000);
					        	//buscarAgenda();
					      	}
					      	else
					      	{
					      		$(".sobreagendar").hide();
					        	$("#mensaje-s").fadeIn();
					      		$("#m-sobreagenda").html(respuesta.mensaje);
					      		$("#m-sobreagenda").fadeOut(10000);
					      		//$("#nArchivo").focus();
					      	}
					    }, 
					    error: function (error) {
					      console.log("ERROR: " + error);
					    }
					});
				}
				else
				{
					alert("Ingrese los datos del paciente a sobreagendar");
					$("#s-datos").focus();
				}
			});*/
		</script>
	</body>
</html>