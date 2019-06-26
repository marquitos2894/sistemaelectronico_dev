<?php
$peticionAjax = true;
require_once '../Core/configGeneral.php';
require_once '../controladores/componentesControlador.php';

$compCont = new componentesControlador();

if(isset($_POST["descripcion"])){
    $compCont->save_componente_controlador();
}

if(isset($_POST["comp_gen"])){
   echo $compCont->componentes_gen_json();
}

if(isset($_POST["combo_eq"])){
    echo $compCont->chosen_equipo(0,1);
}


/*if(isset($_POST["id_equipo"])){
    echo $compCont->validar_equipo($_POST["id_equipo"]);
}*/

