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
			.t-resultado
			{
				background-color: white;
				text-align: center;
			}
			.t-header
			{
				background-color: #045FB4;
				color: white;	
			}
			.btn-atiende-s:hover
			{
				font-weight: bold;
				cursor: pointer;
			}
			#l-sobre:hover
			{
				cursor: pointer;
			}
		</style>
	</head>
	<body>
		<div id="contenedor-busqueda">
			<H1 class="btn-atiende-s">Agendamiento</H1>
			<div id="busqueda" name="busqueda">
				<form>
					<table>
						<tr>
							<td class="items"><label id="lhcu" name="lhcu">Fecha:</label></td>
							<td><input type="date" id="a-fecha" name="a-fecha"/><input type="button" id="a-consultar" name ="a-consultar" value="Consultar" alt="consultarProfesional"/></td>
							<td id="c-fecha-hoy" name="c-fecha-hoy" alt="dia" style="visibility: hidden"><?php echo date("Y-m-d");?></td>
							<td id="c-hora-hoy" name="c-hora-hoy" alt="hora" style="visibility: hidden"><?php echo date("G:i:s");?></td>
						</tr>
						<tr class="c-profesional">
							<td class="items"><label id="profesional" name="profesional">Profesional:</label></td>
							<td id="combo-profesional" name="combo-profesional">
								<select id="a-profesional" name="a-profesional">
									<?php
										$consulta = "SELECT * FROM tb_profesional WHERE pro_estado = 'A' ORDER BY pro_apellidos";
										$resultado = mysql_query($consulta,$conexion);
										echo '';
										if ($resultado)
										{
											$bdr=0;
											echo "<option id='todos' name='todos' class='c-prof' value='*'>Seleccione una Opcion</option>";
											while ($row = mysql_fetch_assoc($resultado)) 
											{
												
												echo "<option class='c-prof' value=".$row['pro_cedula']." id='".$row['pro_cedula']."'>".$row['pro_apellidos']." ".$row['pro_nombres']."</option>";
												$arrayProfesional = array($row['pro_cedula'] => $row['pro_apellidos']." ".$row['pro_nombres']);
												$bdr=$bdr+1;
											}
										}
										echo ""
									?>
								</select>
							</td>
							<td>
								<input type="button" id="a-actualizar" name ="a-actualizar" value="Consultar/Actualizar" alt=""/>
							</td>
						</tr>
						<tr class="sobreagenda-p">
							<label id="l-sobre" name="l-sobre" style="color: #00CC00; font-weight: bold" alt="false">
								Tienes solicitudes de Sobreagenda pendientes
							</label>
						</tr>
						<tr class="n-cita">
							<td class="items">
								<label style="color: #00CC00; font-weight: bold">Cita:<?php echo " ";?></label>
								<label id="cita" name="cita" style="color: #00CC00; font-weight: bold" alt="false"></label>
							</td>
							<td>
								<input type="button" id="a-agendar" name ="a-agendar" value="Mostrar" alt=""/>
								<input type="button" id="a-eliminar" name ="a-eliminar" value="Eliminar" alt=""/>
								<input type="button" id="a-confirmar" name ="a-confirmar" value="Confirmar" alt=""/>
							</td>
						</tr>
						<tr class="c-d-paciente">
							<td class="items">
								<!--<label id="lnArchivo" name="lnArchivo">Num. Archivo:</label>-->
								<form>
									<div><input type="radio" id="c-tipo-na" name="c-tipo-id" value="na" checked/>N.A.</div>
									<div><input type="radio" id="c-tipo-hcu" name="c-tipo-id" value="hcu">H.C.U.</div>
								</form>
							</td>
							<td><input type="text" id="nArchivo" name="nArchivo" maxlength="17" size="10" /><input type="checkbox" id="vez" name="vez" value="P"/>Primera Vez</td>
						</tr>
						<tr class="c-d-paciente">
							<td>
								<label id="c-horario" name="c-horario" style="color: #00CC00; font-weight: bold" alt="false"></label>
							</td>
							<td>
								<input type="text" id="apellidos" name="apellidos" readonly="readonly" maxlength="40" size="40" />
							</td>
							<td>
								<label>Edad:</label>
								<input type="text" id="p-edad" name="p-edad" readonly="readonly" maxlength="2" size="3" />
							</td>
							<td>
								<label id="l-observacion" name="l-observacion">Observacion:</label>
								<input type="text" id="c-observacion" name="c-observacion" maxlength="50" size="30" />
							</td>
						</tr>
						<tr class="c-d-paciente">
						</tr>
					</table>
				</form>
				<div>
					<input type="button" id="quitar-s" name="quitar-s" alt="false" value="Quitar de la lista"/>
				</div>
				<div id="lista-sobre" name="lista-sobre">
				</div>
			</div>
			<div id="r-agendas" name="r-agendas">
			</div>
		</div>
		<script src="assets/js/script-citas.js">
		</script>
	</body>
</html>
