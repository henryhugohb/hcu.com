<?php
	include 'conexion.php';
	$conexion = conectar_bd();
	$conexion2 = conectar_bd();
	$conexion3 = conectar_bd();
	$res_existencia = array();
	//$hcumsp = $_POST['hcumsp'];
	if($_POST['tipo_trans']=="guarda")
	{
		$consulta = "SELECT * FROM tb_agenda WHERE age_estado='A' AND age_fecha='".$_POST['fecha']."' AND age_locacion = '".$_POST['locacion']."' AND (age_hora_inicio = '".$_POST['hora_inicio']."' OR age_hora_fin = '".$_POST['hora_fin']."') LIMIT 1";
		$result = mysql_query($consulta,$conexion);
		$row = mysql_fetch_array($result);
		if($result)
		{
			if($row['age_codigo']!=0)
			{
				$res_existencia = array(
					'codigo' => 1,
					'mensaje' => 'La agenda para el consultorio ya existe, Verifique los datos'
				);
			}
			else
			{
				$res_existencia = array(
					'codigo' => 2,
					'mensaje' => 'Agenda no encontrada'
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
			$consulta = "SELECT * FROM tb_agenda WHERE age_estado='A' AND age_codigo=".$_POST['age_codigo']."";
			$result = mysql_query($consulta,$conexion);
			$row = mysql_fetch_array($result);
			if($result)
			{
				$res_existencia = array(
					'codigo' => 1,
					'mensaje' => 'Registro encontrado',
					'age_fecha' => $row['age_fecha'],
					'age_locacion'=> $row['age_locacion'],
					'age_profesional' => $row['age_profesional'], 
					'age_hora_inicio' => $row['age_hora_inicio'],
					'age_hora_fin' => $row['age_hora_fin'],
					'age_codigo' => $row['age_codigo'] 
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
				$consulta = "SELECT * FROM tb_agenda WHERE age_estado='A' AND age_fecha='".$_POST['fecha']."' AND age_locacion = '".$_POST['locacion']."' AND (age_hora_inicio = '".$_POST['hora_inicio']."' OR age_hora_fin = '".$_POST['hora_fin']."') LIMIT 1";
				$result = mysql_query($consulta,$conexion);
				$row = mysql_fetch_array($result);
				if($result)
				{
					if(($row['age_codigo']>0)&&($row['age_codigo']!=$_POST['age_codigo']))
					{
						$res_existencia = array(
							'codigo' => 1,
							'mensaje' => 'La agenda para el consultorio ya existe, Verifique los datos'
						);
					}
					else
					{
						$consulta = "SELECT * FROM tb_agenda WHERE age_estado='A' AND age_codigo = ".$_POST['age_codigo'].";";
						$resultado3 = mysql_query($consulta,$conexion3);
						$agend = mysql_fetch_array($resultado3);
						if($resultado3)
						{
							if(($agend['age_hora_inicio']==$_POST['hora_inicio'])&&($agend['age_hora_fin']==$_POST['hora_fin']))
							{
								$res_existencia = array(
									'codigo' => 3,
									'mensaje' => 'Cambiar solo profesional'
								);
							}
							else
							{
								$consulta2 = "SELECT * FROM tb_agendamiento WHERE age_estado='A' AND age_cod_agenda = ".$_POST['age_codigo']." AND age_estado_c = 'O';";
								$resultado2 = mysql_query($consulta2,$conexion2);
								if($resultado2)
								{
									$nreg=0;
									while ($conta = mysql_fetch_assoc($resultado2)) {
										$nreg = $nreg+1;
									}
									if($nreg>0)
									{
										$res_existencia = array(
											'codigo' => 1,
											'mensaje' => 'No se puede Modificar. Existen citas para esta agenda.'
										);	
									}
									else
									{
										$res_existencia = array(
											'codigo' => 2,
											'mensaje' => 'Agenda no encontrada'
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
						}
						else
						{
							$res_existencia = array(
								'codigo' => 0,
								'mensaje' => 'No se pudo establecer conexion con el servidor'
							);
						}
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
		}		
	}
	mysql_close($conexion);
	mysql_close($conexion2);
	mysql_close($conexion3);
	header('Content-Type: application/json');
    echo json_encode($res_existencia);
?>