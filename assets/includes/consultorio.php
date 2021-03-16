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
			<H1>Administracion de Consultorios</H1>
			<div id="busqueda" name="busqueda">
				<form action="assets/includes/buscaPaciente.php" method="POST">
					<table>
						<tr>
							<td id="a-codigo" alt="cod"></td>
						</tr>
						<tr>
							<td>
								<label>Descripcion:</label>
							</td>
							<td>
								<input type="text" id="l-descripcion" name ="l-descripcion"/>
							</td>
						</tr>
						<tr>
							<td>
								<label>Observacion:</label>
							</td>
							<td>
								<input type="text" id="l-observacion" name ="l-observacion" size="50" />
							</td>
						</tr>
						<tr>
							<td>
								<input type="button" id="a-generar" name ="a-generar" value="Guardar"/>
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
					$consulta = "SELECT * FROM tb_locacion WHERE loc_estado ='A' ORDER BY loc_descripcion";
					mysql_query("SET NAMES 'utf8'");
					$resultado = mysql_query($consulta,$conexion);
				?>
				<table id="t-resultado" border="1">
					<tr>
						<td class="t-header">Codigo</td>
						<td class="t-header">Descripcion</td>
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
									echo '<span class="a-editar" alt="'.$row['loc_codigo'].'">';
									echo $row['loc_codigo'];
									echo '</span>';
								?>
							</td>
							<td><?php echo $row['loc_descripcion'];?></td>
							<td><?php echo $row['loc_observacion'];?></td>
						</tr>
						<?php
						$bdr=$bdr+1;
					}
					if($bdr==0)
					{
					  ?><tr><td colspan="3"><?php echo "No existen datos que mostrar.";?></td></tr><?php
					}
				}
				mysql_close($conexion);
				?>
				</table>
			</div>
		</div>
		<script src="assets/js/script-consultorio.js"></script>
	</body>
</html>
