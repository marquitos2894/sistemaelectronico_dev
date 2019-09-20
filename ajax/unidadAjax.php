<?php

$peticionAjax = true;
require_once '../core/configGeneral.php';
require_once '../controladores/unidadControlador.php';

$unidadCont = new unidadControlador();

if(isset($_POST["chngecuenta"])){
    session_start(['name'=>'SBP']);
  echo  $unidadCont->cambiar_cuenta($_POST["chngecuenta"]);  
}