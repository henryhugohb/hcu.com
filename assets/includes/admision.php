<!DOCTYPE html>
<?php 
	$arrayProvinciasec = array(
		"99"=> "Extranjero",
		"01"=> "Azuay",
		"02"=> "Bolivar",
		"03"=> "Cañar",
		"04"=> "Carchi",
		"05"=> "Cotopaxi",
		"06"=> "Chimborazo",
		"07"=> "El Oro",
		"08"=> "Esmeraldas",
		"09"=> "Guayas",
		"10"=> "Imbabura",
		"11"=> "Loja",
		"12"=> "Los Rios",
		"13"=> "Manabi",
		"14"=> "Morona Santiago",
		"15"=> "Napo",
		"16"=> "Pastaza",
		"17"=> "Pichincha",
		"18"=> "Tungurahua",
		"19"=> "Zamora Chinchipe",
		"20"=> "Galapagos",
		"21"=> "Sucumbios",
		"22"=> "Orellana",
		"23"=> "Santo Domingo de los Tsachilas",
		"24"=> "Santa Elena"
 	);
 	$arraySexo = array("M"=>"Masculino","F"=>"Femenino");
 	$tipo_ventana = $_GET['tipo'];
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
			<span id="fecha-dia"><?php echo date("Y-m-d");?></span>
			<?php 
				echo '<h1 id="titulo-admision" ';

				if($tipo_ventana=='cedula')
				{
					echo 'alt="ad-cedula">Admision por Cedula de Ciudadania.';
				}
				if($tipo_ventana=='inscrito')
				{
					echo 'alt="ad-inscrito">Admision por Datos del Usuario.';
				}
				if($tipo_ventana=='noinscrito')
				{
					echo 'alt="ad-no-inscrito">Admision por Datos de la Madre (no inscrito Registro Civil).';
				}
				if($tipo_ventana=='insertar')
				{
					echo 'alt="insertar">Insertar Numero de Archivo Existente.';
				}
			?>
			</h1>
			<form action="assets/includes/guardarAdmision.php" method="POST">
				<table>
					<tr class="frm-todo">
						<td><label>Historia Clinica:</label></td>
						<td><input type="text" id="hcus" name="hcus" readonly="readonly" /></td>
					</tr>
					<?php
						if($tipo_ventana=='cedula' || $tipo_ventana=='insertar')
						{
							echo '<tr class="frm-todo"><td colspan="4"><hr></td></tr>';
							echo '<tr class="frm-cedula"><td>';
							echo "<label>Numero de cedula:</label>";
							echo '</td><td><input	type="text" id="txt-cedula" name="txt-cedula"/></td></tr>';
						}
						if($tipo_ventana=='cedula' || $tipo_ventana=='inscrito' || $tipo_ventana=='insertar')
						{
							echo '<tr class="frm-todo"><td colspan="4"><hr></td></tr>';
							echo '<tr class="frm-inscritos">';
							echo "<td><label>Apellido Paterno</label></td>";
							echo '<td><input type="text" id="apellidop" name="apellidop" /></td>';
							//echo "</tr>";
							//echo '<tr class="frm-inscritos">';
							echo "<td><label>Apellido Materno</label></td>";
							echo '<td><input type="text" id="apellidom" name="apellidom" /></td>';
							echo "</tr>";
							echo '<tr class="frm-inscritos">';
							echo "<td><label>Primer Nombre:</label></td>";
							echo '<td><input type="text" id="nombre1" name="nombre1" /></td>';
							//echo "</tr>";
							//echo '<tr class="frm-inscritos">';
							echo "<td><label>Segundo Nombre:</label></td>";
							echo '<td><input type="text" id="nombre2" name="nombre2" /></td>';
							echo "</tr>";
							echo '<tr class="frm-todo"><td colspan="4"><hr></td></tr>';
							echo '<tr class="frm-inscritos">';
							echo "<td><label>Nombre del Padre:</label></td>";
							echo '<td><input type="text" id="nombre-padre" name="nombre-padre" /></td>';
							//echo "</tr>";
							//echo '<tr class="frm-inscritos">';
							echo "<td><label>Nombre de la Madre:</label></td>";
							echo '<td><input type="text" id="nombre-madre" name="nombre-madre" /></td>';
							echo "</tr>";
						}
						if($tipo_ventana=='noinscrito')
						{
							echo '<tr class="frm-no-inscritos">';
							echo "<td><label>Primer Apellido de la Madre:</label></td>";
							echo '<td><input type="text" id="madreapellidop" name="madreapellidop" /></td></tr>';
							echo '<tr class="frm-no-inscritos">';
							echo '<td><label>Segundo Apellido de la Madre:</label></td>';
							echo '<td><input type="text" id="madreapellidom" name="madreapellidom" /></td></tr>';
							echo '<tr class="frm-no-inscritos">';
							echo '<td><label>Primer Nombre de la Madre:</label></td>';
							echo '<td><input type="text" id="madrenombre1" name="madrenombre1" /></td></tr>';
							echo '<tr class="frm-no-inscritos">';
							echo '<td><label>Numero de hijos nacidos vivos de la madre:</label></td>';
							echo '<td><input type="text" id="madrenombre2" name="madrenombre2" /></td></tr>';

							echo '<tr class="frm-inscritos">';
							echo "<td><label>Nombre del Padre:</label></td>";
							echo '<td><input type="text" id="nombre-padre" name="nombre-padre" /></td>';
							//echo "</tr>";
							//echo '<tr class="frm-inscritos">';
							echo "<td><label>Nombre de la Madre:</label></td>";
							echo '<td><input type="text" id="nombre-madre" name="nombre-madre" /></td>';
							echo "</tr>";
						}
						if($tipo_ventana=='noinscrito' || $tipo_ventana=='inscrito' || $tipo_ventana=='cedula' || $tipo_ventana=='insertar')
						{
							echo '<tr class="frm-todo">';
							echo '<td><label>Fecha de nacimiento:</label></td>';
							echo '<td><input type="date" id="fechan" name="fechan" /></td>';
							echo '<td><label>Edad:</label></td>';
							echo '<td><input type="text" id="edad-actual" name="edad-actual" readonly="readonly"/></td></tr>';
							
							echo '<tr class="frm-ced-repre" alt="off">';
							echo '<td><label>Representante:</label></td>';
							echo '<td><input type="text" id="n-representante" name="n-representante" />	';
							echo '<td><label>Cedula:</label></td>';
							echo '<td><input type="text" id="cd-representante" name="cd-representante" maxlength="10" /></td></tr>';

							echo '<tr class="frm-todo">';
							echo '<td><label>Sexo:</label></td><td>';
							echo '<select id="lssexo" name="lssexo">';
							foreach ($arraySexo as $key => $value) {
								echo "<option value='",$key,"'>",$value,"</option>";
							}
							echo '</select></td></tr>';
							echo '<tr class="frm-todo">';
							echo '<td><label>Provincia:</label></td><td>';
							echo '<select id="lsprovincias" name="lsprovincias">';
							foreach ($arrayProvinciasec as $key => $value) {
								echo "<option value='",$key,"'>",$value,"</option>";
							}
							echo '</select></td></tr>';

							echo '<tr class="frm-todo">';
							echo '<td><label>Telefono:</label></td>';
							echo '<td><input type="text" id="p-telefono" name="p-telefono"  maxlength="10"/></tr>';
							echo '<tr class="frm-todo"><td colspan="4"><hr></td></tr>';
							echo '<tr class="frm-todo">';
							echo '<td><label>Numero de Archivo:</label></td>';
							if($tipo_ventana=='insertar')
							{
								echo '<td><input type="text" id="narchivo" name="narchivo"/></td></tr>';
							}
							else
							{
								echo '<td><input type="text" id="narchivo" name="narchivo" readonly="readonly" /></td></tr>';
							}
							echo '<tr class="frm-todo">';
							echo '<td><input type="button" id="btn-generar" name="btn-generar" value="Gererar HCU" /></td>';
							echo '<td id="td-boton"><input type="button" id="btn-guardar" name="btn-guardar" value="Guardar Admision" style="display: none;"/></td></tr>';
						}
					?>
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
		</div>		
	<script src="assets/js/script-admision.js"></script>
	</body>
</html>