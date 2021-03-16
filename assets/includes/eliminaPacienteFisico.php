<?php
	include("conexion.php");
	$conexion = conectar_bd();
	$res_existencia = array();
	$consulta = "UPDATE tb_admision SET adm_estado = 'E'"
				." WHERE cod_admision = ".$_POST['cod_admision']."";
	$resultado = mysql_query($consulta,$conexion);
	if(!$resultado)
	{
		$res_existencia = array(
			'codigo' => 0,
			'mensaje' => 'No se elimino el registro, no se pudo conectar con el servidor.'
		);
		die(mysql_error($resultado));
	}
	else
	{
		$res_existencia = array(
			'codigo' => 1,
			'mensaje' => 'Registro eliminado con exito'
		);
	}
	mysql_close($conexion);
	header("Content-Type: application/json");
	echo json_encode($res_existencia);
?>