<?php
	include 'conexion.php';
	$conexion = conectar_bd();
	$res_proceso = array();
	$consulta = "SELECT adm_na FROM tb_admision WHERE adm_estado ='A' ORDER BY adm_na DESC LIMIT 1";
	$resultado = mysql_query($consulta,$conexion);
	$row = mysql_fetch_array($resultado);
	if($row['adm_na']!="")
	{
		$res_proceso = array(
			'codigo' => 1,
			'mensaje' => 'Se encontro ultimo registro',
			'contenido' => ($row['adm_na'] + 1)
		);
	}
	else
	{
		$res_proceso = array(
			'codigo' => 0,
			'mensaje' => 'No se encontraron registros',
			'contenido' => 1
		);	
	}
	mysql_close($conexion);
	header('Content-Type: application/json');
    echo json_encode($res_proceso);
?> 