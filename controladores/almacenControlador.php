<?php

if($peticionAjax){
    require_once '../modelos/almacenModelo.php';
}else{
    require_once './modelos/almacenModelo.php';
}

Class almacenControlador extends almacenModelo {


    
    function obtener_consulta_json_controlador(){
        $consulta = "select * from componentes";
        return mainModel::obtener_consulta_json($consulta);
    }

}


?>