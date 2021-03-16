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
			echo "<strong>RESULTADOS DE LA BUSQUEDA</strong></br>";
			$Vhcu = $_GET['vhcu'];
			$Vna = $_GET['vna'];
			$Vn = $_GET['vn'];
			$Va = $_GET['va'];
			if(($Vhcu == '') && ($Vna=='') )  
			{
				if($Va=='')
				{
					$consulta = "SELECT * FROM tb_admision WHERE adm_nombre LIKE '%" . $Vn . "%'";
				}
				else
				{
					if($Vn=='')
					{
						$consulta = "SELECT * FROM tb_admision WHERE adm_apellido LIKE '%" . $Va . "%'";
					}
					else
					{
						$consulta = "SELECT * FROM tb_admision WHERE adm_nombre LIKE '%" . $Vn . "%' AND adm_apellido LIKE '%" . $Va . "%'";
					}
				}
			}
			else
			{
				if(($Vna=='') && ($Vn==''))
				{
					$consulta = "SELECT * FROM tb_admision WHERE adm_hcu LIKE '%" . $Vhcu . "%'";
				}
				else
				{
					$consulta = "SELECT * FROM tb_admision WHERE adm_na LIKE '%" . $Vna . "%'";
				}
			}
			if($_GET['vtipo']!="todos")
			{
				if($_GET['vtipo']=="activos")
				{
					$consulta = $consulta." AND adm_estado='A'";
				}
				else
				{
					if($_GET['vtipo']=="pasivos")
					{
						$consulta = $consulta." AND adm_estado='P'";
					}
				}	
			}
			else
			{
				$consulta = $consulta." AND adm_estado!='E'";
			}
			//mysql_query("SET NAMES 'utf8'");			
			$resultado = mysql_query($consulta,$conexion);
			//echo '<div>'.$consulta.'</div>';
			?>
			<table id="t-resultado" border="1">
				<tr>
					<th class="t-header">Fecha de Admision</th>
					<th class="t-header">N.A.</th>
					<th class="t-header">Apellidos</th>
					<th class="t-header">Nombres</th>
					<th class="t-header">H.C.U</th>
					<th class="t-header">Fecha Nacimiento</th>
					<th class="t-header">Sexo</th>
					<th class="t-header">Fecha Ultima Cita</th>
					<th class="t-header">Fecha Proxima Cita</th>
					<th class="t-header">Estado</th>
					<th class="t-header">Observacion</th>
					<th class="t-header">Operacion</th>
				</tr>
			<?php
			if ($resultado)
			{
				$bdr=0;
				while ($row = mysql_fetch_assoc($resultado)) 
				{
					if(($bdr%2)==0)
					{
						echo "<tr>"; 
					}
					else
					{
						echo "<tr bgcolor='#b2d9ff'>";
					}
					?>
					<td><?php echo $row['adm_fecha_admision'];?></td>
					<td><?php echo $row['adm_na'];?></td>
					<td><?php echo $row['adm_apellido'];?></td>
					<td><?php echo $row['adm_nombre'];?></td>
					<td><?php echo $row['adm_hcu'];?></td>
					<td><?php echo $row['adm_fecha_nacimiento'];?></td>
					<td><?php echo $row['adm_sexo'];?></td>
					<td><?php echo $row['adm_fecha_cita_ultima'];?></td>
					<td><?php echo $row['adm_fecha_cita_proxima'];?></td>
					<td><?php echo $row['adm_estado'];?></td>
					<td><?php echo $row['adm_observacion'];?></td>
					<td>
						<span class="btn_eliminar" <?php echo " alt='".$row['cod_admision']."'";?> >
							Eliminar<?php echo " ".$row['adm_na'];?>
						</span>
					</td>
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