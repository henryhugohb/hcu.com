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
				$consulta = "SELECT * FROM tb_parroquia WHERE par_st = 'A' and cod_parroquia=".$_GET['codigo']." ;";
			}
			else
			{
				if(isset($_GET['canton']))
				{
					$consulta = "SELECT * FROM tb_parroquia WHERE par_st = 'A' and par_canton=".$_GET['canton']." ;";
				}
				else
				{
					$consulta = "SELECT * FROM tb_parroquia WHERE par_st = 'A' ORDER BY par_descripcion";
				}
			}
			mysql_query("SET NAMES 'utf8'");
			$resultado = mysql_query($consulta,$conexion);
			//echo '<select id="cmb-parroquia" name="cmb-parroquia" style="width: 150px;">';
			if($resultado)
			{
				while($row=mysql_fetch_assoc($resultado))
				{
					echo "<option value='".$row['cod_parroquia']."'>".$row['par_descripcion']."</option>";
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