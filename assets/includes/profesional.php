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
			.a-editar:hover
			{
				font-weight: bold;
				cursor: pointer;
			}
		</style>
	</head>
	<body>
		<div id="contenedor-busqueda">
			<H1>Administracion de Profesionales</H1>
			<div id="busqueda" name="busqueda">
				<form action="assets/includes/buscaPaciente.php" method="POST">
					<table>
						<tr>
							<td>
								<label>Cedula:</label>
							</td>
							<td>
								<input type="text" id="p-cedula" name ="p-cedula"/>
							</td>
							<td id="a-codigo" alt="cod"></td>
						</tr>
						<tr>
							<td>
								<label>Apellidos:</label>
							</td>
							<td>
								<input type="text" id="p-apellidos" name ="p-apellidos"/>
							</td>
							<td>
								<label>Nombres:</label>
							</td>
							<td>
								<input type="text" id="p-nombres" name ="p-nombres"/>
							</td>
						</tr>
						<tr>
							<td class="items"><label>Fecha de Nacimiento:</label></td>
							<td><input type="date" id="p-fecha" name="p-fecha" /></td>
							<td class="items"><label>Especialidad:</label></td>
							<td>
								<?php
									$consulta = "SELECT * FROM tb_especialidad WHERE esp_estado = 'A' order by esp_descripcion";
									$resultado = mysql_query($consulta,$conexion);
									echo '<select id="p-especialidad" name="p-especialidad">';
									if ($resultado)
									{
										$bdr=0;
										//echo "<option value='*'>Todas</option>";
										while ($row = mysql_fetch_assoc($resultado)) 
										{
											
											echo "<option value=".$row['esp_codigo'].">".$row['esp_descripcion']."</option>";
											$bdr=$bdr+1;
										}
									}
									//mysql_close($conexion);
									echo "</select>"
								?>
							</td>
						</tr>
						<tr>
							<td>
								<label>Pin Code:</label>
							</td>
							<td>
								<input type="text" id="p-pin" name ="p-pin" maxlength="4" />
							</td>
							<td>
								<label>Observacion:</label>
							</td>
							<td>
								<input type="text" id="p-observacion" name ="p-observacion"/>
							</td>
						</tr>
						<tr>
							<td>
								<input type="button" id="a-generar" name ="a-generar" value="Guardar"/>
							</td>
							<td>
								<input type="button" id="a-cancelar" name ="a-cancelar" value="Cancelar"/>
								<input type="button" id="a-inactivar" name ="a-inactivar" value="Inactivar"/>
								<input type="button" id="a-eliminar" name ="a-eliminar" value="Eliminar"/>
							</td>
						</tr>
					</table>
				</form>
			</div>
			<div id="r-agendas" name="r-agendas">
				<?php
					$consulta = "SELECT * FROM tb_profesional WHERE pro_estado !='E' ORDER BY pro_estado, pro_apellidos";
					mysql_query("SET NAMES 'utf8'");
					$resultado = mysql_query($consulta,$conexion);
				?>
				<table id="t-resultado" border="1">
					<tr>
						<td class="t-header">Cedula</td>
						<td class="t-header">Apellidos</td>
						<td class="t-header">Nombres</td>
						<td class="t-header">Fecha de Nacimiento</td>
						<td class="t-header">Especialidad</td>
						<td class="t-header">Estado</td>
						<td class="t-header">Observacion</td>
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
						<td>
							<?php
								echo '<span class="a-editar" alt="'.$row['pro_codigo'].'">';
								echo $row['pro_cedula'];
								echo '</span>';
							?>
						</td>
						<td><?php echo $row['pro_apellidos'];?></td>
						<td><?php echo $row['pro_nombres'];?></td>
						<td><?php echo $row['pro_fecha_nacimiento'];?></td>
						<td>
						<?php
							$consulta2 = "SELECT * FROM tb_especialidad WHERE esp_codigo = ".$row['pro_especialidad']."";
							$resultado2 = mysql_query($consulta2,$conexion2);
							$row2 = mysql_fetch_assoc($resultado2);
							echo $row2['esp_descripcion'];
						?>
						</td>
						<?php
							if($row['pro_estado']=='A')
							{
								echo "<td class='inserta-cita' style='color:green;'>ACTIVA</td>";
							}
							else
							{
								echo "<td class='inserta-cita' style='color:red;'>INACTIVA</td>";
							}
						?>
						<td><?php echo $row['pro_observacion'];?></td>
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
		<script src="assets/js/script-profesional.js"></script>
	</body>
</html>
