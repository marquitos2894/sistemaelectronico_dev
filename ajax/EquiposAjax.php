<?php
$peticionAjax = true;
require_once '../core/configGeneral.php';
require_once '../controladores/equipoControlador.php'; 

$equipoCont = new equipoControlador();  


//VISTA EQUIPOS
if(isset($_POST["id_equipo_json"])){
    $id_equipo = $_POST["id_equipo_json"];
echo $equipoCont->obtener_consulta_json_controlador("SELECT * FROM equipos WHERE var_propiedad = 1 AND est = 1 AND Id_Equipo={$id_equipo}");
}

if(isset($_POST["Modelo_Equipo_edit"]) && isset($_POST["Tipo_Equipo_edit"]) && isset($_POST["Id_Equipo_edit"])){
    echo $equipoCont->update_equipos_controlador();
}

if(isset($_POST["Id_Equipo_darBaja"])){
    echo $equipoCont->darbaja_equipo_controlador();
}

if(isset($_POST["Modelo_Equipo_save"]) && isset($_POST["Tipo_Equipo_save"])){
    echo $equipoCont->save_equipos_controlador();
}


//VISTA MI FLOTA

if(isset($_POST["addFlota"])){
    $consulta="select e.Id_Equipo ,CONCAT(e.Modelo_Equipo,' | ',e.Tipo_Equipo,' | ',e.Marca_Equipo,' | ', e.NSerie_Equipo) as datos_equipo
    from equipos e
    WHERE e.Id_Equipo !=1 AND e.var_propiedad = 1 AND e.est = 1 AND e.est_baja = 1";
    echo $equipoCont->select_combo($consulta,0,1);
}

if(isset($_POST["equipo_agregarF"]) && isset($_POST["Alias_Equipo_agregarF"])){
    echo $equipoCont->save_flota_controlador();
}

if(isset($_POST["id_eu_edit"]) && isset($_POST["estado_eu_edit"])){
    echo $equipoCont->update_flota_controlador();
}

if(isset($_POST["idequipounidad_darBaja"])){
    echo $equipoCont->darbaja_flota_controlador();
}

if(isset($_POST["idequipounidad_darAlta"])){
    echo $equipoCont->darAlta_flota_controlador();
}

if(isset($_POST["idequipounidad_delete"])){
    echo $equipoCont->delete_flota_controlador();
}





if(isset($_POST["id_equipounidad_json"])){
    $id_equipounidad = $_POST["id_equipounidad_json"];
    echo $equipoCont->obtener_consulta_json_controlador("SELECT * FROM equipo_unidad WHERE id_equipounidad={$id_equipounidad}");
}












?>