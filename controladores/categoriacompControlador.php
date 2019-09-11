<?php

if($peticionAjax){
    require_once '../modelos/categoricompModelo.php';
}else{
    require_once './modelos/categoricompModelo.php';
}

Class categoriacompControlador extends categoricompModelo {

    public function select_combo($consulta,$val,$vis){
        return mainModel::ejecutar_combo($consulta,$val,$vis);
    }

}