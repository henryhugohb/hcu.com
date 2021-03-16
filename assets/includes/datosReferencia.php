<?php
	include("conexion.php");
	$conexion = conectar_bd();
	$conexion2 = conectar_bd();
	$conexion3 = conectar_bd();
	$resultado_ga = array();
	if($_POST['tipo_trans']=="guarda")
	{
		$consulta = "INSERT INTO tb_matriz_referencia "
					."(ref_codigo,ref_fecha,ref_cedula_paciente,ref_telefono,ref_cedula_profesional,ref_unidad_refiere,ref_especialidad_referida,ref_unidad_referida,ref_tipo_servicio,ref_cie10,ref_diagnostico,ref_condicion_diagnostico,ref_fecha_cita,ref_hora_cita,ref_especialista_nombre,ref_edad,ref_sexo,ref_estado_ref,ref_estado)"
					." VALUES(NULL,"
					."'".date("Y-m-d")."',"
					."'".$_POST['ref_cedula_paciente']."',"
					."'".$_POST['ref_telefono']."',"
					."'".$_POST['ref_cedula_profesional']."',"
					."".$_POST['ref_unidad_refiere'].","
					."".$_POST['ref_especialidad_referida'].","
					."".$_POST['ref_unidad_referida'].","
					."'".$_POST['ref_tipo_servicio']."',"
					."'".$_POST['ref_cie10']."',"
					."'".utf8_decode($_POST['ref_diagnostico'])."',"
					."'".$_POST['ref_condicion_diagnostico']."',"
					."".$_POST['ref_fecha_cita'].","
					."".$_POST['ref_hora_cita'].","
					."".$_POST['ref_medico_cita'].","
					."".$_POST['ref_edad'].","
					."'".$_POST['ref_sexo']."',"
					."'R','A');";
		//echo $consulta."\n";
		$resultado = mysql_query($consulta,$conexion);
		if(!$resultado)
		{
			$resultado_ga = array(
				'codigo' => 0,
				'mensaje' => 'No se guardo el registro, no se pudo conectar con el servidor'
			);
			die(mysql_error($resultado));
		}
		else
		{
			$consulta = "INSERT INTO tb_registro001 (reg_codigo,reg_cedula,reg_provincia,reg_canton,reg_parroquia,reg_barrio,reg_direccion,reg_estado) VALUES(NULL,"
						."'".$_POST['ref_cedula_paciente']."',"
						."".$_POST['reg_provincia'].","
						."".$_POST['reg_canton'].","
						."".$_POST['reg_parroquia'].","
						."'".$_POST['reg_barrio']."',"
						."'".$_POST['reg_direccion']."',"
						."'A');";
			$resultado3 = mysql_query($consulta,$conexion3);
			if(!$resultado3)
			{
				$resultado_ga = array(
					'codigo' => 0,
					'mensaje' => 'Registro guardado con exito, sin registro 001.'
				);
				die(mysql_error($resultado3));
			}
			else
			{
				$resultado_ga = array(
					'codigo' => 1,
					'mensaje' => 'Registro Guardado con exito.'
				);
			}
		}
	}
	else
	{
		if($_POST['tipo_trans']=="mesReferencia")
		{
			$consulta = "SELECT * FROM tb_matriz_referencia "
				."WHERE ref_cedula_profesional = '".$_POST['ref_profesional']."' "
				."AND ref_fecha LIKE '".$_POST['ref_anio']."-%' ORDER BY ref_fecha DESC;";
			$resultado = mysql_query($consulta,$conexion);
			if(!$resultado)
			{
				$resultado_ga = array(
					'codigo' => 0,
					'mensaje' => '<option value="*">No se actualizo el registro, no se pudo conectar con el servidor.</option>'
				);
				die(mysql_error($resultado));
			}
			else
			{
				$bdr=0;
				$mes="";
				$mes_actual="";
				$mesesref="";
				while ($row = mysql_fetch_assoc($resultado)) 
				{
					$mes_corriente = $row['ref_fecha'];
					$longitud = strlen($mes_corriente);
					$mes = "".$mes_corriente[5].$mes_corriente[6]."";
					if($mes_actual!=$mes)
					{
						$mesesref=$mesesref."<option value=".$mes.">".$mes."</option>";
						$bdr=$bdr+1;
						$mes_actual=$mes;
					}
					$resultado_ga = array(
						'codigo' => 1,
						'mensaje' => $mesesref
					);
				}
				if($bdr==0)
				{
					$resultado_ga = array(
						'codigo' => 2,
						'mensaje' => '<option value="*">No existen registros</option>'
					);
				}
			}
		}
		else
		{
			if($_POST['tipo_trans']=="mesReferenciaTotal")
			{
				$consulta = "SELECT * FROM tb_matriz_referencia "
					."WHERE ref_fecha LIKE '".$_POST['ref_anio']."-%' ORDER BY ref_fecha DESC;";
				$resultado = mysql_query($consulta,$conexion);
				if(!$resultado)
				{
					$resultado_ga = array(
						'codigo' => 0,
						'mensaje' => '<option value="*">No se actualizo el registro, no se pudo conectar con el servidor.</option>'
					);
					die(mysql_error($resultado));
				}
				else
				{
					$bdr=0;
					$mes="";
					$mes_actual="";
					$mesesref="";
					while ($row = mysql_fetch_assoc($resultado)) 
					{
						$mes_corriente = $row['ref_fecha'];
						$longitud = strlen($mes_corriente);
						$mes = "".$mes_corriente[5].$mes_corriente[6]."";
						if($mes_actual!=$mes)
						{
							$mesesref=$mesesref."<option value=".$mes.">".$mes."</option>";
							$bdr=$bdr+1;
							$mes_actual=$mes;
						}
						$resultado_ga = array(
							'codigo' => 1,
							'mensaje' => $mesesref
						);
					}
					if($bdr==0)
					{
						$resultado_ga = array(
							'codigo' => 2,
							'mensaje' => '<option value="*">No existen registros</option>'
						);
					}
				}
			}
			else
			{
				if($_POST['tipo_trans']=="eliminaReferencia")
				{
					$consulta = "UPDATE tb_matriz_referencia SET ref_estado = 'E'"
					." WHERE ref_codigo = ".$_POST['ref_codigo']."";
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
						$consulta = "SELECT * FROM tb_matriz_referencia WHERE ref_codigo=".$_POST['ref_codigo']."";
						$resultado2 = mysql_query($consulta,$conexion2);
						if(!$resultado2)
						{
							$resultado_ga = array(
								'codigo' => 0,
								'mensaje' => 'No se elimino el registro, no se pudo conectar con el servidor.'
							);
							die(mysql_error($resultado2));
						}
						else
						{
							$row2=mysql_fetch_array($resultado2);
							$consulta = "UPDATE tb_registro001 SET reg_estado = 'E'"
							." WHERE reg_cedula = ".$row2['ref_cedula_paciente']."";
							$resultado3 = mysql_query($consulta,$conexion3);
							if(!$resultado3)
							{
								$resultado_ga = array(
									'codigo' => 0,
									'mensaje' => 'No se elimino el registro, no se pudo conectar con el servidor.'
								);
								die(mysql_error($resultado3));
							}
							else
							{
								$resultado_ga = array(
									'codigo' => 1,
									'mensaje' => 'Registro eliminado con exito'
								);
							}
						}
					}
				}
				else
				{
					if($_POST['tipo_trans']=="asignarCita")
					{
						$consulta = "UPDATE tb_matriz_referencia SET ref_fecha_cita = '".$_POST['ref_fecha_cita']."',"
						."ref_hora_cita='".$_POST['ref_hora_cita'].":00',"
						."ref_especialista_nombre='".$_POST['ref_especialista_nombre']."'"
						." WHERE ref_codigo = ".$_POST['ref_codigo']."";
						$resultado = mysql_query($consulta,$conexion);
						if(!$resultado)
						{
							$resultado_ga = array(
								'codigo' => 0,
								'mensaje' => 'No se actualizo el registro, no se pudo conectar con el servidor.'
							);
							die(mysql_error($resultado));
						}
						else
						{
							$resultado_ga = array(
								'codigo' => 1,
								'mensaje' => 'Registro actualizado con exito'
							);
						}
					}
					else
					{
						if($_POST['tipo_trans']=="estadoCita")
						{
							$consulta = "UPDATE tb_matriz_referencia SET ref_estado_ref = '".$_POST['ref_estado_ref']."'"
							." WHERE ref_codigo = ".$_POST['ref_codigo']."";
							$resultado = mysql_query($consulta,$conexion);
							if(!$resultado)
							{
								$resultado_ga = array(
									'codigo' => 0,
									'mensaje' => 'No se actualizo el registro, no se pudo conectar con el servidor.'
								);
								die(mysql_error($resultado));
							}
							else
							{
								$resultado_ga = array(
									'codigo' => 1,
									'mensaje' => 'Referencia #'.$_POST['ref_codigo'].' actualizada con exito'
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
	mysql_close($conexion3);
	header("Content-Type: application/json");
	echo json_encode($resultado_ga);
?>