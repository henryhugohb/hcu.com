<?php
	include("conexion.php");
	$conexion = conectar_bd();
	$consulta = "SELECT * FROM ".$_GET['tabla'].'';
	if($_GET['param_1']!='0')
	{
		$consulta = $consulta.' WHERE '.$_GET['campo_1'].' LIKE "'.$_GET['param_1'].'%"';
	}
	if($_GET['param_2']!='0')
	{
		if($_GET['param_1']!='0')
		{
			$consulta = $consulta.' AND '.$_GET['campo_2'].' LIKE "'.$_GET['param_2'].'%"';
		}
		else
		{
			$consulta = $consulta.' WHERE '.$_GET['campo_2'].' LIKE "'.$_GET['param_2'].'%"';
		}
	}
	$resultado = mysql_query($consulta,$conexion);
	while ($row = mysql_fetch_assoc($resultado))
	{
		echo "<option value='".$row[$_GET['campo_1']]."'>".$row[$_GET['campo_2']]."</option>";
	}
	mysql_close($conexion);
?>