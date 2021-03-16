<?php
	include("conexion.php");
	$conexion = conectar_bd();
	$conexion2 = conectar_bd();
	$res_existencia = array();
	if($_POST['tipo_trans']=="consulta-agenda")
	{
		$consulta = "SELECT * FROM tb_agenda WHERE age_estado='A' AND age_fecha='".$_POST['fecha']."'";
		$result = mysql_query($consulta,$conexion);
		$result1 = mysql_query($consulta,$conexion);
		if($result)
		{
			$row1 = mysql_fetch_array($result1);
			if($row1['age_codigo']>0)
			{
				$bdr=0;
				while ($row = mysql_fetch_assoc($result)) 
				{
					$ced_profesionales[$bdr] = $row['age_profesional'];
					$bdr=$bdr+1;
				}
				$res_existencia = array(
					'codigo' => 1,
					'mensaje' => 'Profesionales',
					'datos' => $ced_profesionales,
					'total' => $bdr
				);
			}
			else
			{
				$res_existencia = array(
					'codigo' => 2,
					'mensaje' => 'No existen datos que mostrar'
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
		if($_POST['tipo_trans']=="busca-paciente")
		{
			if($_POST['tipo_id']=="na")
			{	
				$consulta = "SELECT * FROM tb_admision WHERE adm_estado = 'A' AND adm_na = '".$_POST['nArchivo']."'";
			}
			else
			{
				$consulta = "SELECT * FROM tb_admision WHERE adm_estado = 'A' AND adm_hcu = '".$_POST['nArchivo']."'";
			}
			//mysql_query("SET NAMES 'utf8'");
			$result = mysql_query($consulta,$conexion);
			if($result)
			{
				$pacientes_e = 0;
				while($row = mysql_fetch_assoc($result))
				{
					$nombrescompletos = "".$row['adm_apellido']." ".$row['adm_nombre']."";
					$n_d_archivo = $row['adm_na'];
					$observa_pac = $row['adm_observacion'];
					$pacientes_e = $pacientes_e+1;
					if($row['adm_fecha_nacimiento']=='0000-00-00')
					{
						$edad_paciente = 0;	
					}
					else
					{
						$edad_paciente = calculadorEdad($row['adm_fecha_nacimiento']);	
					}
				}
				if($pacientes_e==1)
				{
					if($_POST['tipo_id']=="hcu")
					{
						$res_existencia = array(
							'codigo' => 1,
							'mensaje' => $nombrescompletos,
							'n_d_archivo' => $n_d_archivo,
							'observa_pac' => $observa_pac,
							'edad_paciente' => $edad_paciente
						);
					}
					else
					{
						$res_existencia = array(
							'codigo' => 1,
							'mensaje' => $nombrescompletos,
							'observa_pac' => $observa_pac,
							'edad_paciente' => $edad_paciente
						);	
					}
				}
				else
				{
					if($pacientes_e>1)
					{
						
						$res_existencia = array(
							'codigo' => 3,
							'mensaje' => 'El Numero esta duplicado '.$pacientes_e.' veces. Corrija y reintente.'
						);
					}
					else
					{
						$res_existencia = array(
							'codigo' => 2,
							'mensaje' => 'Numero no asignado'
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
		else
		{
			if($_POST['tipo_trans']=="modifica")
			{
				$consulta = "UPDATE tb_agendamiento SET "
							."age_narchivo = ".$_POST['age_narchivo'].","
							."age_nombres = '".$_POST['age_nombres']."',"
							."age_fecha = '".$_POST['age_fecha']."',"
							."age_hora ='".$_POST['age_hora']."',"
							."age_observacion ='".$_POST['age_observacion']."',"
							."age_vez = '".$_POST['age_vez']."', age_tipo='A', age_estado_c='O' "
							."WHERE age_codigo = ".$_POST['age_codigo']."";
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
					if($_POST['age_vez']=="S")
					{
						$consulta = "UPDATE tb_admision SET "
								."adm_fecha_cita_proxima = '".$_POST['age_fecha_de_cita']."'"
								." WHERE adm_na = ".$_POST['age_narchivo']."";
						$resultado2 = mysql_query($consulta,$conexion2);
						if(!$resultado2)
						{
							$res_existencia = array(
								'codigo' => 0,
								'mensaje' => 'No se actualizo el paciente, no se pudo conectar con el servidor.'
							);
							die(mysql_error($resultado2));
						}
						else
						{
							$res_existencia = array(
								'codigo' => 1,
								'mensaje' => 'Cita asignada con exito y Actualizada en admision'
							);
						}
					}
					else
					{
						$res_existencia = array(
							'codigo' => 1,
							'mensaje' => 'Cita asignada con exito'
						);
					}
				}
			}
			else
			{
				if($_POST['tipo_trans']=="elimina")
				{
					$consulta = "UPDATE tb_agenda SET age_estado = 'E'"
					." WHERE age_codigo = ".$_POST['age_codigo']."";
					$resultado = mysql_query($consulta,$conexion);
					if(!$resultado)
					{
						$resultado_ga = array(
							'codigo' => 0,
							'mensaje' => 'No se elimino el registro, no se pudo conectar con el servidor.'
						);
						die(mysql_error($resultado));
					}
					else
					{
						$resultado_ga = array(
							'codigo' => 1,
							'mensaje' => 'Registro eliminado con exito'
						);
					}
				}
				else
				{
					if($_POST['tipo_trans']=="busca-cita")
					{
						$consulta = "SELECT * FROM tb_agendamiento WHERE age_codigo = ".$_POST['age_codigo']."";
						mysql_query("SET NAMES 'utf8'");
						$result = mysql_query($consulta,$conexion);
						$row = mysql_fetch_array($result);
						if($result)
						{
							if($row['age_codigo']>0)
							{
								$res_existencia = array(
									'codigo' => 1,
									'mensaje' => 'Registro Encontrado',
									'age_hora_cita' => $row['age_hora_cita'],
									'age_narchivo' => $row['age_narchivo'],
									'age_nombres' => $row['age_nombres'],
									'age_estado_c' => $row['age_estado_c'],
									'age_observacion' => $row['age_observacion'],
									'fecha_server' => date("Y-m-d"),
									'hora_server' => date("H:i:s")
								);
							}
							else
							{
								$res_existencia = array(
									'codigo' => 2,
									'mensaje' => 'Numero no asignado'
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
						if($_POST['tipo_trans']=="elimina-c")
						{
							$consulta = "UPDATE tb_agendamiento SET "
										."age_narchivo = 0, age_nombres = '', age_fecha = '0000-00-00', age_fecha_c = '0000-00-00',"
										."age_hora ='00:00', age_hora_c ='00:00', age_vez = '', age_tipo='A', age_estado_c='L', age_observacion='' "
										."WHERE age_codigo = ".$_POST['age_codigo']."";
							$resultado = mysql_query($consulta,$conexion);
							if(!$resultado)
							{
								$res_existencia = array(
									'codigo' => 0,
									'mensaje' => 'No se pudo eliminar el registro, no se pudo conectar con el servidor.'
								);
								die(mysql_error($resultado));
							}
							else
							{
								$res_existencia = array(
									'codigo' => 1,
									'mensaje' => 'Cita eliminada con exito'
								);
							}
						}
						else
						{
							if($_POST['tipo_trans']=="busca-cita-paciente")
							{
								$citas_asignadas ="";
								$consulta = "SELECT * FROM tb_agenda WHERE age_estado='A' AND age_fecha>='".$_POST['age_fecha']."'";
								$resultado = mysql_query($consulta,$conexion);
								if($resultado)
								{
									$duplicados=0;
									while($agenda = mysql_fetch_assoc($resultado))
									{
										//echo $agenda['age_codigo']."\n";
										$consulta = "SELECT * FROM tb_agendamiento WHERE age_cod_agenda = ".$agenda['age_codigo']."";
										$resultado2 = mysql_query($consulta,$conexion2);
										if ($resultado2)
										{
											//$duplicados=0;
											while ($agendamiento = mysql_fetch_assoc($resultado2)) 
											{
												//echo $agendamiento['age_narchivo']."=".$_POST['age_narchivo']."\n";
												if(($agendamiento['age_narchivo'] == $_POST['age_narchivo'])&&($agendamiento['age_codigo']!=$_POST['age_codigo']))
												{
													//echo "Entre ".$duplicados."";
													if($duplicados == 0)
													{
														$citas_asignadas = "\n".$agenda['age_fecha']."-".$agendamiento['age_hora_cita']."-CONSULTORIO ".$agenda['age_locacion']."\n";
														$duplicados=$duplicados+1;
													}
													else
													{
														$citas_asignadas = $citas_asignadas.",".$agenda['age_fecha']."-".$agendamiento['age_hora_cita']."-CONSULTORIO ".$agenda['age_locacion']."\n";
														$duplicados=$duplicados+1;
													}
												}
											}
											if($duplicados==0)
											{
											   $res_existencia = array(
													'codigo' => 0,
													'mensaje' => "No existen datos que mostrar."
												);
											}
											else
											{
												$res_existencia = array(
													'codigo' => 1,
													'mensaje' => $citas_asignadas
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
							}
							else
							{
								if($_POST['tipo_trans']=="confirma-c")
								{
									$consulta = "UPDATE tb_agendamiento SET "
												."age_fecha_c = '".$_POST['age_fecha_c']."',"
												."age_hora_c = '".$_POST['age_hora_c']."',"
												."age_estado_c = 'C' "
												."WHERE age_codigo = ".$_POST['age_codigo']."";
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
											'mensaje' => 'Cita confirmada con exito'
										);
									}
								}
								else
								{
									if($_POST['tipo_trans']=="busca-s")
									{
										$consulta = "SELECT * FROM tb_sobreagenda WHERE sob_estado_s='P' "
													."AND sob_profesional = '".$_POST['sob_profesional']
													."' AND sob_fecha = '".$_POST['sob_fecha']."'";
										$result = mysql_query($consulta,$conexion);
										if($result)
										{
											if(mysql_num_rows($result)>0)
											{
												$res_existencia = array(
													'codigo' => 1,
													'mensaje' => 'Registro Encontrado'
												);
											}
											else
											{
												$res_existencia = array(
													'codigo' => 2,
													'mensaje' => 'Numero no asignado'
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
										if($_POST['tipo_trans']=="atiende-s")
										{
											$consulta = "UPDATE tb_sobreagenda SET "
														."sob_estado_s = 'A' "
														."WHERE sob_codigo = ".$_POST['sob_codigo']."";
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
													'mensaje' => 'Cita atendida con exito'
												);
											}
										}
									}
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
	header("Content-Type: application/json");
	echo json_encode($res_existencia);
?>