<?php
	$mi_pdf = '0925272155-1.pdf';
	header('Content-type: application/pdf');
	header('Content-Disposition: attachment; filename="'.$mi_pdf.'"');
	readfile($mi_pdf);
?>