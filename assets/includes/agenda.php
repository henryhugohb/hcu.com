<!DOCTYPE html>
<?php
	include("conexion.php");
	$conexion = conectar_bd();
	$conexion2 = conectar_bd();
?>
<html>
	<head>
		<script src="assets/js/jquery-1.11.2.min.js"></script>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="assets/css/estilo1.css">
		<style type="text/css">
			#contenedor-busqueda
			{
				background-color: #dadada;
				padding-left: 5%;
				padding-top: 2%;
				padding-bottom: 2%;
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
		<div id="contenedor-busqueda">
			<H1>Administracion de Agendas</H1>
			<div id="busqueda" name="busqueda">
				<form action="assets/includes/buscaPaciente.php" method="POST">
					<table>
						<tr>
							<td class="items"><label id="lhcu" name="lhcu">Fecha:</label></td>
							<td><input type="date" id="a-fecha" name="a-fecha" /></td>
							<td id="a-codigo" alt="cod"></td>
						</tr>
						<tr>
							<td class="items"><label id="locacion" name="locacion">Locacion:</label></td>
							<td>
								<?php
									$consulta = "SELECT * FROM tb_locacion WHERE loc_estado = 'A' order by loc_descripcion";
									$resultado = mysql_query($consulta,$conexion);
									echo '<select id="a-locacion" name="a-locacion">';
									if ($resultado)
									{
										$bdr=0;
										//echo "<option value='*'>Todas</option>";
										while ($row = mysql_fetch_assoc($resultado)) 
										{
											
											echo "<option value=".$row['loc_codigo'].">".$row['loc_descripcion']."</option>";
											$bdr=$bdr+1;
										}
									}
									//mysql_close($conexion);
									echo "</select>"
								?>
							</td>
						</tr>
						<tr>
							<td class="items"><label id="profesional" name="profesional">Profesional:</label></td>
							<td>
								<?php
									$consulta = "SELECT * FROM tb_profesional WHERE pro_estado = 'A' ORDER BY pro_apellidos";
									$resultado = mysql_query($consulta,$conexion);
									echo '<select id="a-profesional" name="a-profesional">';
									if ($resultado)
									{
										$bdr=0;
										//echo "<option value='*'>Todos</option>";
										while ($row = mysql_fetch_assoc($resultado)) 
										{
											
											echo "<option value=".$row['pro_cedula'].">".$row['pro_apellidos']." ".$row['pro_nombres']."</option>";
											$arrayProfesional = array($row['pro_cedula'] => $row['pro_apellidos']." ".$row['pro_nombres']);
											$bdr=$bdr+1;
										}
									}
									//mysql_close($conexion);
									echo "</select>"
								?>
							</td>
						</tr>
						<tr>
							<td class="items"><label id="cupos" name="cupos">Hora Inicio:</label></td>
							<td>
								<input type="time" id="a-h-inicio" name ="a-h-inicio"/>
							</td>
						</tr>
						<tr>
							<td>
								<label id="cupos" name="cupos">Hora Fin:</label>
							</td>
							<td>
								<input type="time" id="a-h-fin" name ="a-h-fin"/>
							</td>
						</tr>
						<tr>
							<td>
								<input type="button" id="a-generar" name ="a-generar" value="Generar"/>
							</td>
							<td>
								<input type="button" id="a-cancelar" name ="a-cancelar" value="Cancelar"/>
								<input type="button" id="a-eliminar" name ="a-eliminar" value="Eliminar"/>
							</td>
						</tr>
					</table>
				</form>
			</div>
			<div id="r-agendas" name="r-agendas">
				<?php
					$consulta = "SELECT * FROM tb_agenda WHERE age_estado ='A' ORDER BY age_fecha DESC";
					$resultado = mysql_query($consulta,$conexion);
				?>
				<table id="t-resultado" border="1">
					<tr>
						<td class="t-header">Editar</td>
						<td class="t-header">Fecha</td>
						<td class="t-header">Locacion</td>
						<td class="t-header">Profesional</td>
						<td class="t-header">Hora Inicio</td>
						<td class="t-header">Hora Fin</td>
					</tr>
				<?php
				if ($resultado)
				{
					$bdr=0;
					$fecha_cita="";
					while ($row = mysql_fetch_assoc($resultado)) 
					{
						if($fecha_cita!="" && $row['age_fecha']!=$fecha_cita)
						{
							echo '<tr><td colspan="6"><hr></td></tr>';
						}
						if(($bdr%2)==0)
						{
							echo "<tr>"; 
						}
						else
						{
							echo "<tr bgcolor='#b2d9ff'>";
						}
						?>
						<td>
							<?php
								echo '<input type="button" class="a-editar" value="';
								echo $row['age_codigo'];
								echo '" alt="'.$row['age_codigo'].'"/>';
							?>
						</td>
						<td><?php $fecha_cita=$row['age_fecha']; echo $row['age_fecha'];?></td>
						<td>
						<?php
							$consulta2 = "SELECT * FROM tb_locacion WHERE loc_codigo = ".$row['age_locacion']."";
							$resultado2 = mysql_query($consulta2,$conexion2);
							$row2 = mysql_fetch_assoc($resultado2);
							echo $row2['loc_descripcion'];
						?>
						</td>
						<td>
						<?php
							$consulta2 = "SELECT * FROM tb_profesional WHERE pro_cedula = ".$row['age_profesional']."";
							$resultado2 = mysql_query($consulta2,$conexion2);
							$row2 = mysql_fetch_assoc($resultado2);
							echo $row2['pro_apellidos']." ".$row2['pro_nombres'];
						?>
						</td>
						<td><?php echo $row['age_hora_inicio'];?></td>
						<td><?php echo $row['age_hora_fin'];?></td>
					</tr>
						<?php
						$bdr=$bdr+1;
					}
					if($bdr==0)
					{
					  ?><tr><td colspan="5"><?php echo "No existen datos que mostrar.";?></td></tr><?php
					}
				}
				mysql_close($conexion);
				?>
				</table>
			</div>
		</div>
		<script src="assets/js/script-agenda.js"></script>
	</body>
</html>
