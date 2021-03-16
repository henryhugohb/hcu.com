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
			<H1>Reporte Total de Grupo Etareo (Solo Primeras Consultas)</H1>
			<div id="busqueda" name="busqueda">
				<form action="" method="POST">
					<table>
						<tr>
							<td>
							<label>Mes:</label>
							<select id="mes" name="mes">
								<?php
									$consulta = "SELECT * FROM tb_matriz_grupo_etareo WHERE mge_estado = 'A' ORDER BY mge_mes_reg";
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
									}
								?>
							</select>
							</td>
							<td>
								<input type="button" id="enviarBusqueda" name ="enviarBusqueda" value="Buscar" />
							</td>
						</tr>
					</table>
				</form>
			</div>
			<div id="resultado-busqueda" name="resultado-busqueda"></div>
		</div>
		<script src="assets/js/script-grupo-etareoTotal.js"></script>
	</body>
</html>