<?php
	include 'conexion.php';
	$conexion = conectar_bd();
	$conexion2 = conectar_bd();
	$res_existencia = array();
	if (isset($_POST["adm_na"]) && !empty($_POST["adm_na"]))
	{
		$adm_na = $_POST['adm_na'];
		$consulta = "SELECT * FROM tb_admision WHERE adm_estado='A' AND adm_na=".$adm_na.";";
		$result = mysql_query($consulta,$conexion);
		if($result)
		{
			$nbdr=0;
			while($row = mysql_fetch_assoc($result))
			{
				$consulta = "SELECT * FROM tb_tarjetero WHERE tar_estado='A' AND tar_hcu='".$row['adm_hcu']."';";
				$result2 = mysql_query($consulta,$conexion2);
				if(!$result2)
				{
					$res_existencia = array(
						'codigo' => 0,
						'mensaje' => 'No se pudo conectar con el servidor, error de conexion'
					);
				}
				else
				{
					if(mysql_num_rows($result2)==0)
					{
						$res_existencia = array(
							'codigo' => 1,
							'mensaje' => 'El Numero de Historia clinica ya existe, Verifique el archivo en fisico',
							'adm_na' => $row['adm_na'],
							'adm_fecha_admision' => $row['adm_fecha_admision'],
							'adm_apellido' => $row['adm_apellido'],
							'adm_nombre' => $row['adm_nombre'],
							'adm_hcu' => $row['adm_hcu'],
							'adm_fecha_nacimiento' => $row['adm_fecha_nacimiento'],
							'adm_sexo' => $row['adm_sexo'],
							'adm_fecha_cita_ultima' => $row['adm_fecha_cita_ultima'],
							'adm_fecha_cita_proxima' => $row['adm_fecha_cita_proxima'],
							'adm_observacion' => $row['adm_observacion'],
							'adm_estado' => $row['adm_estado']
						);
					}
					else
					{
						
						$row2 = mysql_fetch_array($result2);
						//echo "se toma de la tabla tarjetero: ".$row2['tar_apaterno']."\n";
						$res_existencia = array(
							'codigo' => 5,
							'mensaje' => 'El Numero de Historia clinica ya existe. Verifique el archivo en fisico',
							'adm_fecha_admision' => $row['adm_fecha_admision'],
							'adm_hcu' => $row['adm_hcu'],
							'adm_fecha_nacimiento' => $row['adm_fecha_nacimiento'],
							'adm_sexo' => $row['adm_sexo'],
							'adm_fecha_cita_ultima' => $row['adm_fecha_cita_ultima'],
							'adm_fecha_cita_proxima' => $row['adm_fecha_cita_proxima'],
							'adm_observacion' => $row['adm_observacion'],
							'adm_estado' => $row['adm_estado'],
							/********datos de tarjetero********/
							'adm_apellido' => $row2['tar_apaterno'],
							'tar_amaterno' => $row2['tar_amaterno'],
							'adm_nombre' => $row2['tar_nombre1'],
							'tar_nombre2' => $row2['tar_nombre2'],
							'tar_nombrepadre' => $row2['tar_nombrepadre'],
							'tar_nombremadre' => $row2['tar_nombremadre'],
							'tar_telefono' => $row2['tar_telefono'],
							'tar_representante' => $row2['tar_representante'],
							'tar_cedrepresentante' => $row2['tar_cedrepresentante']
						);
					}
				}
				$nbdr=$nbdr+1;
			}
			if($nbdr==0)
			{
				$res_existencia = array(
					'codigo' => 2,
					'mensaje' => 'No existe el numero de archivo, Corrija y reintente.'
				);
			}
			else
			{
				
				if($nbdr>1)
				{
					$res_existencia = array(
						'codigo' => 3,
						'mensaje' => 'Existen '.$nbdr.' registros con ese numero, Consulte a su administrador de sistema.'
					);
				}
				/*else
				{
					echo "se encontro 1\n";
				}*/	
			}
		}
		else
		{
			$res_existencia = array(
				'codigo' => 2,
				'mensaje' => 'No existe el numero de archivo, Corrija y reintente.'
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