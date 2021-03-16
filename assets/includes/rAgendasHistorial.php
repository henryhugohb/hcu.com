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
		</style>
	</head>
	<body>
		<section>
			<spam><b>CONSULTAS</b></spam>
			<table id="t-resultado" border="1">
				<tr>
					<td class="t-header">Fecha_Cita</td>
					<td class="t-header">Hora</td>
					<td class="t-header">Medico Tratante</td>
					<td class="t-header">Estado</td>
					<td class="t-header">Observacion</td>
				</tr>
				<?php
				include("conexion.php");
				$conexion = conectar_bd();
				$conexion2 = conectar_bd();
				$narchivo = $_GET['narchivo'];
				$profesional = $_GET['profesional'];
				$consulta = "SELECT * FROM tb_agendamiento WHERE age_narchivo = '".$narchivo."' ORDER BY age_codigo DESC, age_hora_cita DESC" ;
				//mysql_query("SET NAMES 'utf8'");
				$resultado2 = mysql_query($consulta,$conexion2);
				if ($resultado2)
				{
					$bdr=0;
					while ($agendamiento = mysql_fetch_assoc($resultado2)) 
					{
						$consulta = "SELECT * FROM tb_agenda WHERE age_estado = 'A' AND age_codigo = '" . $agendamiento['age_cod_agenda'] . "'";
						$resultado = mysql_query($consulta,$conexion);
						if($resultado)
						{
							$agenda = mysql_fetch_array($resultado);
							$fecha_cita = $agenda['age_fecha'];
							$medico_tratante = $agenda['age_profesional'];
						}
						if($agendamiento['age_estado_c']=="A")
						{
							echo "<tr bgcolor='#9FF781'>"; 
						}
						else
						{
							if($agendamiento['age_estado_c']=="C")
							{
								echo "<tr bgcolor='#F4FA58'>"; 
							}
							else
							{
								if($agendamiento['age_estado_c']=="O")
								{
									//echo "<tr bgcolor='#F78181'>";
									if($fecha_cita<date("Y-m-d"))
									{
										echo "<tr bgcolor='#F78181'>";
									}
									else
									{
										if($fecha_cita==date("Y-m-d"))
										{
											if($agendamiento['age_hora_cita']<date("H:i:s"))
											{
												echo "<tr bgcolor='#F78181'>";
											}
											else
											{
												echo "<tr bgcolor='#F4FA58'>";
											}
										}
										else
										{
											echo "<tr bgcolor='#F4FA58'>";
										}
									} 
								}
								else
								{
									echo "<tr>"; 
								}	
							}	
						}
						?>
						<td>
							<?php
								/**ESTE GRUPO**/
								echo $fecha_cita;
							?>
						</td>
						<td>
							<?php
								
								$hora_corta =  $agendamiento['age_hora_cita'];
								$longitud2 = strlen($hora_corta);
								echo "".$hora_corta[0].$hora_corta[1].$hora_corta[2].$hora_corta[3].$hora_corta[4]."";
							?>
						</td>
						<td>
							<?php
								$consulta = "SELECT * FROM tb_profesional WHERE pro_estado != 'E' AND pro_cedula = '" . $medico_tratante . "'";
								$resultado = mysql_query($consulta,$conexion);
								if($resultado)
								{
									$tb_profesional = mysql_fetch_array($resultado);
									echo $tb_profesional['pro_apellidos']." ".$tb_profesional['pro_nombres'];
								}
							?>
						</td>
						<td>
							<?php
								if($agendamiento['age_estado_c']=="A")
								{
									echo "Efectiva"; 
								}
								else
								{
									if($agendamiento['age_estado_c']=="C")
									{
										echo "No finalizada"; 
									}
									else
									{
										if($agendamiento['age_estado_c']=="O")
										{
											if($fecha_cita<date("Y-m-d"))
											{
												echo "Incumplida";
											}
											else
											{
												if($fecha_cita==date("Y-m-d"))
												{
													if($agendamiento['age_hora_cita']<date("H:i:s"))
													{
														echo "Incumplida";
													}
													else
													{
														echo "Pendiente";
													}
												}
												else
												{
													echo "Pendiente";
												}	
											}
										}
									}	
								}
							?>
						</td>
						<td><?php echo $agendamiento['age_observacion'];?></td>
					</tr>
						<?php
						$bdr=$bdr+1;
					}
					if($bdr==0)
					{
					  ?><tr><td colspan="5"><?php echo "No existen datos que mostrar.";?></td></tr><?php
					}
				}
				else
				{
					?><tr><td colspan="5"><?php echo "Problema con el servidor. Reinicie la conexion";?></td></tr><?php
				}
				mysql_close($conexion);
				mysql_close($conexion2);?>
			</table>
		</section>
		<script>
			$(".a-editar").click(function(){
				$("#a-agendar").val('Mostrar');
				$("#cita").html($(this).attr('value'));
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
		</script>
	</body>
</html>