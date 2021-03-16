<?php
	include("conexion.php");
	$conexion = conectar_bd();
	$conexion2 = conectar_bd();
	$conexion3 = conectar_bd();
	$resultado_ga = array();
	if(isset($_POST['adm_fecha_admision']) && !empty($_POST['adm_fecha_admision']) && isset($_POST['adm_na']) && !empty($_POST['adm_na']) && isset($_POST['adm_apellido']) && !empty($_POST['adm_apellido']) && isset($_POST['adm_nombre']) && !empty($_POST['adm_nombre']) && isset($_POST['adm_hcu']) && !empty($_POST['adm_hcu']) && isset($_POST['adm_fecha_nacimiento']) && !empty($_POST['adm_fecha_nacimiento']) && isset($_POST['adm_sexo']) && !empty($_POST['adm_sexo']) && isset($_POST['adm_fecha_cita_ultima']) && !empty($_POST['adm_fecha_cita_ultima']) && isset($_POST['adm_fecha_cita_proxima']) && !empty($_POST['adm_fecha_cita_proxima']) && isset($_POST['adm_estado']) && !empty($_POST['adm_estado'])) 
	{
		$consulta = "UPDATE tb_admision SET "
					."adm_fecha_admision = '".$_POST['adm_fecha_admision']."',"
					."adm_apellido = '".$_POST['adm_apellido']."',"
					."adm_nombre = '".$_POST['adm_nombre']."',"
					."adm_hcu = '".$_POST['adm_hcu']."',"
					."adm_fecha_nacimiento = '".$_POST['adm_fecha_nacimiento']."',"
					."adm_sexo = '".$_POST['adm_sexo']."',"
					."adm_fecha_cita_ultima = '".$_POST['adm_fecha_cita_ultima']."',"
					."adm_fecha_cita_proxima = '".$_POST['adm_fecha_cita_proxima']."',"
					."adm_observacion = '".$_POST['adm_observacion']."'"
					." WHERE adm_na = ".$_POST['adm_na']."";
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
			$consulta = "SELECT * FROM tb_tarjetero WHERE tar_estado='A' AND tar_hcu='".$_POST['adm_hcu']."'";
			$resultado2 = mysql_query($consulta,$conexion2);
			if(mysql_num_rows($resultado2)==0)
			{
				$consulta = "INSERT INTO tb_tarjetero VALUES(NULL,"
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
						."'".$_POST['tar_representante']."',"
						."'".$_POST['tar_cedrepresentante']."',"
						."1,NULL,NULL,"
						."'".$_POST['adm_hcu']."',"
						."'".$_POST['tar_telefono']."',"
						."NULL,NULL,1,NULL,NULL,NULL,NULL,NULL,2,"
						."'".date("Y-m-d")." ".date("G:i:s")."',"
						."NULL,'A');";
				$resultado3 = mysql_query($consulta,$conexion3);
				if(!$resultado3)
				{
					$resultado_ga = array(
						'codigo' => 0,
						'mensaje' => 'No se guardo el registro en la tabla tarjetero, no se pudo conectar con el servidor'
					);
					die(mysql_error($resultado3));
				}
				else
				{
					$resultado_ga = array(
						'codigo' => 1,
						'mensaje' => 'Registro Guardado con exito'
					);
				}
			}
			else
			{
				$resultado_ga = array(
					'codigo' => 1,
					'mensaje' => 'Registro Actualizado con exito, sin tarjetero'
				);
			}
		}
	}
	else
	{
		$resultado_ga = array(
			'codigo' => 0,
			'mensaje' => 'Existen datos en blanco, no se guardo el registro'
		);
	}
	mysql_close($conexion);
	mysql_close($conexion2);
	mysql_close($conexion3);
	header("Content-Type: application/json");
	echo json_encode($resultado_ga);
?>