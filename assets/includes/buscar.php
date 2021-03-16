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
			<H1>Busqueda de Paciente</H1>
			<div id="busqueda" name="busqueda">
				<form action="assets/includes/buscaPaciente.php" method="POST">
					<table>
						<tr>
							<td>
								<input type="radio" id="b-hcu" name="t-busqueda" value="hcu" checked/>Historia Clinica:
							</td>
							<td><input type="text" id="hcu" name="hcu" /></td>
							<td>
							</td>
							<td>
							</td>
						</tr>
						<tr>
							<td>
								<input type="radio" id="b-apellidos" name="t-busqueda" value="apellidos"/>Apellidos:
							</td>
							<td><input type="text" id="apellidos" name="apellidos" /></td>
							<td><label id="lnombres" name="lnombres">Nombres:</label></td>
							<td><input type="text" id="nombres" name="nombres" /></td>
						</tr>
						<tr>
							<td>
								<input type="radio" id="b-na" name="t-busqueda" value="na"/>Numero de Archivo:
							</td>
							<td><input type="text" id="nArchivo" name="nArchivo" /></td>
							<td>
							</td>
							<td>
							</td>
						</tr>
						<tr>
						</tr>
						<tr>
							<td>
							</td>
							<td>
								<fieldset>
									<table>
										<tr>
											<td>
												<input type="radio" id="t-activos" name="t-resultado" value="activos" checked/>Activos
											</td>
											<td>
												<input type="radio" id="t-pasivos" name="t-resultado" value="pasivos"/>Pasivos
											</td>
											<td>
												<input type="radio" id="t-todos" name="t-resultado" value="todos"/>Todos
											</td>
											<td>
											</td>
											<td>
												<input type="button" id="enviarBusqueda" name ="enviarBusqueda" value="Buscar" />
											</td>
										</tr>
									</table>
								</fieldset>
							</td>
						</tr>
						<tr>
							<td>
							</td>
							<td>
								
							</td>
						</tr>
						<!--
							<tr>
								<td class="items"><label id="lhcu" name="lhcu">Historia Clinica:</label></td>
								<td><input type="text" id="hcu" name="hcu" /></td>
							</tr>
							<tr>
								<td class="items"><label id="lnombres" name="lnombres">Nombres:</label></td>
								<td><input type="text" id="nombres" name="nombres" /></td>
								<td><label id="lapellidos" name="lapellidos">Apellidos:</label></td>
								<td><input type="text" id="apellidos" name="apellidos" /></td>
							</tr>
							<tr>
								<td class="items"><label id="lnArchivo" name="lnArchivo">Numero de Archivo:</label></td>
								<td><input type="text" id="nArchivo" name="nArchivo" /></td>
							</tr>
							<tr>
								<td colspam="2">
									<input type="button" id="enviarBusqueda" name ="enviarBusqueda" value="Buscar" />
								</td>
							</tr>
						-->
					</table>
				</form>
			</div>
			<div id="resultado-busqueda" name="resultado-busqueda"></div>
		</div>
		<script src="assets/js/script-busqueda.js"></script>
	</body>
</html>
