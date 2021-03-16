<!DOCTYPE html>
<?php
 	$arraySexo = array("M"=>"Masculino","F"=>"Femenino");
?>
<html>
	<head>
		<script src="assets/js/jquery-1.11.2.min.js"></script>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="assets/css/estilo1.css">
		<style type="text/css">
			#edicion, #edicion-guardada
			{
				background-color: #dadada;
				padding-left: 5%;
				padding-top: 2%;
				padding-bottom: 2%;
			}
			.frm-todo
			{
				display: none;
			}
		</style>
	</head>
	<body>
		<div id="edicion" name="edicion">
			<form>
				<table>
					<tr class="frm-busqueda">
						<td><label>Numero de Archivo:</label></td>
					 	<td><input type="text" id="narchivo" name="narchivo"/></td>
					 	<td><input type="button" id="btn-buscar" name="btn-buscar" value="Buscar" /></td>
					 	<td id="c-fecha-hoy" name="c-fecha-hoy" alt="dia" style="visibility: hidden"><?php echo date("Y-m-d");?></td>
					</tr>
					<tr class="frm-todo">
						<td><label>Fecha de Admision:</label></td>
						<td><input type="date" id="fechaadm" name="fechaadm" /></td>
					</tr>
					<tr class="frm-todo"><td colspan="4"><hr></td></tr>
					<tr class="frm-todo">
						<td><label>Historia Clinica:</label></td>
						<td><input type="text" id="hcus" name="hcus" /></td>
						<td id="verifica-cedula" style="color:red;"></td>
						<!---<td>
							<a href="javascript:window.open('assets/includes/admision','','width=600,height=400,left=50,top=50,toolbar=yes');void 0">
								Nueva nueva ventana
							</a>
						</td>-->
					</tr>
					<tr class="frm-todo"><td colspan="4"><hr></td></tr>
					<tr class="frm-todo">
						<td><label>Apellido paterno:</label></td>
						<td><input type="text" id="apellidos" name="apellidos" /></td>
						<td><label>Apellido materno:</label></td>
						<td><input type="text" id="amaterno" name="amaterno" /></td>
					</tr>
					 <tr class="frm-todo">
						 <td><label>Primer Nombre:</label></td>
						 <td><input type="text" id="nombres" name="nombres" /></td>
						 <td><label>Segundo Nombre:</label></td>
						 <td><input type="text" id="nombre2" name="nombre2" /></td>
					</tr>
					<tr class="frm-todo"><td colspan="4"><hr></td></tr>
					<tr class="frm-todo">
						<td><label>Nombre del Padre:</label></td>
						<td><input type="text" id="nombre-padre" name="nombre-padre" /></td>
						<td><label>Nombre de la Madre:</label></td>
						<td><input type="text" id="nombre-madre" name="nombre-madre" /></td>
					</tr>
					
					<tr class="frm-todo">
						<td><label>Fecha de nacimiento:</label></td>
						<td><input type="date" id="fechan" name="fechan" /></td>
						<td><label>Edad:</label></td>
						<td><input type="text" id="edad-actual" name="edad-actual" readonly="readonly"/></td></tr>
					</tr>
					<tr class="frm-todo"><td colspan="4"><hr></td></tr>
					<tr class="frm-todo" id="frm-ced-repre" alt="off">
						<td><label>Representante:</label></td>
						<td><input type="text" id="n-representante" name="n-representante" />
						<td><label>Cedula:</label></td>
						<td><input type="text" id="cd-representante" name="cd-representante" maxlength="10" /></td>
					</tr>

					<tr class="frm-todo">
						<td><label>Sexo:</label></td>
						<td>
							<select id="lssexo" name="lssexo">
							<?php
								foreach ($arraySexo as $key => $value)
								{
								 	echo "<option value='",$key,"'>",$value,"</option>";
								}
							?>
							 </select>
						</td>
					</tr>

					<tr class="frm-todo">
						<td><label>Telefono:</label></td>
						<td><input type="text" id="p-telefono" name="p-telefono"  maxlength="10"/></td>	
					</tr>

					<tr class="frm-todo">
						<td><label>Fecha ultima cita:</label></td>
						<td><input type="date" id="fechauc" name="fechauc" /></td>
					</tr>
					<tr class="frm-todo">
						<td><label>Fecha proxima cita:</label></td>
						<td><input type="date" id="fechapc" name="fechapc" /></td>
					</tr>
					<tr class="frm-todo">
						 <td><label>Observacion:</label></td>
						 <td colspan="2"><input type="text" id="observacion" name="observacion" size="50px" /></td>
					</tr>
					<tr class="frm-todo">
						<td id="td-boton"><input type="button" id="btn-guardar" name="btn-guardar" value="Guardar cambios"/></td>
					</tr>
					<tr class="frm-todo"><td colspan="4"><hr></td></tr>
					<tr class="frm-todo">
						<td colspan="4">
							<input type="button" id="btn-ap-separar" name="btn-ap-separar" value="Separar Apellidos"/>
							<input type="button" id="btn-no-separar" name="btn-no-separar" value="Separar Nombres"/>
							<input type="button" id="btn-a-padres" name="btn-a-padres" value="Añadir Padres"/></td>
					</tr>
					<tr class="frm-todo"><td colspan="4"><hr></td></tr>
				</table>
			</form>
		</div>
		<div id="edicion-guardada" name="edicion-guardada" style="display: none;">
			<span id="mensaje-guardado"></span>
		</div>		
	<script src="assets/js/script-edicion.js"></script>
	</body>
</html>
