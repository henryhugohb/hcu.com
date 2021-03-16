<?php
	include("conexion.php");
	$conexion4 = conectar_bd2();
	$conexion5 = conectar_bd2();
	$conexion6 = conectar_bd2();	
	$resultado_ga = array();
	if(isset($_POST['adm_fecha_admision']) && !empty($_POST['adm_fecha_admision']) && isset($_POST['adm_na']) && !empty($_POST['adm_na']) && isset($_POST['adm_apellido']) && !empty($_POST['adm_apellido']) && isset($_POST['adm_nombre']) && !empty($_POST['adm_nombre']) && isset($_POST['adm_hcu']) && !empty($_POST['adm_hcu']) && isset($_POST['adm_fecha_nacimiento']) && !empty($_POST['adm_fecha_nacimiento']) && isset($_POST['adm_sexo']) && !empty($_POST['adm_sexo']) && isset($_POST['adm_fecha_cita_ultima']) && !empty($_POST['adm_fecha_cita_ultima']) && isset($_POST['adm_fecha_cita_proxima']) && !empty($_POST['adm_fecha_cita_proxima']) && isset($_POST['adm_estado']) && !empty($_POST['adm_estado'])) 
	{
		$edad_trans = (int)$_POST['tar_edad']; 
		if($edad_trans>4)
		{
			$repre = "NULL";
			$crepre = "NULL";
		}
		else
		{
			$repre = "'".$_POST['tar_representante']."'";
			$crepre = "'".$_POST['tar_cedrepresentante']."'";
		}
		$telefonito = (int)$_POST['tar_telefono'];
		if($telefonito==0)
		{
			$telefonito_send="NULL";
		}
		else
		{
			$telefonito_send="'".$_POST['tar_telefono']."'";
		}
		$consulta2 = "INSERT INTO tarjetero VALUES(NULL,"
					."'002088',"
					."".$_POST['adm_na'].","
					."'".date("Y-m-d")."',"
					."'".$_POST['tar_nombre1']."',"
					."'".$_POST['tar_nombre2']."',"
					."'".$_POST['tar_apaterno']."',"
					."'".$_POST['tar_amaterno']."',"
					."'".$_POST['tar_nombrepadre']."',"
					."'".$_POST['tar_nombremadre']."',"
					."'".$_POST['adm_fecha_nacimiento']."',"
					."".$_POST['tar_edad'].","
					.$repre.","
					.$crepre.","
					."1,NULL,NULL,"
					."'".$_POST['adm_hcu']."',"
					."".$telefonito_send.","
					."NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,2,"
					."'".date("Y-m-d")." ".date("G:i:s")."',"
					."NULL);";
		$resultado4 = mysql_query($consulta2,$conexion4);
		if($resultado4)
		{
			$consulta2 = "SELECT * FROM tarjetero WHERE tj_docident='".$_POST['adm_hcu']."'";
			$resultado5 = mysql_query($consulta2,$conexion5);
			if($resultado5)
			{
				if(mysql_num_rows($resultado5)==1)
				{
			 		$row = mysql_fetch_array($resultado5);
			 		$consulta2 = "INSERT INTO htarjetero VALUES(NULL,"
								."".$row['tj_codigo'].","
								."".$_POST['adm_na'].","
								."'".date("Y-m-d")."',"
								."'".$_POST['tar_nombre1']."',"
								."'".$_POST['tar_nombre2']."',"
								."'".$_POST['tar_apaterno']."',"
								."'".$_POST['tar_amaterno']."',"
								."'".$_POST['tar_nombrepadre']."',"
								."'".$_POST['tar_nombremadre']."',"
								."'".$_POST['adm_fecha_nacimiento']."',"
								."".$_POST['tar_edad'].","
								.$repre.","
								.$crepre.","
								."1,NULL,NULL,"
								."'".$_POST['adm_hcu']."',"
								."".$telefonito_send.","
								."NULL,NULL,2,"
								."'".date("Y-m-d")." ".date("G:i:s")."',"
								."NULL);";
					$resultado6 = mysql_query($consulta2,$conexion6);
					if($resultado6)
					{
						$resultado_ga = array(
							'codigo' => 1,
							'mensaje' => 'Registro Guardado con exito'
						);
					}
					else
					{
						$resultado_ga = array(
							'codigo' => 0,
							'mensaje' => 'No se guardo el registro, no se pudo conectar con el servidor'
						);
						die(mysql_error($resultado6));
					}
				}
				else
				{
					$resultado_ga = array(
						'codigo' => 0,
						'mensaje' => 'NO SE HA CRADO EL REGISTRO EN: tarjetero...No se guardo el registro, no se pudo conectar con el servidor'
					);
				}
			}
			else
			{
				$resultado_ga = array(
					'codigo' => 0,
					'mensaje' => 'No se guardo el registro, no se pudo conectar con el servidor'
				);
				die(mysql_error($resultado5));
			}
		}
		else
		{
			$resultado_ga = array(
				'codigo' => 0,
				'mensaje' => 'No se guardo el registro, no se pudo conectar con el servidor'
			);
			die(mysql_error($resultado4));
		}
	}
	else
	{
		$resultado_ga = array(
			'codigo' => 0,
			'mensaje' => 'Existen datos en blanco, no se guardo el registro'
		);
	}
	mysql_close($conexion4);
	mysql_close($conexion5);
	mysql_close($conexion6);
	header("Content-Type: application/json");
	echo json_encode($resultado_ga);
?>