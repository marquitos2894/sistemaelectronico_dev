<?php 

if($peticionAjax){
    require_once '../modelos/unidadModelo.php';
}else{
    require_once './modelos/unidadModelo.php';
}


class unidadControlador extends unidadModelo {

    public function cambiar_cuenta($idunidad){
        $_SESSION["unidad"]=$idunidad;
        $_SESSION["almacen"]=0;
        //$_SESSION["nom_almacen"]="";

        //echo mainModel::localstorage_reiniciar($localStorage);
    }
    

}