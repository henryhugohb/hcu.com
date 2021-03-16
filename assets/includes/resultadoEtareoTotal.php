<!DOCTYPE html>
<html>
	<head>
		<script src="assets/js/jquery-1.11.2.min.js"></script>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
		<style>
			section
			{
				background-color: #dadada;
				font-family: arial;
			}
			#t-resultado
			{
				background-color: white;
				text-align: center;
			}
			.t-header
			{
				background-color: #045FB4;
				color: white;	
			}
			.btn_eliminar:hover
			{
				font-weight: bold;
				cursor: pointer;
			}
		</style>
	</head>
	<body>
		<section>
			<?php
			include("conexion.php");
			$conexion = conectar_bd();
			$conexion2 = conectar_bd();
			$consulta = "SELECT * FROM tb_matriz_grupo_etareo WHERE mge_estado='A' AND mge_visita='P' AND mge_mes_reg='" .$_GET['mes'] . "';";
			$resultado = mysql_query($consulta,$conexion);
			echo "<strong>EXISTEN ".mysql_num_rows($resultado)." REGISTROS EN EL MES SELECCIONADO	</strong></br>";
			?>
			<table id="t-resultado" border="1" style="font-size:10px;">
				<tr>
					<th class="t-header" rowspan="2">#</th>
					<!--th class="t-header" colspan="3">Fecha Registro</th-->
					<th class="t-header" rowspan="2">Dist</th>
					<th class="t-header" rowspan="2">Unidad Operativa</th>
					<th class="t-header" colspan="3">Fecha Registro</th>
					<th class="t-header" rowspan="2">Historia Clinica Unica</th>
					<!--th class="t-header" rowspan="2">Numero Archivo</th-->
					<th class="t-header" colspan="3">Fecha Nacimiento</th>
					<th class="t-header" rowspan="2">Edad (años)</th>
					<th class="t-header" rowspan="2">Genero</th>
					<th class="t-header" colspan="5">Escolar (5-9años) IMC/EDAD</th>
					<th class="t-header" colspan="5">Adolescente (10-19años) IMC/EDAD</th>
					<th class="t-header" colspan="4">Adulto (20-64años) IMC</th>
					<th class="t-header" colspan="5">Adulto Mayor (65 y mas) IMC</th>
					<th class="t-header" rowspan="2">Nombre_del_responsable del parte diario</th>
				</tr>
				<tr>
					<th class="t-header">Dia</th>
					<th class="t-header">Mes</th>
					<th class="t-header">Año</th>
					<th class="t-header">Dia</th>
					<th class="t-header">Mes</th>
					<th class="t-header">Año</th>
					<th class="t-header">OB</th>
					<th class="t-header">SOB P</th>
					<th class="t-header">NOR</th>
					<th class="t-header">EMA</th>
					<th class="t-header">SEV EMA</th>
					<th class="t-header">OB</th>
					<th class="t-header">SOB P</th>
					<th class="t-header">NOR</th>
					<th class="t-header">EMA</th>
					<th class="t-header">SEV EMA</th>
					<th class="t-header">OB</th>
					<th class="t-header">SOB P</th>
					<th class="t-header">NOR</th>
					<th class="t-header">BAJO P</th>
					<th class="t-header">OB</th>
					<th class="t-header">SOB P</th>
					<th class="t-header">NOR</th>
					<th class="t-header">BAJO P</th>
					<th class="t-header">MUY BAJO P</th>
				</tr>
			<?php
			if ($resultado)
			{
				$bdr=0;
				while ($row = mysql_fetch_assoc($resultado)) 
				{
					$consulta="SELECT * FROM tb_profesional WHERE pro_estado!='E' AND pro_cedula='".$row['mge_profesional']."'";
					$resultado2 = mysql_query($consulta,$conexion2);
					$row2=mysql_fetch_array($resultado2);
					if(($bdr%2)==0)
					{
						echo "<tr>"; 
					}
					else
					{
						echo "<tr bgcolor='#b2d9ff'>";
					}
					?>
						<td><?php echo ($bdr+1);?></td>
						<!--td><?php //echo $row['mge_dia_reg'];?></td>
						<td><?php //echo $row['mge_mes_reg'];?></td>
						<td><?php //echo $row['mge_anio_reg'];?></td-->
						<td><?php echo "24D01";?></td>
						<td><?php echo "COLONCHE";?></td>
						<td><?php echo $row['mge_dia_reg'];?></td>
						<td><?php echo $row['mge_mes_reg'];?></td>
						<td><?php echo $row['mge_anio_reg'];?></td>
						<td><?php echo $row['mge_hcu'];?></td>
						<!--td><?php //echo $row['mge_na'];?></td-->
						<td><?php echo $row['mge_dia_nac'];?></td>
						<td><?php echo $row['mge_mes_nac'];?></td>
						<td><?php echo $row['mge_anio_nac'];?></td>
						<td><?php echo $row['mge_edad'];?></td>
						<td>
							<?php
								/*Actualizacion 2-08-2016 por clinico marcos preciado quiere que le pongan el genero que Loser*/
								if ($row['mge_sexo']=='H')
								{
									echo 'M';
								}
								else
								{
									if ($row['mge_sexo']=='M')
									{
										echo 'F';
									}	
								}
							?>
						</td>
					<?php
						//$tipo_visita = $row['mge_visita'];
						//Modificacion para nueva matriz solo primeras visitas
						$tipo_visita = $row['mge_sexo'];
						if($row['mge_edad']>4 && $row['mge_edad']<10)
						{
							if($row['mge_imc']==1)
							{
								echo "<td>".$tipo_visita."</td>";	
							}
							else
							{
								echo "<td></td>";
							}
							if($row['mge_imc']==2)
							{
								echo "<td>".$tipo_visita."</td>";	
							}
							else
							{
								echo "<td></td>";
							}
							if($row['mge_imc']==3)
							{
								echo "<td>".$tipo_visita."</td>";	
							}
							else
							{
								echo "<td></td>";
							}
							if($row['mge_imc']==4)
							{
								echo "<td>".$tipo_visita."</td>";	
							}
							else
							{
								echo "<td></td>";
							}
							if($row['mge_imc']==7)
							{
								echo "<td>".$tipo_visita."</td>";	
							}
							else
							{
								echo "<td></td>";
							}
						}
						else
						{
							echo "<td></td>";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td></td>";
						}
						if($row['mge_edad']>9 && $row['mge_edad']<20)
						{
							if($row['mge_imc']==1)
							{
								echo "<td>".$tipo_visita."</td>";	
							}
							else
							{
								echo "<td></td>";
							}
							if($row['mge_imc']==2)
							{
								echo "<td>".$tipo_visita."</td>";	
							}
							else
							{
								echo "<td></td>";
							}
							if($row['mge_imc']==3)
							{
								echo "<td>".$tipo_visita."</td>";	
							}
							else
							{
								echo "<td></td>";
							}
							if($row['mge_imc']==4)
							{
								echo "<td>".$tipo_visita."</td>";	
							}
							else
							{
								echo "<td></td>";
							}
							if($row['mge_imc']==7)
							{
								echo "<td>".$tipo_visita."</td>";	
							}
							else
							{
								echo "<td></td>";
							}
						}
						else
						{
							echo "<td></td>";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td></td>";
						}
						if($row['mge_edad']>19 && $row['mge_edad']<65)
						{
							if($row['mge_imc']==1)
							{
								echo "<td>".$tipo_visita."</td>";	
							}
							else
							{
								echo "<td></td>";
							}
							if($row['mge_imc']==2)
							{
								echo "<td>".$tipo_visita."</td>";	
							}
							else
							{
								echo "<td></td>";
							}
							if($row['mge_imc']==3)
							{
								echo "<td>".$tipo_visita."</td>";	
							}
							else
							{
								echo "<td></td>";
							}
							if($row['mge_imc']==8)
							{
								echo "<td>".$tipo_visita."</td>";	
							}
							else
							{
								echo "<td></td>";
							}
						}
						else
						{
							echo "<td></td>";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td></td>";
						}
						if($row['mge_edad']>64)
						{
							if($row['mge_imc']==1)
							{
								echo "<td>".$tipo_visita."</td>";	
							}
							else
							{
								echo "<td></td>";
							}
							if($row['mge_imc']==2)
							{
								echo "<td>".$tipo_visita."</td>";	
							}
							else
							{
								echo "<td></td>";
							}
							if($row['mge_imc']==3)
							{
								echo "<td>".$tipo_visita."</td>";	
							}
							else
							{
								echo "<td></td>";
							}
							if($row['mge_imc']==8)
							{
								echo "<td>".$tipo_visita."</td>";	
							}
							else
							{
								echo "<td></td>";
							}
							if($row['mge_imc']==9)
							{
								echo "<td>".$tipo_visita."</td>";	
							}
							else
							{
								echo "<td></td>";
							}
						}
						else
						{
							echo "<td></td>";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td></td>";
							echo "<td></td>";
						}
					?>
						<td><?php echo $row2['pro_apellidos']." ".$row2['pro_nombres']."";?></td>
					</tr>
					<?php
					$bdr=$bdr+1;
				}
				if($bdr==0)
				{
					?><tr><td colspan="4"><?php echo "No se encontro ninguna coincidencia";?></td></tr><?php
				}
			}
			mysql_close($conexion);
			?>
			</table>
		</section>
		<script>
			$(".btn_eliminar").click(function(){
				var r = confirm("Esta seguro de eliminar el paciente?");
				if(r==true)
				{
					var r2 = confirm("Esta operacion es irreversible. Desea continuar?");
					if(r2==true)
					{
						var parametros = {
							cod_admision: $(this).attr("alt")
						};
						$.ajax({
						    url: "assets/includes/eliminaPacienteFisico.php",
						    type: 'POST',
						    async: false,
						    data: parametros,
						    dataType: "json",
						    success: function (respuesta)
						    {
						    	if(respuesta.codigo == 1)
						      	{
						        	alert(respuesta.mensaje);
						        	$("#enviarBusqueda").click();
						      	}
						      	else
						      	{
						      		alert(respuesta.mensaje);
						      	}
						    }, 
						    error: function (error) {
						      console.log("ERROR: " + error);
						    }
						});	
					}
				}
			});
		</script>
	</body>
</html>