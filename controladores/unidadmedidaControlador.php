<?php 

if($peticionAjax){
    require_once '../modelos/unidadmedidaModelo.php';
}else{
    require_once './modelos/unidadmedidaModelo.php';
}


class unidadmedidaControlador extends unidadmedidaModelo {

    public function select_combo($consulta,$val,$vis){
        return mainModel::ejecutar_combo($consulta,$val,$vis);
    }

}