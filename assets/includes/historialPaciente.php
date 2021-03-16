<!DOCTYPE html>
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
			<H1>Historial de Paciente</H1>
			<div id="busqueda" name="busqueda">
				<form action="assets/includes/buscaPaciente.php" method="POST">
					<table>
						<tr>
							<td>
								Historia Clinica:
							</td>
							<td>
								<input type="text" id="hcu" name="hcu" />
								<input type="button" id="enviarBusqueda" name ="enviarBusqueda" value="Buscar" />
							</td>
						</tr>
						<tr>
							<td>Paciente:</td>
							<td colspan="2"><input type="text" id="apellidos" name="apellidos" disabled="disabled" size="50"/></td>
							<td>N.A.:</td>
							<td colspan="2"><input type="text" id="na" name="na" disabled="disabled" size="10"/></td>
						</tr>
						<tr>
							<td>Observaciones:</td>
							<td colspan="3"><input type="text" id="observacion" name="observacion" disabled="disabled" size="60"/></td>
						</tr>
						<tr>
							<td>Telefono:</td>
							<td>
								<input type="text" id="telefono" name="telefono" disabled="disabled" size="10"/>
								Tarjetero:
								<input type="text" id="tarjetero" name="tarjetero" disabled="disabled" size="10"/>
							</td>
						</tr>
					</table>
				</form>
			</div>
			</br>
			<div id="resultado-busqueda" name="resultado-busqueda"></div>
			<div id="resultado-busqueda2" name="resultado-busqueda2"></div>
			<div id="resultado-busqueda3" name="resultado-busqueda3"></div>
		</div>
		<script src="assets/js/script-historialPaciente.js"></script>
	</body>
</html>
