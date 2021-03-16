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
			.btn_eliminar:hover
			{
				font-weight: bold;
				cursor: pointer;
			}
		</style>
	</head>
	<body>
		<div>
			<?php
				$consulta = "SELECT * FROM tb_admision WHERE adm_estado='A' AND adm_hcu!='0' AND adm_fecha_nacimiento!='0000-00-00'";
				$resultado = mysql_query($consulta,$conexion);
				if($resultado)
				{
					$i=0;
					while($row=mysql_fetch_assoc($resultado))
					{
						$longitud = strlen($row['adm_hcu']);
						if($longitud==10)
						{
							if(validaCedulaPhp($row['adm_hcu']))
							{
								if((calculadorEdad($row['adm_fecha_nacimiento'])>=5)&&(calculadorEdad($row['adm_fecha_nacimiento'])<=100))
								{
									if(str_word_count($row['adm_apellido'],0)<=2)
									{
										if(str_word_count($row['adm_nombre'],0)<=2)
										{
											
										}
									}
								}
							}
						}
					}
					echo "".$i."";
				}
				else
				{
					echo "<strong>Error: conection</strong>";
				}
			?>
		</div>
		<div id="contenedor-busqueda">
			<H1>Datos Tarjetero Indice</H1>
			<div>
				<table  id="t-resultado" border="1">
					<tr>
						<th class="t-header">
							<label>Total Admision</label>
						</td>
						<th class="t-header">
							<label>Total Activas</label>
						</td>
						<th class="t-header">
							<label>Total Tarjerero</label>
						</td>
						<th class="t-header">
							<label>Avance</label>
						</td>
						<th class="t-header">
							<label>Con Cedula Valida</label>
						</td>
						<th class="t-header">
							<label>Validos mayores de 5 años</label>
						</td>
						<th class="t-header">
							<label>con menos de 2 apellidos</label>
						</td>
						<th class="t-header">
							<label>con menos de 2 nombres</label>
						</td>
					</tr>
					<tr>
						<td>
							<?php
								$consulta = "SELECT * FROM tb_admision ";
								$resultado = mysql_query($consulta,$conexion);
								if($resultado)
								{
									echo mysql_num_rows($resultado);
								}
								else
								{
									echo "<strong>Error: conection</strong>";
								}
							?>
						</td>
						<td>
							<?php
								$consulta = "SELECT * FROM tb_admision WHERE adm_estado='A'";
								$resultado = mysql_query($consulta,$conexion);
								if($resultado)
								{
									$total_activas = mysql_num_rows($resultado);
									echo mysql_num_rows($resultado);
								}
								else
								{
									echo "<strong>Error: conection</strong>";
								}
							?>
						</td>
						<td>
							<?php
								$servidor_bd2 = "localhost";
								$usuario_bd2 = "root";
								$contrasenha_bd2 = "";
								$BD2 = "tarjetero_db";

								$conexion_bd2 = @mysql_connect($servidor_bd2,$usuario_bd2,$contrasenha_bd2);

								if(!$conexion_bd2)
								{
									die('<strong>No Pudo conectarse: </strong>'.mysql_error());
								}
								mysql_select_db($BD2,$conexion_bd2) or die(mysql_error($conexion_bd2));
								$consulta2 = "SELECT * FROM tarjetero";
								$resultado2 = mysql_query($consulta2,$conexion_bd2);
								if($resultado2)
								{
									$total_tarjetero = mysql_num_rows($resultado2);
									echo mysql_num_rows($resultado2);
								}
								else
								{
									echo "<strong>Error: conection</strong>";
								}
								mysql_close($conexion_bd2);
							?>
						</td>
						<td>
							<?php
								$porcentaje = round(($total_tarjetero/$total_activas)*100,2);
								echo $porcentaje."%";
							?>
						</td>
						<td>
							<?php
								$conexion = conectar_bd();
								$consulta = "SELECT * FROM tb_admision WHERE adm_estado='A' AND adm_hcu!='0'";
								$resultado = mysql_query($consulta,$conexion);
								if($resultado)
								{
									$i=0;
									while($row=mysql_fetch_assoc($resultado))
									{
										$longitud = strlen($row['adm_hcu']);
										if($longitud==10)
										{
											if(validaCedulaPhp($row['adm_hcu']))
											{
												$i++;
											}
										}
									}
									echo "".$i."";
								}
								else
								{
									echo "<strong>Error: conection</strong>";
								}
							?>
						</td>
						<td>
							<?php
								$consulta = "SELECT * FROM tb_admision WHERE adm_estado='A' AND adm_hcu!='0' AND adm_fecha_nacimiento!='0000-00-00'";
								$resultado = mysql_query($consulta,$conexion);
								if($resultado)
								{
									$i=0;
									while($row=mysql_fetch_assoc($resultado))
									{
										$longitud = strlen($row['adm_hcu']);
										if($longitud==10)
										{
											if(validaCedulaPhp($row['adm_hcu']))
											{
												if((calculadorEdad($row['adm_fecha_nacimiento'])>=5)&&(calculadorEdad($row['adm_fecha_nacimiento'])<=100))
												{
													$i++;
												}
											}
										}
									}
									echo "".$i."";
								}
								else
								{
									echo "<strong>Error: conection</strong>";
								}
							?>
						</td>
						<td>
							<?php
								$consulta = "SELECT * FROM tb_admision WHERE adm_estado='A' AND adm_hcu!='0' AND adm_fecha_nacimiento!='0000-00-00'";
								$resultado = mysql_query($consulta,$conexion);
								if($resultado)
								{
									$i=0;
									while($row=mysql_fetch_assoc($resultado))
									{
										$longitud = strlen($row['adm_hcu']);
										if($longitud==10)
										{
											if(validaCedulaPhp($row['adm_hcu']))
											{
												if((calculadorEdad($row['adm_fecha_nacimiento'])>=5)&&(calculadorEdad($row['adm_fecha_nacimiento'])<=100))
												{
													if(str_word_count($row['adm_apellido'],0)<=2)
													{
														$i++;
													}
												}
											}
										}
									}
									echo "".$i."";
								}
								else
								{
									echo "<strong>Error: conection</strong>";
								}
							?>
						</td>
						<td>
							<?php
								$consulta = "SELECT * FROM tb_admision WHERE adm_estado='A' AND adm_hcu!='0' AND adm_fecha_nacimiento!='0000-00-00'";
								$resultado = mysql_query($consulta,$conexion);
								if($resultado)
								{
									$i=0;
									while($row=mysql_fetch_assoc($resultado))
									{
										$longitud = strlen($row['adm_hcu']);
										if($longitud==10)
										{
											if(validaCedulaPhp($row['adm_hcu']))
											{
												if((calculadorEdad($row['adm_fecha_nacimiento'])>=5)&&(calculadorEdad($row['adm_fecha_nacimiento'])<=100))
												{
													if(str_word_count($row['adm_apellido'],0)<=2)
													{
														if(str_word_count($row['adm_nombre'],0)<=2)
														{
															$i++;
														}
													}
												}
											}
										}
									}
									echo "".$i."";
								}
								else
								{
									echo "<strong>Error: conection</strong>";
								}
							?>
						</td>
					</tr>
				</table>
			</div>
			<div id="resultado-busqueda" name="resultado-busqueda"></div>
		</div>
		<script src=""></script>
	</body>
</html>