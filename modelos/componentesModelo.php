<?php 


if($peticionAjax){
    require_once '../core/mainModel.php';
}else{
    require_once './core/mainModel.php';
}


Class componentesModelo extends mainModel {

    protected function save_componentenes_modelo($datos){
        $conex  = mainModel::conectar();
        $sql=$conex->prepare("CALL i_componentesnew(:descripcion,:nparte1,:nparte2,:nparte3,:marca,:id_unidad_med,:nserie)");
        $sql->bindParam(":descripcion",$datos["descripcion"]);
        $sql->bindParam(":nparte1",$datos["nparte1"]);
        $sql->bindParam(":nparte2",$datos["nparte2"]);
        $sql->bindParam(":nparte3",$datos["nparte3"]);
        $sql->bindParam(":nserie",$datos["nserie"]);
        $sql->bindParam(":marca",$datos["marca"]);
        $sql->bindParam(":id_unidad_med",$datos["id_unidad_med"]);
        $sql->execute();
        return $sql;    
    }

    protected function update_componente_modelo($datos){
        $conex = mainModel::conectar();
        $sql =$conex->prepare("CALL u_componentes(:id_comp,:descripcion,:nparte1,:nparte2,:nparte3,:marca,:id_unidad_med,:nserie)");
        $sql->bindParam(":id_comp",$datos["id_comp"]);
        $sql->bindParam(":descripcion",$datos["descripcion"]);
        $sql->bindParam(":nparte1",$datos["nparte1"]);
        $sql->bindParam(":nparte2",$datos["nparte2"]);
        $sql->bindParam(":nparte3",$datos["nparte3"]);
        $sql->bindParam(":nserie",$datos["nserie"]);
        $sql->bindParam(":marca",$datos["marca"]);
        $sql->bindParam("id_unidad_med",$datos["id_unidad_med"]);
        $sql->execute();
        return $sql;
        
    }


    protected function darAlta_componente_modelo($id_comp){
        $conex = mainModel::conectar();
        $sql=$conex->prepare("call darAlta_global_componente(:id_comp)");
        $sql->bindParam(":id_comp",$id_comp);
        $sql->execute();
        return $sql;
    }
    
    protected function darBaja_componente_modelo($id_comp){
        $conex = mainModel::conectar();
        $sql=$conex->prepare("call darBaja_global_componente(:id_comp)");
        $sql->bindParam(":id_comp",$id_comp);
        $sql->execute();
        return $sql;
    }

    protected function delete_componente_modelo($id_comp){
        $conex = mainModel::conectar();
        $sql=$conex->prepare("call del_global_componente(:id_comp)");
        $sql->bindParam(":id_comp",$id_comp);
        $sql->execute();
        return $sql;
    }


    protected function save_datoreferencia_modelo($datos){
        $conex = mainModel::conectar();
        $sql=$conex->prepare("call i_dato_referencia(:dato_referencia,:descripcion_dr)");
        $sql->bindParam(":dato_referencia",$datos["dato_referencia"]);
        $sql->bindParam(":descripcion_dr",$datos["descripcion_dr"]);
        $sql->execute();
        return $sql;
    }

    protected function update_datoreferencia_modelo($datos){
        $conex = mainModel::conectar();
        $sql=$conex->prepare("call u_datos_referencia(:id_dr,:dato_referencia,:descripcion_dr)");
        $sql->bindParam(":dato_referencia",$datos["dato_referencia"]);
        $sql->bindParam(":descripcion_dr",$datos["descripcion_dr"]);
        $sql->bindParam(":id_dr",$datos["id_dr"]);
        $sql->execute();
        return $sql;
    }

    protected function delete_datoreferencia_modelo($id_dr){
        $conex = mainModel::conectar();
        $sql=$conex->prepare("call d_datos_referencia(:id_dr)");
        $sql->bindParam(":id_dr", $id_dr);
        $sql->execute();
        return $sql;
    }
    
}



?>