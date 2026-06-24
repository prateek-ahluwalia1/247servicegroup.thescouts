<?php 
header("Content-type: application/vnd-ms-excel");  //for ms excel
// Defines the name of the export file "export.xls"
header("Content-Disposition: attachment; filename=export.xls");
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');


?>
{!!$pdf_data!!}