<?php
$peticionAjax = true;
require_once '../Core/configGeneral.php';
require_once '../controladores/componentesControlador.php';

$almCont = new componentesControlador();

if(isset($_POST["descripcion"])){
    echo "print";
    $almCont->save_componente_controlador();
}