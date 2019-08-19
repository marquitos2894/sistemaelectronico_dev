
<?php 
session_start(['name'=>'SBP']);
require_once "Core/configGeneral.php";
require_once "controladores/vistasControladores.php";
$plantilla = new vistasControladores();

$PDF=false;
if(isset($_GET['views'])){
    $url = explode("/",$_GET['views']);
    $PDF=substr($url[0],0,3); 
    $PDF=($PDF=="PDF")?$PDF=true:$PDF=false; 
}

if($PDF==true){   
    $plantilla->obtener_plantilla_report_controlador();
}else{
    $plantilla->obtener_plantilla_controlador();
}



?>