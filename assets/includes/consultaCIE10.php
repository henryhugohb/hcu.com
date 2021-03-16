<?php
	include 'conexion.php';
	$conexion = conectar_bd();
	$conexion2 = conectar_bd();
	$res_existencia = array();
	if (isset($_POST["cie_cie"]) && !empty($_POST["cie_cie"]))
	{
		$cie_cie = $_POST['cie_cie'];
		$consulta = "SELECT * FROM tb_cie10 WHERE cie_cie10 like '".$cie_cie."%' ;";
		//echo $consulta;
		$result = mysql_query($consulta,$conexion);
		if($result)
		{
			$nbdr=0;
			while($row = mysql_fetch_assoc($result))
			{
				$descripcion_cie = utf8_encode($row['cie_descripcion']);
				$res_existencia = array(
					'codigo' => 1,
					'mensaje' => 'Registro encontrado',
					'cie_descripcion' => $descripcion_cie,
					'cie_sexo' => $row['cie_sexo'],
					'cie_edad_min' => $row['cie_edad_min'],
					'cie_edad_max' => $row['cie_edad_max']
				);
				$nbdr=$nbdr+1;
			}
			if($nbdr==0)
			{
				$res_existencia = array(
					'codigo' => 2,
					'mensaje' => 'No existe el codigo ingresado, Corrija y reintente.'
				);
			}
			else
			{
				if($nbdr>1)
				{
					$res_existencia = array(
						'codigo' => 3,
						'mensaje' => 'Existen '.$nbdr.' registros con ese numero, Especifique el codigo completo del diagnostico.'
					);
				}	
			}
		}
		else
		{
			$res_existencia = array(
				'codigo' => 2,
				'mensaje' => 'Error en la consulta, Corrija y reintente.'
			);
		}
	}
	else
	{
		$res_existencia = array(
			'codigo' => 0,
			'mensaje' => 'No se envio datos en la consulta'
		);
	}
	mysql_close($conexion);
	mysql_close($conexion2);
	header('Content-Type: application/json');
    echo json_encode($res_existencia);
?>