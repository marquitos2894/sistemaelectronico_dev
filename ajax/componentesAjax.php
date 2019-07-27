<?php
$peticionAjax = true;
require_once '../Core/configGeneral.php';
require_once '../controladores/componentesControlador.php';

$compCont = new componentesControlador();

if(isset($_POST["descripcion"])){
  echo $compCont->save_componente_controlador();
}

if(isset($_POST["comp_gen"])){
   echo $compCont->componentes_gen_json();
}

if(isset($_POST["combo_eq"])){
    echo $compCont->select_combo("select e.Id_Equipo,e.Nombre_Equipo
    from equipos e",0,1);
}

if(isset($_POST["id_comp"])){
  echo $compCont->dato_componente($_POST["id_comp"]);
}

if(isset($_POST["descripcion_formEdit"]) && isset($_POST["nparte1"])){
  echo $compCont->update_componente_controlador();
}



/*if(isset($_POST["id_equipo"])){
    echo $compCont->validar_equipo($_POST["id_equipo"]);
}*/

