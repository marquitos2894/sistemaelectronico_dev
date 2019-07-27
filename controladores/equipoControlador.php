<?php

if($peticionAjax){
    require_once '../modelos/equipoModelo.php';
}else{
    require_once './modelos/equipoModelo.php';
}

Class equipoControlador extends equipoModelo {

    public function select_combo($consulta,$val,$vis){
        return mainModel::ejecutar_combo($consulta,$val,$vis);
    }

}