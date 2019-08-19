<?php
$peticionAjax = true;
require_once '../Core/configGeneral.php';
require_once '../controladores/unidadmedidaControlador.php';

$unimedida = new unidadmedidaControlador();


/*** VISTA UNIDADMEDLIST */

if(isset($_POST["newunidadmed"])){

    if(isset($_POST["descripcion_um"])){
        echo $unimedida->save_unidadmed_controlador();
    }

}

if(isset($_POST["combounidad"])){
    $consulta = "SELECT * FROM unidad_medida WHERE id_unidad_med != '{$_POST["combounidad"]}' and est =1";
    echo $unimedida->select_combo($consulta,0,2);
}

if(isset($_POST["id_unidad_med_json"])){
    $consulta = "SELECT * FROM unidad_medida WHERE id_unidad_med = {$_POST["id_unidad_med_json"]} AND est =1";
    echo $unimedida->obtener_consulta_json_controlador($consulta,1,1);
}

if(isset($_POST["id_um_formEdit"])){
    echo $unimedida->update_unidadmed_controlador();
}

if(isset($_POST["id_um_formDel"])){
    echo $unimedida->delete_unidadmed_controlador();
}





