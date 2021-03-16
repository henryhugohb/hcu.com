<!DOCTYPE html>
<?php
	$arraySexo = array("M"=>"Masculino","F"=>"Femenino");
?>
<html>
	<head>
		<script src="assets/js/jquery-1.11.2.min.js"></script>
		<link rel="stylesheet" type="text/css" href="assets/css/estilo1.css">
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<link rel="stylesheet" type="text/css" href="../css/estilo1.css">
		<style type="text/css">
			#frm-001, #frm001-guardada
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
			td
			{
				border: solid 1px;
			}
			#primera-admision
			{
				width: 10%;
			}
		</style>
	</head>
	<body>
		<div id="frm-001" name="frm-001">
			<!--<form>-->
				<table id="primera-admision">
					<tr>
						<td>Institucion del Sistema</td>
						<td><input type="text" id="i-is"  size="20" name="i-is" readonly="readonly" /></td>
					</tr>
					<tr>
						<td>Unidad Operativa</td>
						<td><input type="text" id="i-uo"  size="20" name="i-uo" readonly="readonly" /></td>
					</tr>
					<tr>
						<td>Cod U.O.</td>
						<td><input type="text" id="i-cu"  size="20" name="i-cu" readonly="readonly" /></td>
					</tr>
					<tr>
						<td>Parroquia</td>
						<td><input type="text" id="i-pa"  size="20" name="i-pa" readonly="readonly" /></td>
					</tr>
					<tr>
						<td>Canton</td>
						<td><input type="text" id="i-ca"  size="20" name="i-ca" readonly="readonly" /></td>
					</tr>
					<tr>
						<td>Provincia</td>
						<td><input type="text" id="i-pr"  size="20" name="i-pr" readonly="readonly" /></td>
					</tr>
					<tr>
						<td colspan="2">Direccion Domiciliaria</td>
					</tr>
					<tr>
						<td>Provincia</td>
						<td><select id="p-pr" name="p-pr"></select></td>
					</tr>
					<tr>
						<td>Canton</td>
						<td><select id="p-ca" name="p-ca"></select></td>
					</tr>
					<tr>
						<td>Parroquia</td>
						<td><select id="p-pa" name="p-pa"></select></td>
					</tr>
					<tr>
						<td>Barrio</td>
						<td><input type="text" id="p-ba"  size="20" name="p-ba"/></td>
					</tr>
					<tr>
						<td>Calle y No. Manzana y Casa</td>
						<td><input type="text" id="p-cm"  size="20" name="p-cm"/></td>
					</tr>
					<tr>
						<td>Zona (Urbana/Rural)</td>
						<td><input type="text" id="p-zo"  size="20" name="p-zo"/></td>
					</tr>
					<tr>
						<td>Telefono</td>
						<td><input type="text" id="p-te"  size="20" name="p-te"/></td>
					</tr>
					<tr>
						<td>Nacionalidad</td>
						<td><select id="p-na" name="p-na"></select></td>
					</tr>
					<tr>
						<td>Lugar Nacimiento</td>
						<td><select id="p-ln" name="p-ln"></select></td>
					</tr>
					<tr>
						<td>Grupo Cultural</td>
						<td><select id="p-gc" name="p-gc"></select></td>
					</tr>
					<tr>
						<td>Edad</td>
						<td><input type="text" id="p-ed"  size="20" name="p-ed"/></td>
					</tr>
					<tr>
						<td>Estado Civil</td>
						<td><select id="p-ec" name="p-ec"></select></td>
					</tr>
					<tr>
						<td>Instruccion</td>
						<td><select id="p-in" name="p-in"></select></td>
					</tr>
					<tr>
						<td>Ocupacion</td>
						<td><input type="text" id="p-oc"  size="20" name="p-oc"/></td>
					</tr>
					<tr>
						<td>Empresa donde Trabaja</td>
						<td><input type="text" id="p-et"  size="20" name="p-et"/></td>
					</tr>
					<tr>
						<td>Tipo de Seguro</td>
						<td><select id="p-ts" name="p-ts"></select></td>
					</tr>
					<tr>
						<td>Referido de:</td>
						<td><input type="text" id="p-rd"  size="20" name="p-rd"/></td>
					</tr>
					<tr>
						<td colspan="2">En caso necesario llamar a:</td>
					</tr>
					<tr>
						<td>Nombres</td>
						<td><input type="text" id="p-ec"  size="20" name="p-ec"/></td>
					</tr>
					<tr>
						<td>Parentesco-Afinidad</td>
						<td><input type="text" id="p-pa"  size="20" name="p-pa"/></td>
					</tr>
					<tr>
						<td>Direccion</td>
						<td><input type="text" id="p-di"  size="20" name="p-di"/></td>
					</tr>
					<tr>
						<td>No. Telefono</td>
						<td><input type="text" id="p-nt"  size="20" name="p-nt"/></td>
					</tr>
					<tr>
						<td>Admisionista</td>
						<td><input type="text" id="p-ad"  size="20" name="p-ad"/></td>
					</tr>
				</table>
			<!--</form>-->
		</div>
		<div id="frm001-guardada" name="frm001-guardada" style="display: none;">
			<span id="mensaje-guardado"></span>
		</div>
	<script src="assets/js/script-impresion.js"></script>
	</body>
</html>