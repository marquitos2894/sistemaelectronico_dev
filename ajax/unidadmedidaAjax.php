<?php
$peticionAjax = true;
require_once '../Core/configGeneral.php';
require_once '../controladores/unidadmedidaControlador.php';

$unimedida = new unidadmedidaControlador();


if(isset($_POST["combounidad"])){
    $consulta = "SELECT * FROM unidad_medida WHERE descripcion != '{$_POST["combounidad"]}' and est =1";
    echo $unimedida->select_combo($consulta,1,1);
}

