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
			<H1>Atencion de Citas</H1>
			<div id="busqueda" name="busqueda">
				<form>
					<table>
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
							<td class="login-p">
								<label>Pin Code:</label>
								<input type="password" id="p-pin" name ="p-pin" maxlength="4" />
								<input type="button" id="p-validar" name ="p-validar" value="Validar"/>
							</td>
							<td id="login-i">
								<img style="width: 20px; height: 20px;" src="http://i.forbesimg.com/assets/img/loading_spinners/43px_on_transparent.gif">
							</td>
							<td>
								
							</td>
							<td id="especialidad-prof" name="especialidad-prof" style="visibility: hidden"></td>
							<td><input type="button" id="a-ver-grupo" name ="a-ver-grupo" value="Ver Grupo Etareo" alt=""/></td>
							<td><input type="button" id="a-ver-referencia" name ="a-ver-referencia" value="Ver Referencias" alt=""/></td>
						</tr>
						<tr>
							<td class="fecha-b"><label id="lhcu" name="lhcu">Fecha:</label></td>
							<td class="fecha-b"><input type="date" id="a-fecha" name="a-fecha"/><input type="button" id="a-consultar" name ="a-consultar" value="Consultar/Actualizar" alt="consultarProfesional"/></td>
							<td id="c-fecha-hoy" name="c-fecha-hoy" alt="dia" style="visibility: hidden"><?php echo date("Y-m-d");?></td>
							<td id="c-hora-hoy" name="c-hora-hoy" alt="hora" style="visibility: hidden"><?php echo date("G:i:s");?></td>
						</tr>
						<tr><td></br></td></tr>
						<tr id="tipo-atender" class="c-d-paciente">
							<td class="items" colspan="5">
								<fieldset>
									<legend class="datos-cita">
										<label id="info-paciente-na">Datos</label>
										<label id="info-paciente-nombres">paciente</label>
										<label id="info-paciente-hcu">paciente</label>
									</legend>
									<form>
										<input class="datos-cita" type="radio" id="c-tipo-p" name="c-tipo-id" value="P" checked/>Prevencion
										<input class="datos-cita" type="radio" id="c-tipo-m" name="c-tipo-id" value="M">Morbilidad
										<label class="datos-cita"> - Edad:</label>
										<input class="datos-cita" type="text" id="p-edad" name="p-edad" readonly="readonly" maxlength="2" size="3" />
										<label class="datos-cita" id="c-hora-c" name="c-hora-c" style="visibility: hidden" alt="false"></label>
										<label class="datos-cita" id="estado-c" name="estado-c" style="visibility: hidden" alt="false"></label>
										<label class="datos-cita" id="primera-c" name="primera-c" style="visibility: hidden" alt="false"></label>
										<label class="datos-cita" id="n-archivo" name="n-archivo" style="visibility: hidden" alt="false"></label>
										<span class="datos-cita" id="comboEstadoNutri" name="comboEstadoNutri"></span>
										<select class="datos-cita" id="e-visita" name="e-visita">
											<option value="P">Primera</option>
											<option value="S">Subsecuente</option>
										</select>
										<input type="button" id="e-guardar" name ="e-guardar" value="Guardar" alt=""/>
										<input type="button" id="e-cancelar" name ="e-cancelar" value="Cancelar" alt=""/>
									</form>
									<div id="resultado-busqueda3" name="resultado-busqueda3"></div>
									<div id="resultado-busqueda2" name="resultado-busqueda2"></div>
								</fieldset>

							</td>
						</tr>

						<tr class="n-cita">
							<td class="items">
								<label style="color: #00CC00; font-weight: bold"><?php echo " ";?></label>
								<label id="cita" name="cita" style="color: #00CC00; font-weight: bold" alt="false"></label>
								
							</td>
							<td>
								<input type="button" id="a-atender" name ="a-atender" value="Atender" alt=""/>
<!--Modificado 30-05-2016-->	<input type="button" id="a-referir" name ="a-referir" value="Referir" alt=""/>
								<!--
									<input type="button" id="a-atender" name ="a-atender" value="Atender" alt=""/>
									<input type="button" id="a-eliminar" name ="a-eliminar" value="Eliminar" alt=""/>
									<input type="button" id="a-confirmar" name ="a-confirmar" value="Confirmar" alt=""/>
								-->
							</td>
						</tr>
						
						<tr class="c-d-paciente">
							<td><label id="c-horario" name="c-horario" style="color: #00CC00; font-weight: bold" alt="false"></label></td>
							<td><input type="text" id="apellidos" name="apellidos" readonly="readonly" maxlength="40" size="40" /></td>
							<td>
								<label id="l-observacion" name="l-observacion">Observacion:</label>
								<input type="text" id="c-observacion" name="c-observacion" maxlength="20" size="20" />
							</td>
						</tr>
						<tr class="c-d-paciente">
							
						</tr>
					</table>
				</form>
			</div>
			<div id="r-agendas" name="r-agendas">
			</div>
		</div>
		<script src="assets/js/script-atencion.js"></script>
	</body>
</html>