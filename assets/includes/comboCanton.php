<!DOCTYPE html>
<html>
	<head>
		<script src="assets/js/jquery-1.11.2.min.js"></script>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
	</head>
	<body>
		<?php
			include("conexion.php");
			$conexion = conectar_bd();
			if(isset($_GET['codigo']))
			{
				$consulta = "SELECT * FROM tb_canton WHERE can_st = 'A' and cod_canton=".$_GET['codigo']." ;";
			}
			else
			{
				if(isset($_GET['provincia']))
				{
					$consulta = "SELECT * FROM tb_canton WHERE can_st = 'A' and can_provincia=".$_GET['provincia']." ;";
				}
				else
				{
					$consulta = "SELECT * FROM tb_canton WHERE can_st = 'A' ORDER BY can_descripcion";
				}
			}
			mysql_query("SET NAMES 'utf8'");
			$resultado = mysql_query($consulta,$conexion);
			//echo '<select id="cmb-canton" name="cmb-canton" style="width: 150px;">';
			if($resultado)
			{
				while($row=mysql_fetch_assoc($resultado))
				{
					echo "<option value='".$row['cod_canton']."'>".$row['can_descripcion']."</option>";
				}
			}
			else
			{
				echo "<option>Error de Conexion</option>";
			}
			//echo '</select>';
			mysql_close($conexion);
		?>
	</body>
</html>