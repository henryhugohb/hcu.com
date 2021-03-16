<?php
	$respuesta = array();
	$hora_server = date("G:H:s");
	$respuesta = array(
		'codigo' => 1,
		'dato' => $hora_server
	);
	header("Content-Type: application/json");
	echo json_encode($respuesta);
?>