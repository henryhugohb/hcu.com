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
			<H1>Ingresar al Sistema</H1>
			<div id="busqueda" name="busqueda">
				<form>
					<table>
						<tr>
							<td>
								<label>Cedula del Profesional:</label>
							</td>
							<td>
								<input type="text" id="p-cedula" name ="p-cedula"/>
							</td>
						</tr>
						<tr>
							<td>
								<label>Pin Code:</label>
							</td>
							<td>
								<input type="password" id="p-pin" name ="p-pin" maxlength="4" />
							</td>
						</tr>
						<tr>
							<td>
								<input type="button" id="a-generar" name ="a-generar" value="Iniciar Sesion"/>
								<label id="espere" style="font-weight: bold">Validando...</label>
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
				<!--
					<?php
						$consulta = "SELECT * FROM tb_profesional WHERE pro_estado ='A' ORDER BY pro_apellidos";
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
							<td class="t-header">Pin Code</td>
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
							<td><?php echo "****";//echo $row['pro_pin'];?></td>
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
				-->
			</div>
		</div>
		<script src="assets/js/script-login.js"></script>
	</body>
</html>
