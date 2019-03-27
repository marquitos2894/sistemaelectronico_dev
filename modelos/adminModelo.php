
<?php 

if($peticionAjax){
    require_once '../core/mainModel.php';
}else{
    require_once './core/mainModel.php';
}

class adminModelo extends mainModel{


    protected function eliminar_usuario_modelo($id){

        $sql = mainModel::conectar()->prepare("UPDATE usuario SET estado = 0 WHERE id_usu =:id");
        $sql->bindParam(":id",$id);
        $sql->execute();
        return $sql;
    }

}

?>