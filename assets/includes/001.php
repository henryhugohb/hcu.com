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
?>
<html>
	<head>
		<!--<script src="assets/js/jquery-1.11.2.min.js"></script>-->
		<!--<link rel="stylesheet" type="text/css" href="assets/css/estilo1.css">-->
		<script src="../js/jquery-1.11.2.min.js"></script>
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
						<td colspan="2">Unidad Operativa</td>
						<td>Cod U.O.</td>
						<td>Parroquia</td>
						<td>Canton</td>
						<td>Provincia</td>
						<td>Numero de Archivo</td>
					</tr>
					<tr>
						<td><input type="text" id="i-is"  size="10" name="i-is" readonly="readonly" /></td>
						<td colspan="2"><input type="text" id="i-uo"  size="22" name="i-uo" readonly="readonly" /></td>
						<td><input type="text" id="i-cu"  size="5" name="i-cu" readonly="readonly" /></td>
						<td><input type="text" id="i-pa"  size="5" name="i-pa" readonly="readonly" /></td>
						<td><input type="text" id="i-ca"  size="5" name="i-ca" readonly="readonly" /></td>
						<td><input type="text" id="i-pr"  size="5" name="i-pr" readonly="readonly" /></td>
						<td><input type="text" id="i-na"  size="8" name="i-na" readonly="readonly" /></td>
					</tr>
					<tr>
						<td colspan="8">1 REGISTRO DE PRIMERA ADMISION</td>
					</tr>
					<tr>
						<td colspan="3">Apellidos</td>
						<td colspan="3">Nombres</td>
						<td colspan="2">Historia Clinica Unica</td>
					</tr>
					<tr>
						<td colspan="3"><input type="text" id="p-ap"  size="30" name="p-ap" readonly="readonly" /></td>
						<td colspan="3"><input type="text" id="p-no"  size="30" name="p-no" readonly="readonly" /></td>
						<td colspan="2"><input type="text" id="p-hc"  size="18" name="p-hc" readonly="readonly" /></td>
					</tr>
					<tr>
						<td colspan="2">Calle y No. Manzana y Casa</td>
						<td>Barrio</td>
						<td>Parroquia</td>
						<td>Canton</td>
						<td>Provincia</td>
						<td>Zona (U/R)</td>
						<td>Telefono</td>
					</tr>
					<tr>
						<td colspan="2"><input type="text" id="p-cm"  size="25" name="p-cm"/></td>
						<td><input type="text" id="p-ba"  size="8" name="p-ba"/></td>
						<td><select id="p-pa" name="p-pa" widh="2px" onchange="this.style.width=50"></select></td>
						<td><select id="p-ca" name="p-ca" widh="2px"></select></td>						
						<td><select id="p-pr" name="p-pr" widh="2px"></select></td>
						<td><input type="text" id="p-zo"  size="5" name="p-zo"/></td>
						<td><input type="text" id="p-te"  size="8" name="p-te"/></td>
					</tr>
					<tr>
						<td>Fecha Nacimiento</td>
						<td>Lugar Nacimiento</td>
						<td>Nacionalidad</td>
						<td>Grupo Cultural</td>
						<td>Edad</td>
						<td>Sexo</td>
						<td>Estado Civil</td>
						<td>Instruccion</td>
					</tr>
					<tr>
						<td><input type="text" id="p-fn"  size="8" name="p-fn" readonly="readonly" /></td>
						<td><select id="p-ln" name="p-ln" widh="2px"></select></td>
						<td><input type="text" id="p-na"  size="8" name="p-na"/></td>
						<td><input type="text" id="p-gc"  size="10" name="p-gc"/></td>
						<td><input type="text" id="p-ed"  size="5" name="p-ed"/></td>
						<td><input type="text" id="p-se"  size="5" name="p-se" readonly="readonly" /></td>
						<td><input type="text" id="p-ec"  size="5" name="p-ec"/></td>
						<td><input type="text" id="p-in"  size="8" name="p-in"/></td>
					</tr>
					<tr>
						<td>Fecha Admision</td>
						<td colspan="2">Ocupacion</td>
						<td colspan="2">Empresa donde Trabaja</td>
						<td>Tipo de Seguro</td>
						<td colspan="2">Referido de:</td>
					</tr>
					<tr>
						<td><input type="text" id="p-fa"  size="10" name="p-fa" readonly="readonly" /></td>
						<td colspan="2"><input type="text" id="p-oc"  size="10" name="p-oc"/></td>
						<td colspan="2"><input type="text" id="p-et"  size="10" name="p-et"/></td>
						<td><input type="text" id="p-ts"  size="5" name="p-ts"/></td>
						<td colspan="2"><input type="text" id="p-rd"  size="10" name="p-rd"/></td>
					</tr>
					<tr>
						<td colspan="2">En caso necesario llamar a:</td>
						<td>Parentesco-Afinidad</td>
						<td colspan="4">Direccion</td>
						<td>No. Telefono</td>
					</tr>
					<tr>
						<td colspan="2"><input type="text" id="p-ec"  size="25" name="p-ec"/></td>
						<td><input type="text" id="p-pa"  size="8" name="p-pa"/></td>
						<td colspan="4"><input type="text" id="p-di"  size="40" name="p-di"/></td>
						<td><input type="text" id="p-nt"  size="8" name="p-nt"/></td>
					</tr>
					<tr>
						<td colspan="7"></td>
						<td>Admisionista</td>
					</tr>
					<tr>
						<td colspan="7"></td>
						<td><input type="text" id="p-ad"  size="8" name="p-ad"/></td>
					</tr>
				</table>
			<!--</form>-->
		</div>
		<div id="frm001-guardada" name="frm001-guardada" style="display: none;">
			<span id="mensaje-guardado"></span>
		</div>		
	<!---<script src="assets/js/script-impresion.js"></script>-->
	<script src="../js/script-impresion.js"></script>
	</body>
</html>