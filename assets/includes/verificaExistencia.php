<?php
	include 'conexion.php';
	$conexion = conectar_bd();
	$res_existencia = array();
	if (isset($_POST["hcumsp"]) && !empty($_POST["hcumsp"]))
	{
		$hcumsp = $_POST['hcumsp'];
		$consulta = "SELECT * FROM tb_admision WHERE adm_estado='A' AND adm_hcu='".$hcumsp."' LIMIT 1";
		$result = mysql_query($consulta,$conexion);
		$row = mysql_fetch_array($result);
		if($row['adm_hcu']==$hcumsp)
		{
			$res_existencia = array(
				'codigo' => 1,
				'mensaje' => 'El Numero de Historia clinica ya existe, Verifique el archivo en fisico',
				'data' => $row['adm_na']
			);
		}
		else
		{
			$res_existencia = array(
				'codigo' => 2,
				'mensaje' => 'Se debe Generar Un nuevo numero de archivo'
			);
		}
	}
	else
	{
		$res_existencia = array(
			'codigo' => 0,
			'mensaje' => 'No existen datos en las variables'
		);
	}
	mysql_close($conexion);
	header('Content-Type: application/json');
    echo json_encode($res_existencia);
?>