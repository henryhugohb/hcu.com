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
			table tr td label
			{
				cursor: pointer;
			}
			.items:hover
			{
				color: white;
				background-color: #045FB4;
				text-align: right;
				padding-right: 3px;
				padding-left: 3px;
			}
		</style>
	</head>
	<body>
		<div id="contenedor-busqueda">
			<H1>Reporte Referencia y Contrareferencia</H1>
			<div id="busqueda" name="busqueda">
				<form action="" method="POST">
					<table>
						<tr>
							<td>
								<label>Año:</label>
								<select id="anio-reporte" name="anio-reporte" >
									<?php
										$consulta = "SELECT * FROM tb_matriz_referencia WHERE ref_estado = 'A'"
													." AND ref_cedula_profesional='".$_GET['profesional']."'"
													." ORDER BY ref_fecha ASC";
										$resultado = mysql_query($consulta,$conexion);
										if ($resultado)
										{
											$bdr=0;
											$anio="";
											$anio_actual="";
											while ($row = mysql_fetch_assoc($resultado)) 
											{
												$anio_corriente = $row['ref_fecha'];
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
							<td>
							<label>Mes:</label>
							<?php 
								echo '<select id="mes" name="mes" alt="'.$bdr.'">';
							?>
								<?php
									/*$consulta = "SELECT * FROM tb_matriz_referencia WHERE ref_estado = 'A' and ref_cedula_profesional='".$_GET['profesional']."' ORDER BY ref_fecha DESC";
									$resultado = mysql_query($consulta,$conexion);
									if($resultado)
									{
										$bdr=0;
										$mes_usado=0;
										while ($row = mysql_fetch_assoc($resultado)) 
										{
											
											if($row['mge_mes_reg']!=$mes_usado)
											{
												echo "<option value='".$row['mge_mes_reg']."'>".$row['mge_mes_reg']."</option>";
												$bdr=$bdr+1;
											}
											$mes_usado = $row['mge_mes_reg'];
										}
										if($bdr==0)
										{
											echo "<option value='*'>No tienes registros aun</option>";
										}
									}*/
								?>
							</select>
							</td>
							<td>
								<input type="button" id="enviarBusqueda" name ="enviarBusqueda" value="Buscar" />
							</td>
							<?php
								echo '<td id="profesional" name="profesional" alt="'.$_GET['profesional'].'" style="visibility: hidden">';
								echo $_GET['profesional']; 
							?>
							</td>
						</tr>
					</table>
				</form>
				<div id="operaciones">
					<div id="n-registro" name="n-registro" style="display:none;"></div>
					<!--input type="button" id="editar-ref" name ="editar-ref" value="Editar" /-->
					<input type="button" id="eliminar-ref" name ="eliminar-ref" value="Eliminar" style="background-color: red;"/>
				</div>
			</div>
			<div id="resultado-busqueda" name="resultado-busqueda"></div>
		</div>
		<script src="assets/js/script-matrizReferencia.js"></script>
	</body>
</html>