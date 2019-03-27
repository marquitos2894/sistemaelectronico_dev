<?php 
    if($peticionAjax){
        require_once '../core/mainModel.php';
    }else{
        require_once './core/mainModel.php';
    }

    class emptransModelo extends mainModel{

        protected function agregar_emptrans_modelo($datos){
            $sql=mainModel::conectar()->prepare("insert into emptransporte (razonsocial,ruc) values (:razonsocial,:ruc)");
            $sql->bindParam(":razonsocial",$datos["razonsocial"]);
            $sql->bindParam(":ruc",$datos["ruc"]);
            $sql->execute();
            return $sql;
        }
    }

?>  