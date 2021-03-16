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
			.a-editar:hover
			{
				font-weight: bold;
				cursor: pointer;
			}
		</style>
	</head>
	<body>
		<section>
			<table>
				<tr>
					<td id="ver-atendidas" bgcolor='#9FF781'>Atendidas</td>
					<td id="ver-confirmadas" bgcolor='#F4FA58'>Confirmadas</td>
					<td id="ver-agendadas" bgcolor='#F78181'>No Confirmadas</td>
					<td></td>
					<td><input type="button" id="s-sobreagendar" name ="s-sobreagendar" value="Solicitar paciente adicional" alt=""/></td>
					<td class="sobreagendar">
						<input type="text" id="s-datos" name="s-datos" maxlength="50" size="20" placeholder="Datos de la Cita" />
						<input type="button" id="s-enviar" name ="s-enviar" value="Enviar" alt=""/>
					</td>
					<td class="sobreagendar" id="mensaje-s">
						<label id="m-sobreagenda" name="m-sobreagenda" style="color: #00CC00; font-weight: bold;size:10px;"></label>
					</td>
				</tr>
			</table>
			<table id="t-resultado" border="1">
				<tr>
					<td class="t-header">Hora de Cita</td>
					<td class="t-header">N° Archivo</td>
					<td class="t-header">Nombres</td>
					<td class="t-header">Estado</td>
					<td class="t-header">Confirmada</td>
					<td class="t-header">Atendida</td>
					<td class="t-header">Observacion</td>
				</tr>
				<?php
					include("conexion.php");
					$conexion = conectar_bd();
					$conexion2 = conectar_bd();
					$fecha = $_GET['fecha'];
					$profesional = $_GET['profesional'];
					$consulta = "SELECT * FROM tb_agenda WHERE age_estado = 'A' AND age_fecha = '" . $fecha . "'"
								." AND age_profesional ='".$profesional."' ORDER BY age_hora_inicio";
					$resultado = mysql_query($consulta,$conexion);
					$bdr1=0;
					$bdr2=0;
					$bdr3=0;
					if($resultado)
					{
						if(mysql_num_rows($resultado)!=0)
						{
							
							
							while($agenda = mysql_fetch_assoc($resultado))
							{
								
								$consulta = "SELECT * FROM tb_agendamiento WHERE age_cod_agenda = '".$agenda['age_codigo']."'";
								$resultado2 = mysql_query($consulta,$conexion2);
								if ($resultado2)
								{
									$bdr=0;
									while ($agendamiento = mysql_fetch_assoc($resultado2)) 
									{
										/*if(($bdr%2)==0)
										{
											echo "<tr>"; 
										}
										else
										{
											echo "<tr bgcolor='#b2d9ff'>";
										}*/
										if($agendamiento['age_estado_c']=="A")
										{
											echo "<tr bgcolor='#9FF781'";
											$bdr1=$bdr1+1; 
										}
										else
										{
											if($agendamiento['age_estado_c']=="C")
											{
												echo "<tr bgcolor='#F4FA58'";
												$bdr2=$bdr2+1; 
											}
											else
											{
												if($agendamiento['age_estado_c']=="O")
												{
													echo "<tr bgcolor='#F78181'";
													$bdr3=$bdr3+1; 
												}
												else
												{
													echo "<tr"; 
												}	
											}	
										}
										echo ' class="a-editar" alt="'.$agendamiento['age_codigo'].'">';
										?>
											<td>
												<?php
													echo '<span class="hora-cita">';
													echo $agendamiento['age_hora_cita'];
													echo '<span/>';
												?>
											</td>
											<td><?php echo $agendamiento['age_narchivo'];?></td>
											<td><?php echo $agendamiento['age_nombres'];?></td>
											<td><?php echo $agendamiento['age_estado_c'];?></td>
											<td><?php echo $agendamiento['age_hora_c'];?></td>
											<td><?php echo $agendamiento['age_hora_a'];?></td>
											<td><?php echo $agendamiento['age_observacion'];?></td>
											</tr>
										<?php
										$bdr=$bdr+1;
									}
									if($bdr==0)
									{
									 	?>
									  		<tr>
									  			<td colspan="5">
									  				<?php
									  					echo "No tiene citas asignadas para la agenda seleccionada.";
									  				?>
									  			</td>
									  		</tr>
									  	<?php
									}
								}
								else
								{
									?>
										<tr>
											<td colspan="5">
												<?php
													echo "Problema con el servidor. Reinicie la conexion";
												?>
											</td>
										</tr>
									<?php
								}
							}
						}
						else
						{
							?>
								<tr>
									<td colspan="5">
										<?php
											echo "No existen agendas para la fecha seleccionada.";
										?>
									</td>
								</tr>
							<?php
						}
					}
					else
					{
						?>
							<tr>
								<td colspan="5">
									<?php
										echo "Problema con el servidor. Reinicie la conexion.";
									?>
								</td>
							</tr>
						<?php
					}
					mysql_close($conexion);
					mysql_close($conexion2);
				?>
			</table>
			<?php
				echo "<label id='total-atendidas' style='visibility:hidden'>".$bdr1."<label/>";
				echo "<label id='total-confirmadas' style='visibility:hidden'>".$bdr2."<label/>";
				echo "<label id='total-agendadas' style='visibility:hidden'>".$bdr3."<label/>";
			?>
		</section>
		<script>
			$(document).ready(function(){
				$(".sobreagendar").hide();
				if(parseInt($("#total-atendidas").html())==0)
				{
					$("#ver-atendidas").html("Atendidas");
				}
				else
				{
					$("#ver-atendidas").html("Atendidas("+parseInt($("#total-atendidas").html())+")");
				}

				if(parseInt($("#total-confirmadas").html())=='0')
				{
					$("#ver-confirmadas").html("Confirmadas");
				}
				else
				{
					$("#ver-confirmadas").html("Confirmadas("+parseInt($("#total-confirmadas").html())+")");
				}
				if(parseInt($("#total-agendadas").html())=='0')
				{
					$("#ver-agendadas").html("No Confirmadas");
				}
				else
				{
					$("#ver-agendadas").html("No confirmadas("+parseInt($("#total-agendadas").html())+")");
				}
			});
			$(".a-editar").click(function(){
				$("#a-atender").val('Atender');
				//$("#cita").html($(this).html());
				//$("#cita").html();
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
				}*/
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
			});
		</script>
	</body>
</html>