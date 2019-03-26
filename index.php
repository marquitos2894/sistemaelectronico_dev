
<?php 

session_start(['name'=>'SBP']);
require_once "Core/configGeneral.php";
require_once "controladores/vistasControladores.php";

$plantilla = new vistasControladores();

$plantilla->obtener_plantilla_controlador();



?>