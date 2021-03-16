<?php
	include('conexion.php');
 	$conexion = conectar_bd();
 	$respuesta = array();
 	if(isset($_POST['institucion']) && !empty($_POST['institucion']))
 	{
 		$consulta = "SELECT * FROM tb_institucion WHERE ins_cod_msp = ".$_POST['institucion']."";
 		$resultado = mysql_query($consulta,$conexion);
 		$row = mysql_fetch_array($resultado);
 		if($row['ins_cod_msp']==$_POST['institucion'])
 		{
 			$respuesta  = array(
 				'codigo' => 1,
 				'mensaje' => 'Institucion Encontrada',
 				'data' => $row

 			);
 		}
 		else
 		{
 			$respuesta = array(
 				'codigo' => 0,
 				'mensaje' => 'la Institucion No se encuentra autorizada.\nContacte a su proveedor del servicio.'
 			);
 		}
 	}
 	else
	{
		$respuesta = array(
			'codigo' => 0,
			'mensaje' => 'No se especifico la unidad operativa.'
		);
	}
	mysql_close($conexion);
	header('Content-Type: application/json');
	echo json_encode($respuesta);
?>