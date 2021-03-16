<?php
	include("conexion.php");
	$conexion = conectar_bd();
	$conexion2 = conectar_bd();
	$conexion3 = conectar_bd();
	$resultado_ga = array();
	if($_POST['tipo_trans']=="guarda")
	{
		$consulta = "INSERT INTO tb_agenda VALUES(NULL,"
					."'".$_POST['age_fecha']."',"
					."'".$_POST['age_locacion']."',"
					."'".$_POST['age_profesional']."',"
					."'".$_POST['age_hora_inicio']."',"
					."'".$_POST['age_hora_fin']."',"
					."'A');";
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
			$consulta = "SELECT * FROM tb_agenda WHERE age_estado='A' AND age_fecha ="
						."'".$_POST['age_fecha']."' AND age_locacion ="
						."'".$_POST['age_locacion']."' AND age_profesional ="
						."'".$_POST['age_profesional']."' AND age_hora_inicio ="
						."'".$_POST['age_hora_inicio']."' AND age_hora_fin ="
						."'".$_POST['age_hora_fin']."';";
			$resultado2 = mysql_query($consulta,$conexion2);
			$row = mysql_fetch_array($resultado2);
			if($resultado2)
			{
				$c_hora = "";
				$c_hora = $_POST['age_hora_inicio'];
				$minutoAnadir=20;
				while($c_hora<$_POST['age_hora_fin'])
				{
					$consulta = "INSERT INTO tb_agendamiento VALUES(NULL,"
								."'".$row['age_codigo']."',"
								."'".$c_hora."',"
								."'','','0000-00-00','00:00','0000-00-00','00:00','00:00','','','','L','A','');";
					$resultado3 = mysql_query($consulta,$conexion3);
					if(!$resultado3)
					{
						$resultado_ga = array(
							'codigo' => 0,
							'mensaje' => 'No se guardo el registro, no se pudo conectar con el servidor'
						);
						die(mysql_error($resultado3));
					}
					else
					{
						$segundos_horaInicial=strtotime($c_hora); 
						$segundos_minutoAnadir=$minutoAnadir*60;
						$c_hora=date("H:i",$segundos_horaInicial+$segundos_minutoAnadir);
						$resultado_ga = array(
							'codigo' => 1,
							'mensaje' => 'Registro Guardado con exito.'
						);
					}
				}
			}
			else
			{
				$resultado_ga = array(
					'codigo' => 0,
					'mensaje' => 'No se guardo el registro, no se pudo conectar con el servidor'
				);
				die(mysql_error($resultado2));
			}			
		}
	}
	else
	{
		if($_POST['tipo_trans']=="modifica")
		{
			$consulta = "UPDATE tb_agenda SET "
				."age_fecha = '".$_POST['age_fecha']."',"
				."age_locacion = ".$_POST['age_locacion'].","
				."age_profesional = '".$_POST['age_profesional']."',"
				."age_hora_inicio ='".$_POST['age_hora_inicio']."',"
				."age_hora_fin = '".$_POST['age_hora_fin']."' "
				."WHERE age_codigo = ".$_POST['age_codigo']."";
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
				$consulta2 = "DELETE FROM tb_agendamiento WHERE age_cod_agenda =".$_POST['age_codigo']."";
				$resultado2 = mysql_query($consulta2,$conexion2);
				if(!$resultado2)
				{
					$resultado_ga = array(
						'codigo' => 0,
						'mensaje' => 'No se elimino el registro de agendamiento, no se pudo conectar con el servidor.'
					);
					die(mysql_error($resultado2));
				}
				else
				{
					$c_hora = "";
					$c_hora = $_POST['age_hora_inicio'];
					$minutoAnadir=20;
					while($c_hora<$_POST['age_hora_fin'])
					{
						$consulta = "INSERT INTO tb_agendamiento VALUES(NULL,"
									."'".$_POST['age_codigo']."',"
									."'".$c_hora."',"
									."'','','0000-00-00','00:00','0000-00-00','00:00','00:00','','','','L','A','');";
						$resultado3 = mysql_query($consulta,$conexion3);
						if(!$resultado3)
						{
							$resultado_ga = array(
								'codigo' => 0,
								'mensaje' => 'No se actualizo el registro en agendamiento, no se pudo conectar con el servidor'
							);
							die(mysql_error($resultado3));
						}
						else
						{
							$segundos_horaInicial=strtotime($c_hora); 
							$segundos_minutoAnadir=$minutoAnadir*60;
							$c_hora=date("H:i",$segundos_horaInicial+$segundos_minutoAnadir);
							$resultado_ga = array(
								'codigo' => 1,
								'mensaje' => 'Registro Actualizado con exito'
							);
						}
					}
				}
			}
		}
		else
		{
			if($_POST['tipo_trans']=="elimina")
			{
				$consulta3 = "SELECT * FROM tb_agendamiento WHERE age_cod_agenda = ".$_POST['age_codigo']." AND age_estado_c = 'O';";
				$resultado3 = mysql_query($consulta3,$conexion3);
				if($resultado3)
				{
					$nreg=0;
					while ($conta = mysql_fetch_assoc($resultado3)) {
						$nreg = $nreg+1;
					}
					if($nreg>0)
					{
						$resultado_ga = array(
							'codigo' => 0,
							'mensaje' => 'No se puede Eliminar. Existen citas para esta agenda.'
						);	
					}
					else
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
							$consulta2 = "DELETE FROM tb_agendamiento WHERE age_cod_agenda =".$_POST['age_codigo']."";
							$resultado2 = mysql_query($consulta2,$conexion2);
							if(!$resultado2)
							{
								$resultado_ga = array(
									'codigo' => 0,
									'mensaje' => 'No se elimino el registro de agendamiento, no se pudo conectar con el servidor.'
								);
								die(mysql_error($resultado2));
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
					$res_existencia = array(
						'codigo' => 0,
						'mensaje' => 'No se pudo establecer conexion con el servidor'
					);
				}
			}
			else
			{
				if($_POST['tipo_trans']=="cambia_consultorio")
				{
					$consulta = "UPDATE tb_agenda SET "
								."age_fecha = '".$_POST['age_fecha']."',"
								."age_locacion = ".$_POST['age_locacion'].","
								."age_profesional = '".$_POST['age_profesional']."' "
								."WHERE age_codigo = ".$_POST['age_codigo']."";
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
							'mensaje' => 'Registro Actualizado con exito'
						);
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