<?php
$peticionAjax = true;
require_once '../Core/configGeneral.php';
require_once '../controladores/componentesControlador.php';

$compCont = new componentesControlador();

if(isset($_POST["descripcion"])){
    echo "print";
    $compCont->save_componente_controlador();
}

if(isset($_POST["comp_gen"])){
   echo $compCont->componentes_gen_json();
}