<?php
	include 'conexion.php';
	$conexion = conectar_bd();
	$conexion2 = conectar_bd();
	$res_existencia = array();
	if($_POST['tipo_trans']=="guarda")
	{
		$consulta = "SELECT * FROM tb_profesional WHERE pro_estado='A' AND pro_cedula='".$_POST['pro_cedula']."' LIMIT 1";
		$result = mysql_query($consulta,$conexion);
		$row = mysql_fetch_array($result);
		if($result)
		{
			if($row['pro_codigo']!=0)
			{
				$res_existencia = array(
					'codigo' => 1,
					'mensaje' => 'El numero de cedula ya existe, Verifique los datos'
				);
			}
			else
			{
				$res_existencia = array(
					'codigo' => 2,
					'mensaje' => 'Profesional no encontrado'
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
			$consulta = "SELECT * FROM tb_profesional WHERE pro_codigo=".$_POST['pro_codigo']."";
			mysql_query("SET NAMES 'utf8'");
			$result = mysql_query($consulta,$conexion);
			$row = mysql_fetch_array($result);
			if($result)
			{
				$res_existencia = array(
					'codigo' => 1,
					'mensaje' => 'Registro encontrado',
					'pro_codigo' => $row['pro_codigo'],
					'pro_cedula' => $row['pro_cedula'],
					'pro_apellidos'=> $row['pro_apellidos'],
					'pro_nombres' => $row['pro_nombres'], 
					'pro_fecha_nacimiento' => $row['pro_fecha_nacimiento'],
					'pro_especialidad' => $row['pro_especialidad'],
					'pro_observacion' => $row['pro_observacion'],
					'pro_pin' => $row['pro_pin'] 
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
				$consulta = "SELECT * FROM tb_profesional WHERE pro_estado='A' AND pro_cedula='".$_POST['pro_cedula']."' LIMIT 1";
				$result = mysql_query($consulta,$conexion);
				$row = mysql_fetch_array($result);
				if($result)
				{
					if(($row['pro_codigo']>0)&&($row['pro_codigo']!=$_POST['pro_codigo']))
					{
						$res_existencia = array(
							'codigo' => 1,
							'mensaje' => 'La Cedula ya existe, Verifique los datos'
						);
					}
					else
					{
						$res_existencia = array(
							'codigo' => 2,
							'mensaje' => 'Cedula no encontrada'
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
					$consulta = "INSERT INTO tb_profesional VALUES(NULL,"
								."'".$_POST['pro_cedula']."',"
								."'".$_POST['pro_apellidos']."',"
								."'".$_POST['pro_nombres']."',"
								."'".$_POST['pro_fecha_nacimiento']."',"
								."'".$_POST['pro_especialidad']."',"
								."'A','".$_POST['pro_observacion']."',"
								."".$_POST['pro_pin'].");";
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
						$consulta = "UPDATE tb_profesional SET "
							."pro_cedula = '".$_POST['pro_cedula']."',"
							."pro_apellidos = '".$_POST['pro_apellidos']."',"
							."pro_nombres = '".$_POST['pro_nombres']."',"
							."pro_fecha_nacimiento ='".$_POST['pro_fecha_nacimiento']."',"
							."pro_especialidad = ".$_POST['pro_especialidad'].","
							."pro_observacion = '".$_POST['pro_observacion']."',"
							."pro_pin = ".$_POST['pro_pin']." "
							."WHERE pro_codigo = ".$_POST['pro_codigo']."";
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
							$consulta = "UPDATE tb_profesional SET pro_estado = 'E'"
							." WHERE pro_codigo = ".$_POST['pro_codigo']."";
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
						else
						{
							if($_POST['tipo_trans']=="inactiva")
							{
								$consulta = "UPDATE tb_profesional SET pro_estado = 'I'"
								." WHERE pro_codigo = ".$_POST['pro_codigo']."";
								$resultado = mysql_query($consulta,$conexion);
								if(!$resultado)
								{
									$res_existencia = array(
										'codigo' => 0,
										'mensaje' => 'No se modifico el registro, no se pudo conectar con el servidor.'
									);
									die(mysql_error($resultado));
								}
								else
								{
									$res_existencia = array(
										'codigo' => 1,
										'mensaje' => 'Registro inactivado con exito'
									);
								}
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