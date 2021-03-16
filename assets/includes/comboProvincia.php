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
				$codigo = $_GET['codigo'];
			}
			else
			{
				$codigo=0;
			}
			if($codigo==0)
			{
				$consulta = "SELECT * FROM tb_provincia WHERE pro_st = 'A' ORDER BY pro_descripcion";
			}
			else
			{
				$consulta = "SELECT * FROM tb_provincia WHERE pro_st = 'A' and cod_provincia=".$codigo." ;";
			}
			mysql_query("SET NAMES 'utf8'");
			$resultado = mysql_query($consulta,$conexion);
			
			echo '<select id="cmb-provincia" name="cmb-provincia">';
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
			echo '</select>';
			mysql_close($conexion);
		?>
	</body>
</html>