<?php
	include 'conexion.php';
	$conexion = conectar_bd();
	$conexion2 = conectar_bd();
	$res_existencia = array();
	if($_POST['tipo_trans']=="guarda")
	{
		$consulta = "SELECT * FROM tb_locacion WHERE loc_estado='A' AND loc_descripcion='".$_POST['loc_descripcion']."' LIMIT 1";
		$result = mysql_query($consulta,$conexion);
		$row = mysql_fetch_array($result);
		if($result)
		{
			if($row['loc_codigo']!=0)
			{
				$res_existencia = array(
					'codigo' => 1,
					'mensaje' => 'La descripcion del consultorio ya existe, Verifique los datos'
				);
			}
			else
			{
				$res_existencia = array(
					'codigo' => 2,
					'mensaje' => 'Consultorio no encontrado'
				);		
			}
		}
		else
		{
			$res_existencia = array(
				'codigo' => 0,
				'mensaje' => 'No se pudo establecer conexion con el servidor'
			);
		}
	}
	else
	{
		if($_POST['tipo_trans']=="consulta")
		{
			$consulta = "SELECT * FROM tb_locacion WHERE loc_codigo=".$_POST['loc_codigo']."";
			mysql_query("SET NAMES 'utf8'");
			$result = mysql_query($consulta,$conexion);
			$row = mysql_fetch_array($result);
			if($result)
			{
				$res_existencia = array(
					'codigo' => 1,
					'mensaje' => 'Registro encontrado',
					'loc_codigo' => $row['loc_codigo'],
					'loc_descripcion' => $row['loc_descripcion'],
					'loc_observacion' => $row['loc_observacion'] 
				);
			}
			else
			{
				$res_existencia = array(
					'codigo' => 0,
					'mensaje' => 'No se pudo establecer conexion con el servidor'
				);
			}
		}
		else
		{
			if($_POST['tipo_trans']=="modifica")
			{
				$consulta = "SELECT * FROM tb_locacion WHERE loc_estado='A' AND loc_descripcion='".$_POST['loc_descripcion']."' LIMIT 1";
				$result = mysql_query($consulta,$conexion);
				$row = mysql_fetch_array($result);
				if($result)
				{
					if(($row['loc_codigo']>0)&&($row['loc_codigo']!=$_POST['loc_codigo']))
					{
						$res_existencia = array(
							'codigo' => 1,
							'mensaje' => 'El consultorio ya existe, Verifique los datos'
						);
					}
					else
					{
						$res_existencia = array(
							'codigo' => 2,
							'mensaje' => 'Consultorio no encontrado'
						);
					}
				}
				else
				{
					$res_existencia = array(
						'codigo' => 0,
						'mensaje' => 'No se pudo establecer conexion con el servidor'
					);
				}
			}
			else
			{
				if($_POST['tipo_trans']=="guarda-p")
				{
					$consulta = "INSERT INTO tb_locacion VALUES(NULL,"
								."'".$_POST['loc_descripcion']."',"
								."1,'A','".$_POST['loc_observacion']."');";
					$resultado = mysql_query($consulta,$conexion);
					if(!$resultado)
					{
						$res_existencia = array(
							'codigo' => 0,
							'mensaje' => 'No se guardo el registro, no se pudo conectar con el servidor'
						);
						die(mysql_error($resultado));
					}
					else
					{
						$res_existencia = array(
							'codigo' => 1,
							'mensaje' => 'Registro Guardado con exito.'
						);
					}
				}
				else
				{
					if($_POST['tipo_trans']=="modifica-p")
					{
						$consulta = "UPDATE tb_locacion SET "
							."loc_descripcion = '".$_POST['loc_descripcion']."',"
							."loc_observacion = '".$_POST['loc_observacion']."' "
							."WHERE loc_codigo = ".$_POST['loc_codigo']."";
						$resultado = mysql_query($consulta,$conexion);
						if(!$resultado)
						{
							$res_existencia = array(
								'codigo' => 0,
								'mensaje' => 'No se actualizo el registro, no se pudo conectar con el servidor.'
							);
							die(mysql_error($resultado));
						}
						else
						{
							$res_existencia = array(
								'codigo' => 1,
								'mensaje' => 'Registro Actualizado con exito'
							);
						}
					}
					else
					{
						if($_POST['tipo_trans']=="elimina")
						{
							$consulta = "UPDATE tb_locacion SET loc_estado = 'E'"
							." WHERE loc_codigo = ".$_POST['loc_codigo']."";
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
						}
					}
				}
			}
		}		
	}
	mysql_close($conexion);
	mysql_close($conexion2);
	header('Content-Type: application/json');
    echo json_encode($res_existencia);
?>