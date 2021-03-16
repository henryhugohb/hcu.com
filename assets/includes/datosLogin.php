<?php
	session_start();
	include 'conexion.php';
	$conexion = conectar_bd();
	$consulta = "SELECT * FROM tb_profesional WHERE pro_cedula='".$_POST['pro_cedula']."'"
				." AND pro_pin=".$_POST['pro_pin'];
	mysql_query("SET NAMES 'utf8'");
	$result = mysql_query($consulta,$conexion);
	$row = mysql_fetch_array($result);
	if($result)
	{
		if(mysql_num_rows($result)==1)
		{
			$res_existencia = array(
				'codigo' => 1,
				'mensaje' => 'Inicio de sesion exitoso',
				'pro_codigo' => $row['pro_codigo'],
				'pro_cedula' => $row['pro_cedula'],
				'pro_apellidos'=> $row['pro_apellidos'],
				'pro_nombres' => $row['pro_nombres']
			);
			$_SESSION['loggedin'] = true;
			$_SESSION['username'] = $row['pro_cedula'];
			$_SESSION['start'] = time();
			$_SESSION['expire'] = $_SESSION['start'] + (8*60*60);
			echo "Sesion de ".$row['pro_nombres']. " Iniciada";
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
		$res_existencia = array(
			'codigo' => 0,
			'mensaje' => 'No se pudo establecer conexion con el servidor'
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