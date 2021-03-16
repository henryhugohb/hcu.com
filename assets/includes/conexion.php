	<?php
	function conectar_bd()
	{
		$servidor_bd = "localhost";
		$usuario_bd = "root";
		$contrasenha_bd = "";
		$BD = "bd_colonche2";

		$conexion_bd = @mysql_connect($servidor_bd,$usuario_bd,$contrasenha_bd);

		if(!$conexion_bd)
		{
			die('<strong>No Pudo conectarse: </strong>'.mysql_error());
		}
		mysql_select_db($BD,$conexion_bd) or die(mysql_error($conexion_bd));
		return $conexion_bd;
	}

	function conectar_bd2()
	{
		$servidor_bd2 = "localhost";
		$usuario_bd2 = "root";
		$contrasenha_bd2 = "";
		$BD2 = "tarjetero_db";

		$conexion_bd2 = @mysql_connect($servidor_bd2,$usuario_bd2,$contrasenha_bd2);

		if(!$conexion_bd2)
		{
			die('<strong>No Pudo conectarse: </strong>'.mysql_error());
		}
		mysql_select_db($BD2,$conexion_bd2) or die(mysql_error($conexion_bd2));
		return $conexion_bd2;
	}

	function calculadorEdad($fecha_nacimiento)
	{
		$dia = date('j');
		$mes = date('n');
		$anio = date('Y');
		$fecha_n = "";
		$fecha_n = $fecha_nacimiento;
		$caracteres = strlen($fecha_n);

		$fecha_anio = "".$fecha_n[0].$fecha_n[1].$fecha_n[2].$fecha_n[3]."";
		$fecha_mes = "".$fecha_n[5].$fecha_n[6]."";
		$fecha_dia = "".$fecha_n[8].$fecha_n[9]."";
		
		$anio_nac = (int) $fecha_anio;
		$mes_nac = (int) $fecha_mes;
		$dia_nac = (int) $fecha_dia;

		if(($mes==$mes_nac) &&($dia<$dia_nac))
		{
			$anio = $anio-1;
		}
		if($mes<$mes_nac)
		{
			$anio = $anio-1;	
		}

		$edad = $anio-$anio_nac;
		return $edad;
	}

	function dias_transcurridos($fecha_i,$fecha_f)
	{
		$dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
		$dias 	= abs($dias); $dias = floor($dias);		
		return $dias;
	}

	function validaCedulaPhp($txt_control)
	{
		$ncedula = $txt_control;
		$nncedula = strlen($ncedula);
		if ($nncedula<10 || $nncedula>10)
		{
			return false;
		}
		else
		{
			$provincia = $ncedula[0] + $ncedula[1];
			if ($provincia>24 || $provincia<1)
			{
				return false;
			}
			else
			{
				if ($ncedula[2]>10)/*se cambio el if (ncedula[2]>5) por que daba error*/
				{
					return false;
				}
				else
				{
					$resultado =0;
					$acumularesultado =0;
					$dsuperior=0;
					$ultimodigito = 0;
					$decena = " ";
					for ($j = 0; $j < ($nncedula-1); $j++)
					{
						$multiplicador = $j%2;
						if ($multiplicador==0) {$multiplicador=2;}
						$resultado = $ncedula[$j] * $multiplicador;
						if ($resultado>=10){ $resultado=$resultado-9;}
						$acumularesultado = $acumularesultado + $resultado;
					}
					$decena = $acumularesultado."";
					$ndecena=strlen($decena);
					$dsuperior = ($decena[0]*10)+10;
					$ultimodigito = $dsuperior - $acumularesultado;
					if($ultimodigito==10){$ultimodigito=0;}
					if($ultimodigito!=$ncedula[9])
					{
						return false;
					}
					else
					{
						return true;
					}
				}
			}
		}	
	}
?>