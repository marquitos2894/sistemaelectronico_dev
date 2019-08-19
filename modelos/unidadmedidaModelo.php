<?php

if($peticionAjax){
    require_once '../core/mainModel.php';
}else{
    require_once './core/mainModel.php';
}


class unidadmedidaModelo extends mainModel {


    protected function save_unidadmed_modelo($datos){
        $conex=mainModel::conectar();
        $sql=$conex->prepare("call i_unidadmed(:descripcion,:abreviado)");
        $sql->bindParam(":descripcion",$datos["descripcion"]);
        $sql->bindParam(":abreviado",$datos["abreviado"]);
        $sql->execute();
        return $sql; 
    }

    protected function update_unidadmed_modelo($datos){
       
        $conex=mainModel::conectar();
        $sql=$conex->prepare("call u_unidadmed(:id_unidad_med,:descripcion,:abreviado)");
        $sql->bindParam(":id_unidad_med",$datos["id_unidad_med"]);
        $sql->bindParam(":descripcion",$datos["descripcion"]);
        $sql->bindParam(":abreviado",$datos["abreviado"]);
        $sql->execute();
        return $sql;
        
    }

    protected function delete_unidadmed_modelo($id_unidad_med){
        $conex=mainModel::conectar();
        $sql=$conex->prepare("call d_unidadmed(:id_unidad_med)");
        $sql->bindParam(":id_unidad_med",$id_unidad_med);
        $sql->execute();
        return $sql;

    }

}