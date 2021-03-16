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
			$edad = $_GET['edad'];
			$consulta = "SELECT * FROM tb_imc_edad WHERE imc_estado = 'A' ORDER BY imc_codigo";
			$resultado = mysql_query($consulta,$conexion);
			echo '<select id="e-estado-nutricional" name="a-estado-nutricional">';
			if($resultado)
			{
				while($row = mysql_fetch_assoc($resultado))
				{
					if(($edad>=$row['imc_edad_inicial'])&&($edad<=$row['imc_edad_final']))
					{
						echo "<option value='".$row['imc_codigo']."'>".$row['imc_descripcion']."</option>";
					}
				}				
			}
			else
			{
				echo "<option>Error de Conexion</option>";
			}
			echo '</select>';
			mysql_close($conexion);
		?>
	</body>
</html>