<!DOCTYPE html>
<html>
	<head>
		<script src="assets/js/jquery-1.11.2.min.js"></script>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
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
			.ver-contra:hover
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
				$conexion2 = conectar_bd();
				$conexion3 = conectar_bd();
				$consulta = "SELECT * FROM tb_matriz_referencia WHERE ref_estado='A' AND ref_cedula_paciente='".$_GET['paciente'] ."' ORDER BY ref_fecha DESC;	";
				mysql_query("SET NAMES utf8");
				$resultado = mysql_query($consulta,$conexion);
			?>
			<br />
			<spam><b>REFERENCIAS</b></spam>
			<table id="t-resultado" border="1">
				<tr>
					<th class="t-header">Fecha</th>
					<th class="t-header">Medico que refiere</th>
					<th class="t-header">Diagnostico</th>
					<th class="t-header">Unidad a la que se refiere</th>
					<th class="t-header">Tipo de Servicio</th>
					<th class="t-header">Especialidad</th>
					<th class="t-header">Fecha y hora de la cita</th>
					<th class="t-header">Medico al que se refiere</th>
					<th class="t-header">Estado</th>
				</tr>
			<?php
			if ($resultado)
			{
				$bdr=0;
				while ($row = mysql_fetch_assoc($resultado)) 
				{
					if(($bdr%2)==0)
					{
						echo "<tr>"; 
					}
					else
					{
						echo "<tr bgcolor='#b2d9ff'>";
					}
					?>
						<td><?php echo $row['ref_fecha'];?></td>
						<?php 
							$consulta2 = "SELECT * FROM tb_profesional WHERE pro_cedula='".$row['ref_cedula_profesional'] ."' AND pro_estado!='E'";
							$resultado2 = mysql_query($consulta2,$conexion2);
							$row2 = mysql_fetch_array($resultado2);
						?>
						<td><?php echo strtoupper($row2['pro_apellidos'])." ".strtoupper($row2['pro_nombres']);?></td>
						<td><?php echo $row['ref_cie10']." - ".$row['ref_diagnostico'];?></td>
						<?php 
							$consulta2 = "SELECT * FROM tb_nivel WHERE niv_codigo='".$row['ref_unidad_referida'] ."' AND niv_estado='A'";
							$resultado2 = mysql_query($consulta2,$conexion2);
							$row2 = mysql_fetch_array($resultado2);
						?>
						<td><?php echo strtoupper($row2['niv_nombre']);?></td>
						<td>
							<?php 
								if($row['ref_tipo_servicio']=="CE")
								{
									echo "CONSULTA EXTERNA";
								}
								else
								{
									echo "EMERGENCIA";
								}
							?>
						</td>
						<?php 
							$consulta2 = "SELECT * FROM tb_sub_especialidad WHERE sub_codigo='".$row['ref_especialidad_referida'] ."' AND sub_estado='A'";
							mysql_query("SET NAMES utf8");
							$resultado2 = mysql_query($consulta2,$conexion2);
							$row2 = mysql_fetch_array($resultado2);
						?>
						<td><?php echo strtoupper($row2['sub_descripcion']);?></td>
						<?php 
							if($row['ref_fecha_cita']==NULL)
							{
								echo "<td class='inserta-cita' style='color:red;'>";
								echo dias_transcurridos($row['ref_fecha'],date("Y-m-d"));
								echo " DIAS EN ESPERA";
								echo "</td>";
							}
							else
							{
								echo "<td class='inserta-cita' style='color:green;'>";
								echo $row['ref_fecha_cita']." ".$row['ref_hora_cita'];
								echo "</td>";
							}
							if($row['ref_especialista_nombre']==NULL)
							{
								echo "<td class='inserta-cita' style='color:red;'>";
								echo dias_transcurridos($row['ref_fecha'],date("Y-m-d"));
								echo " DIAS EN ESPERA";
								echo "</td>";
							}
							else
							{
								echo "<td class='inserta-cita' style='color:green;'>";
								echo $row['ref_especialista_nombre'];
								echo "</td>";
							}
							if($row['ref_estado_ref']=="R")
							{
								echo "<td alt='".$row['ref_codigo']."'' style='color:red;'>";
								echo "REFERIDA";
								echo "</td>"; 
							}
							else
							{
								if($row['ref_estado_ref']=="A")
								{
									echo "<td alt='".$row['ref_codigo']."'' style='color:orange;'>";
									echo "ATENDIDA";
									echo "</td>";
								}
								else
								{
									if($row['ref_estado_ref']=="C")
									{
										echo "<td class='ver-contra' alt='".$row['ref_codigo']."'' style='color:green;'>";
										echo "CONTRAREFERIDA";
										echo "</td>";
									}
									else
									{
										if($row['ref_estado_ref']=="N")
										{
											echo "<td style='color:red;'>";
											echo "NO ASISTIO";
											echo "</td>"; 
										}
									}
								}
							}
						?>
					</tr>
					<?php
					$bdr=$bdr+1;
				}
				if($bdr==0)
				{
					?><tr><td colspan="4"><?php echo "No se encontro ninguna coincidencia";?></td></tr><?php
				}
			}
			mysql_close($conexion);
			mysql_close($conexion2);
			mysql_close($conexion3);
			?>
			</table>
		</section>
		<script>
			$(".ver-contra").click(function(){
				var url="assets/archivos/contrareferencias/"+$(this).attr('alt')+".pdf";
				//var url="http://192.168.1.50/hcu.com/assets/archivos/"+$(this).attr('alt')+".pdf";
				//alert($(this).attr('alt'));
				abrirEnPestana(url);
				/*$("#operaciones").fadeIn();
				$("#datos-cita").hide();
				$("#n-referencia").html($(this).attr('alt'));
				$("#paciente").html($(this).html());
				$(".indentificador-referencia").attr('style','background-color:white;');
				$(this).attr('style','background-color:red;');*/
			});

			function abrirEnPestana(url) {
				$("<a>").attr("href", url).attr("target", "_blank")[0].click();
			}
		 
			$(".btn_eliminar").click(function(){
				var r = confirm("Esta seguro de eliminar el paciente?");
				if(r==true)
				{
					var r2 = confirm("Esta operacion es irreversible. Desea continuar?");
					if(r2==true)
					{
						var parametros = {
							cod_admision: $(this).attr("alt")
						};
						$.ajax({
						    url: "assets/includes/eliminaPacienteFisico.php",
						    type: 'POST',
						    async: false,
						    data: parametros,
						    dataType: "json",
						    success: function (respuesta)
						    {
						    	if(respuesta.codigo == 1)
						      	{
						        	alert(respuesta.mensaje);
						        	$("#enviarBusqueda").click();
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
		</script>
	</body>
</html>