<?php 



$peticionAjax=false;
require_once './controladores/vistasControladores.php';

$vt= new vistasControladores();
$vistaReport=$vt->obtener_vista_report_controlador();

require_once  './vendor/autoload.php' ;


require_once $vistaReport;

//MARCA DE AGUA
/*$mpdf->SetWatermarkText('ANULADO');
$mpdf->showWatermarkText = true;*/

$mpdf->WriteHTML($html); 
$mpdf->Output();



?>