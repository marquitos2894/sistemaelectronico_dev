<?php 


if($peticionAjax){
    require_once '../core/mainModel.php';
}else{
    require_once './core/mainModel.php';
}


Class componentesModelo extends mainModel {

    protected function save_componentenes_modelo($datos){
        $conex  = mainModel::conectar();
        $sql=$conex->prepare("CALL i_componentesnew(:descripcion,:nparte1,:nparte2,:nparte3,:marca,:unidad_med,:control_stock)");
        $sql->bindParam(":descripcion",$datos["descripcion"]);
        $sql->bindParam(":nparte1",$datos["nparte1"]);
        $sql->bindParam("nparte2",$datos["nparte2"]);
        $sql->bindParam("nparte3",$datos["nparte3"]);
        $sql->bindParam("marca",$datos["marca"]);
        $sql->bindParam("unidad_med",$datos["unidad_med"]);
        $sql->bindParam("control_stock",$datos["control_stock"]);
        $sql->execute();
        return $sql;    
    }
    
}



?>