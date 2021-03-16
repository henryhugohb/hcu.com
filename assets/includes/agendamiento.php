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
			<H1>Reporte Agendamiento</H1>
			<div id="busqueda" name="busqueda">
				<form action="assets/includes/buscaPaciente.php" method="POST">
					<table>
						<tr>
							<td class="items"><label id="lhcu" name="lhcu">Año:</label></td>
							<td>
								<select id="anio-reporte" name="anio-reporte" >
									<?php
										$consulta = "SELECT * FROM tb_agenda WHERE age_estado = 'A' ORDER BY age_fecha ASC";
										$resultado = mysql_query($consulta,$conexion);
										if ($resultado)
										{
											$bdr=0;
											$anio="";
											$anio_actual="";
											while ($row = mysql_fetch_assoc($resultado)) 
											{
												$anio_corriente = $row['age_fecha'];
												$longitud2 = strlen($anio_corriente);
												$anio = "".$anio_corriente[0].$anio_corriente[1].$anio_corriente[2].$anio_corriente[3]."";
												if($anio_actual!=$anio)
												{
													echo "<option value=".$anio.">".$anio."</option>";
													$bdr=$bdr+1;
													$anio_actual=$anio;
												}
											}
											if($bdr==0)
											{
												echo "<option value='*'>No existen registros</option>";
											}
										}
									?>
								</select>
							</td>
							<td id="a-codigo" alt="cod"></td>
						</tr>
						<tr>
							<td class="items"><label id="lhcu" name="lhcu">Mes:</label></td>
							<td>
								<select id="mes-reporte" name="mes-reporte" >
									<?php
										$consulta = "SELECT * FROM tb_agenda WHERE age_estado = 'A' ORDER BY age_fecha ASC";
										$resultado = mysql_query($consulta,$conexion);
										if ($resultado)
										{
											$bdr=0;
											$mes="";
											$mes_actual="";
											while ($row = mysql_fetch_assoc($resultado)) 
											{
												$mes_corriente = $row['age_fecha'];
												$longitud = strlen($mes_corriente);
												$mes = "".$mes_corriente[5].$mes_corriente[6]."";
												if($mes_actual!=$mes)
												{
													echo "<option value=".$mes.">".$mes."</option>";
													$bdr=$bdr+1;
													$mes_actual=$mes;
												}
											}
											if($bdr==0)
											{
												echo "<option value='*'>No existen registros</option>";
											}
										}
									?>
								</select>
							</td>
							<td id="a-codigo" alt="cod"></td>
						</tr>
						<tr>
							<td class="items"><label id="locacion" name="locacion">Especialidad:</label></td>
							<td>
								<select id="especialidad-reporte" name="especialidad-reporte">
									<option value='*'>Todas</option>
									<option value="1,9">Medicina General</option>
									<option value="4,11">Obstetricia</option>
									<option value="2,10">Odontologia</option>
								</select>
							</td>
						</tr>
						<tr>
							<td class="items"><label id="profesional" name="profesional">Tipo:</label></td>
							<td>
								<select id="tipo-reporte" name="tipo-reporte">
									<option value='A'>Atendidos</option>
									<!--<option value='*'>Agendados</option><option value='A'>Atendidos</option>-->
								</select>
							</td>
						</tr>
						<tr>
							<td>
								<input type="button" id="a-generar" name ="a-generar" value="Generar Reporte"/>
							</td>
						</tr>
					</table>
				</form>
			</div>
			<div id="r-agendas" name="r-agendas">
			</div>
		</div>
		<script src="assets/js/script-agendamiento.js"></script>
	</body>
</html>