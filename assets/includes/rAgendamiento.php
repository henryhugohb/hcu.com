<!DOCTYPE html>
<?php
	include("conexion.php");
	$conexion = conectar_bd();
	$conexion2 = conectar_bd();
	$conexion3 = conectar_bd();
	$conexion4 = conectar_bd();
?>
<html>
	<head>
		<script src="assets/js/jquery-1.11.2.min.js"></script>
		<meta http-equiv="Content-Type" content="text/html;charset=UTF-8"/>
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
		</style>
	</head>
	<body>
		<section>
			<table id="t-resultado" border="1">
				<tr>
					<td class="t-header" rowspan="2" >Dia</td>
					<td class="t-header" rowspan="2" >Numero de Profesionales</td>
					<td class="t-header" rowspan="2" >Agendados CallCenter</td>
					<td class="t-header" rowspan="2" >Atendidos CallCenter</td>
					<td class="t-header" colspan="2">Agendados Manualmente</td>
					<td class="t-header" colspan="2">Libre Demanda</td>
					<td class="t-header" rowspan="2" >Morbilidad</td>
					<td class="t-header" rowspan="2" >Total citas</td>
				</tr>
				<tr>
					<td class="t-header">Primera</td>
					<td class="t-header">Subsecuente</td>
					<td class="t-header">Primera</td>
					<td class="t-header">Subsecuente</td>
				</tr>
				<?php
					//<td class="t-header">CallCenter</td>
					//<td class="t-header">Atendidos CallCenter</td>
					if($_GET['espe']=="1,9")
					{
						$codigo1=1;
						$codigo2=9;
					}
					else
					{
						if($_GET['espe']=="4,11")
						{
							$codigo1=4;
							$codigo2=11;
						}
						else
						{
							if($_GET['espe']=="2,10")
							{
								$codigo1=2;
								$codigo2=10;
							}
						}
					}
					//parametros para tipo de paciente
					if($_GET['tipo']=='A')
					{
						$filtro_tipo=" AND age_estado_c='A'";
					}
					else
					{
						$filtro_tipo=" AND age_estado_c!='L'";
					}

					for($i=1;$i<=31;$i++)
					{
						echo "<tr><td>".$i."</td>";
						$n_agendas=0;
						$n_profesionales=0;
						$n_morbilidad=0;
						$n_agendados=0;
						$n_libre_demanda=0;
						$n_a_primera=0;
						$n_a_subsecuentes=0;
						$n_l_primera=0;
						$n_l_subsecuentes=0;
						$profesional_actual="";
						if($i<10)
						{
							$fecha = $_GET['anio']."-".$_GET['mes']."-0".$i;
						}
						else
						{
							$fecha = $_GET['anio']."-".$_GET['mes']."-".$i;
						}
						$consulta = "SELECT * FROM tb_agenda WHERE age_estado ='A' "
									."AND age_fecha='".$fecha."' "
									." ORDER BY age_fecha,age_profesional ASC";
						$resultado = mysql_query($consulta,$conexion);
						if ($resultado)
						{
							while ($row = mysql_fetch_assoc($resultado)) 
							{
								if($_GET['espe']=="*")
								{
									//echo $row['age_codigo'];
									//echo "<td>".$row['age_profesional']."</td>";
									//contamos los profesionales
									if($row['age_profesional']!=$profesional_actual)
									{
										$n_profesionales=$n_profesionales+1;
									}
									$profesional_actual=$row['age_profesional'];
									//contamos las citas
									$consulta3 = "SELECT * FROM tb_agendamiento WHERE age_cod_agenda=".$row['age_codigo']." and age_estado='A' ".$filtro_tipo;
									$resultado3 = mysql_query($consulta3,$conexion3);
									if($resultado3)
									{
										while($row3=mysql_fetch_assoc($resultado3))
										{
											$n_agendas=$n_agendas+1;
											if($row3['age_tipo']=='M')
											{
												$n_morbilidad=$n_morbilidad+1;
											}
											if($row3['age_fecha']!=$fecha)
											{
												$n_agendados=$n_agendados+1;
												$consulta4 = "SELECT * FROM tb_admision WHERE adm_estado='A' AND adm_na=".$row3['age_narchivo'].";";
												$resultado4 = mysql_query($consulta4,$conexion4);
												$row4=mysql_fetch_array($resultado4);
												if($resultado4)
												{
													if(mysql_num_rows($resultado4)!=0)
													{
														if(($row4['adm_fecha_admision']==$row3['age_fecha_c'])||($row4['adm_fecha_admision']==$row3['age_fecha']))
														{
															$n_a_primera=$n_a_primera+1;																
														}
														else
														{
															$n_a_subsecuentes=$n_a_subsecuentes+1;
														}
													}
													else
													{
														$n_a_primera=$n_a_primera+1;
													}
												}
											}
											else
											{
												$n_libre_demanda=$n_libre_demanda+1;
												$consulta4 = "SELECT * FROM tb_admision WHERE adm_estado='A' AND adm_na=".$row3['age_narchivo'].";";
												$resultado4 = mysql_query($consulta4,$conexion4);
												$row4=mysql_fetch_array($resultado4);
												if($resultado4)
												{
													if(mysql_num_rows($resultado4)!=0)
													{
														if(($row4['adm_fecha_admision']==$row3['age_fecha_c'])||($row4['adm_fecha_admision']==$row3['age_fecha']))
														{
															$n_l_primera=$n_l_primera+1;																
														}
														else
														{
															$n_l_subsecuentes=$n_l_subsecuentes+1;
														}
													}
													/*else
													{
														$n_l_primera=$n_a_primera+1;
													}*/
												}
											}
										}
									}
								}
								else
								{
									$consulta2 = "SELECT * FROM tb_profesional WHERE pro_estado='A' AND pro_cedula='".$row['age_profesional']."';";
									$resultado2 = mysql_query($consulta2,$conexion2);
									$row2 = mysql_fetch_array($resultado2);
									if(($row2['pro_especialidad']==$codigo1)||($row2['pro_especialidad']==$codigo2))
									{
										//echo $row['age_codigo'];
										//echo "<td>".$row['age_profesional']."</td>";
										//contamos los profesionales
										if($row['age_profesional']!=$profesional_actual)
										{
											$n_profesionales=$n_profesionales+1;
										}
										$profesional_actual=$row['age_profesional'];
										//contamos las citas
										$consulta3 = "SELECT * FROM tb_agendamiento WHERE age_cod_agenda=".$row['age_codigo']." and age_estado='A' ".$filtro_tipo;
										$resultado3 = mysql_query($consulta3,$conexion3);
										if($resultado3)
										{
											while($row3=mysql_fetch_assoc($resultado3))
											{
												$n_agendas=$n_agendas+1;
												//CUENTA LAS MORBILIDADES
												if($row3['age_tipo']=='M')
												{
													$n_morbilidad=$n_morbilidad+1;
												}
												//CUENTA NO AGENDADOS
												if($row3['age_fecha']!=$fecha)
												{
													$n_agendados=$n_agendados+1;
													$consulta4 = "SELECT * FROM tb_admision WHERE adm_estado='A' AND adm_na=".$row3['age_narchivo'].";";
													$resultado4 = mysql_query($consulta4,$conexion4);
													$row4=mysql_fetch_array($resultado4);
													if($resultado4)
													{
														if(mysql_num_rows($resultado4)!=0)
														{
															if(($row4['adm_fecha_admision']==$row3['age_fecha_c'])||($row4['adm_fecha_admision']==$row3['age_fecha']))
															{
																$n_a_primera=$n_a_primera+1;																
															}
															else
															{
																$n_a_subsecuentes=$n_a_subsecuentes+1;
															}
														}
														else
														{
															$n_a_primera=$n_a_primera+1;
														}
													}
												}
												else
												//CUENTA LIBRE DEMANDA
												{
													$n_libre_demanda=$n_libre_demanda+1;
													$consulta4 = "SELECT * FROM tb_admision WHERE adm_estado='A' AND adm_na=".$row3['age_narchivo'].";";
													$resultado4 = mysql_query($consulta4,$conexion4);
													$row4=mysql_fetch_array($resultado4);
													if($resultado4)
													{
														if(mysql_num_rows($resultado4)!=0)
														{
															if($_GET['tipo']=='A')
															{
																if($row4['adm_fecha_admision']==$row3['age_fecha_c'])
																{
																	$n_l_primera=$n_l_primera+1;																
																}
																else
																{
																	$n_l_subsecuentes=$n_l_subsecuentes+1;
																}
															}
															else
															{
																if($row4['adm_fecha_admision']==$row3['age_fecha'])
																{
																	$n_l_primera=$n_l_primera+1;																
																}
																else
																{
																	$n_l_subsecuentes=$n_l_subsecuentes+1;
																}
															}
														}
														/*else
														{
															$n_l_primera=$n_a_primera+1;
														}*/
													}
												}												
											}
										}
									}
								}
							}							
						}
						echo "<td>".$n_profesionales."</td><td>0</td><td>0</td><td>".$n_a_primera."</td><td>".$n_a_subsecuentes."</td><td>".$n_l_primera."</td><td>".$n_l_subsecuentes."</td><td>".$n_morbilidad."</td><td>".$n_agendas."</td></tr>";
						//echo "<td>".$n_profesionales."</td><td>".$n_a_primera."</td><td>".$n_a_subsecuentes."</td><td>".$n_agendados."</td><td>".$n_l_primera."</td><td>".$n_l_subsecuentes."</td><td>".$n_libre_demanda."</td><td>".$n_morbilidad."</td><td>".$n_agendas."</td></tr>";
						//	<td>0</td><td>0</td>
					}
				?>
			</table>
		</section>
		<?php
			mysql_close($conexion);	
			mysql_close($conexion2);
			mysql_close($conexion3);
			mysql_close($conexion4);				
		?>
		<script>
			$(".a-editar").click(function(){
				$("#a-agendar").val('Mostrar');
				$("#cita").html($(this).attr('value'));
				$(".n-cita").fadeOut();
				$(".n-cita").fadeIn();
				$(".c-d-paciente").hide();
				$("#a-agendar").focus();
				//$("#hora-seleccionada").va();
				/*var r= confirm("Esta seguro de modificar el registro actual?");
				if(r==true)
				{
					alert($(this).attr('value'));
				}*/
			});
		</script>
	</body>
</html>