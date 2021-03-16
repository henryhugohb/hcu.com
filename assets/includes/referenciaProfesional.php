<!DOCTYPE html>
<?php 
	$arraySexo = array("H"=>"HOMBRE","M"=>"MUJER");
 	include("conexion.php");
	$conexion = conectar_bd();
?>
<html>
	<head>
		<script src="assets/js/jquery-1.11.2.min.js"></script>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="assets/css/estilo1.css">
		<style type="text/css">
			#admision, #admision-guardada
			{
				background-color: #dadada;
				padding-left: 5%;
				padding-top: 2%;
				padding-bottom: 2%;
			}
		</style>
	</head>
	<body>
		<div id="admision" name="admision">
			<span><?php echo date("l");?></span>
			<span id="c-fecha-hoy"><?php echo date("Y-m-d");?></span>
			<span id="c-hora-hoy" style="display:none;"><?php echo date("H:i");?></span>
			<h1>Sistema de Referencia y Contrareferencia</h1>
			<form action="" method="POST">
				<table>
					<!--tr>
						<td colspan="2"><label>Profesional que refiere</label></td-->
					<tr>
						<td colspan="2">
<!--Modificado-->		<select id="profesional-ref" name="profesional-ref" disabled>
							<?php
								$consulta = "SELECT * FROM tb_profesional WHERE pro_estado = 'A' AND pro_cedula='".$_GET['profesional']."'";
								$resultado = mysql_query($consulta,$conexion);
								echo '';
								if ($resultado)
								{
									$bdr=0;
									//echo "<option id='todos' name='todos' class='c-prof' value='*'>Seleccione una Opcion</option>";
									while ($row = mysql_fetch_assoc($resultado)) 
									{
										
										echo "<option class='c-prof' value=".$row['pro_cedula']." id='".$row['pro_cedula']."'>".$row['pro_apellidos']." ".$row['pro_nombres']."</option>";
										//echo "<input type='text' class='c-prof' alt=".$row['pro_cedula']." id='".$row['pro_cedula']."' value='".$row['pro_apellidos']." ".$row['pro_nombres']."' size='50px' disabled />";
										$arrayProfesional = array($row['pro_cedula'] => $row['pro_apellidos']." ".$row['pro_nombres']);
										$bdr=$bdr+1;
									}
								}
								echo ""
							?>
							<!--/select-->
						</td>
					</tr>
					<tr class="frm-narchivo">
						<td>
							<label>Numero de Archivo:</label>
						</td>
						<td>
							<?php
								echo '<input type="text" id="narchivo" name="narchivo" value="'.$_GET['paciente'].'" maxlength="10" disabled/>';
							?>							
						</td>
						<td>
							<input type="button" id="btn-buscar" name="btn-buscar" value="Buscar" style="display:none;"/>
						</td>
					</tr>
					<tr class="frm-datos-paciente">
						<td><label>Numero de Cedula:</label></td>
						<td><label>Apellido Paterno</label></td>
						<td><label>Apellido Materno</label></td>
						<td><label>Primer Nombre:</label></td>
						<td><label>Segundo Nombre:</label></td>
					</tr>
					<tr class="frm-datos-paciente">
						<td><input type="text"  id="hcus" name="hcus" readonly="readonly"/></td>
						<td><input type="text" id="apellidop" name="apellidop"  readonly="readonly" /></td>
						<td><input type="text" id="apellidom" name="apellidom"  readonly="readonly" /></td>
						<td><input type="text" id="nombre1" name="nombre1"  readonly="readonly" /></td>
						<td><input type="text" id="nombre2" name="nombre2"  readonly="readonly" /></td>
					</tr>
					<tr class="frm-datos-paciente">
						<td><label>Fecha de nacimiento</label></td>
						<td><label>Edad</label></td>
						<td><label>Sexo</label></td>
						<td><label>Telefono</label></td>
					<tr class="frm-datos-paciente">
						<td><input type="date" id="fechan" name="fechan"  readonly="readonly"/></td>
						<td><input type="text" id="edad-actual" name="edad-actual" readonly="readonly"/></td>
						<td><input type="text" id="lssexo" name="lssexo" readonly="readonly"/></td>
						<td><input type="text" id="telefono" name="telefono" maxlength="10"/></td>
					</tr>
					<tr class="frm-datos-paciente">
						<td><label>Provincia</label></td>
						<td><label>Canton</label></td>
						<td><label>Parroquia</label></td>
						<td><label>Comuna - Barrio</label></td>
						<td><label>Direccion</label></td>
					<tr class="frm-datos-paciente">
						<?php
							$consulta = "SELECT * FROM tb_provincia WHERE pro_st = 'A' ORDER BY pro_descripcion";
							mysql_query("SET NAMES 'utf8'");
							$resultado = mysql_query($consulta,$conexion);
							echo '<td><select id="cmb-provincia" name="cmb-provincia" style="width: 150px;">';
							if($resultado)
							{
								while($row=mysql_fetch_assoc($resultado))
								{
									echo "<option value='".$row['cod_provincia']."'>".$row['pro_descripcion']."</option>";
								}
							}
							else
							{
								echo "<option>Error de Conexion</option>";
							}
							echo '</select></td>';
							
							echo '<td id="canton" name="canton"><select id="cmb-canton" name="cmb-canton" style="width: 150px;"><option value="*">Seleccione una provincia</option></select></td>';
							echo '<td id="parroquia" name="parroquia"><select id="cmb-parroquia" name="cmb-parroquia" style="width: 150px;"><option value="*">Seleccione un canton</option></select></td>';

						?>
						<td><input type="text" id="comuna" name="comuna"/></td>
						<td><input type="text" id="direccion" name="direccion"/></td>
					</tr>
					<tr class="frm-referencia">
						<td><label>Refiere a:</label></td>
						<td><label>Especialidad</label></td>
						<td><label>Servicio</label></td>
					</tr>
					<tr class="frm-referencia">
						<?php
							$consulta = "SELECT * FROM tb_nivel WHERE niv_estado = 'A' AND niv_nivel>1 ORDER BY niv_nombre";
							//mysql_query("SET NAMES 'utf8'");
							$resultado = mysql_query($consulta,$conexion);
							echo '<td><select id="cmb-nivel" name="cmb-nivel" style="width: 150px;">';
							if($resultado)
							{
								while($row=mysql_fetch_assoc($resultado))
								{
									echo "<option value='".$row['niv_codigo']."'>".$row['niv_nombre']."</option>";
								}
							}
							else
							{
								echo "<option>Error de Conexion</option>";
							}
							echo '</select></td>';
							
							$consulta = "SELECT * FROM tb_sub_especialidad WHERE sub_estado = 'A'";
							//mysql_query("SET NAMES 'utf8'");
							$resultado = mysql_query($consulta,$conexion);
							echo '<td><select id="cmb-especialidad" name="cmb-especialidad" style="width: 150px;">';
							if($resultado)
							{
								while($row=mysql_fetch_assoc($resultado))
								{
									echo "<option value='".$row['sub_codigo']."'>".$row['sub_descripcion']."</option>";
								}
							}
							else
							{
								echo "<option>Error de Conexion</option>";
							}
							echo '</select></td><td><select id="servicio" name="servicio" style="width: 150px;">';
							echo "<option value='CE'>CONSULTA EXTERNA</option>";
							echo "<option value='E'>EMERGENCIA</option>";
							echo '</select></td>';
						?>
						<td></td>
					</tr>
					<tr class="frm-emergencia" id="control-emergencia" alt="off">
						<td><label>Fecha:</label></td>
						<td><label>Hora</label></td>
						<td colspan="2"><label>Medico que recibe la emergencia</label></td>
					</tr>
					<tr class="frm-emergencia">
						<td><input type="date" id="fecha-cita"/></td>
						<td><input type="time" id="hora-cita"/></td>
						<td colspan="2"><input type="text" id="medico-cita" maxlength="50" size="50px" /></td>
					</tr>
					<tr class="frm-referencia">
						<td><label>CIE10</label></td>
						<td></td>
						<td colspan="3"><label>Diagnostico</label></td>
						<td><label>Condicion</label></td>
					<tr class="frm-referencia">
						<td><input type="text" id="cie10" name="cie10"/></td>
						<td>
							<input type="button" id="btn-buscar-cie" name="btn-buscar-cie" value="Buscar"/>
						</td>
						<td colspan="3"><input type="text" id="diagnostico" name="diagnostico" size="70" readonly="readonly"/></td>
						<?php
							echo '<td><select id="condicion" name="condicion">';
							echo "<option value='P'>PRESUNTIVO</option>";
							echo "<option value='D'>DEFINITIVO</option>";
							echo '</select></td>';
						?>
					</tr>
					<tr class="frm-referencia">
						<td>
							<input type="button" id="btn-guardar" name="btn-guardar" value="Guardar Registro"/>
						</td>
					</tr>
				</table>
			</form>
		</div>
		<div id="admision-guardada" name="admision-guardada" style="display: none;">
			<table>
				<tr>
					<td id="mensaje-guardado"></td>
				</tr>
				<tr>	
					<td><input type="button" id="btn-generar001" name="btn-generar001" value="Generar Form: 001 - Admision"/></td>
				</tr>
			</table>
			<?php
				mysql_close($conexion);
			?>
		</div>		
	<script src="assets/js/script-referenciaProfesional.js"></script>
	</body>
</html>