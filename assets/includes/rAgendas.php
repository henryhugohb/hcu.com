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

			<table id="t-resultado" border="1">
				<tr>
					<td class="t-header">Agendar</td>
					<td class="t-header">Hora</td>
					<td class="t-header">N° Archivo</td>
					<td class="t-header">Nombres</td>
					<td class="t-header">Estado</td>
					<td class="t-header">Hora Conf.</td>
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
				if($resultado)
				{
					while($agenda = mysql_fetch_assoc($resultado))
					{
						if($agenda['age_locacion']>0)
						{
							echo "<label id='locacion' name='locacion' style='color: #00CC00; font-weight: bold'>CONSULTORIO ".$agenda['age_locacion']."</label>";
						}
						$consulta = "SELECT * FROM tb_agendamiento WHERE age_cod_agenda = '".$agenda['age_codigo']."'";
						//mysql_query("SET NAMES 'utf8'");
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
											echo "<tr bgcolor='#F78181'>"; 
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
										echo '<input type="button" class="a-editar" value="';
										echo $agendamiento['age_codigo'];
										echo '" alt="'.$agendamiento['age_codigo'].'"/>';
									?>
								</td>
								<td><?php echo $agendamiento['age_hora_cita'];?></td>
								<td><?php echo $agendamiento['age_narchivo'];?></td>
								<td><?php echo $agendamiento['age_nombres'];?></td>
								<td><?php echo $agendamiento['age_estado_c'];?></td>
								<td><?php echo $agendamiento['age_hora_c'];?></td>
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
					}
				}
				else
				{
					?><tr><td colspan="5"><?php echo "Problema con el servidor. Reinicie la conexion.";?></td></tr><?php
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