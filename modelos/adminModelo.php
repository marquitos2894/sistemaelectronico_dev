
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

    protected function datos_administrador_modelo($tipo,$codigo){
        if($tipo == "Unico"){
        $sql=mainModel::conectar()->prepare("SELECT u.id_usu,u.Correo,u.Clave,u.privilegio,u.tipo,u.estado,
        p.Nom_per,p.Ape_per,p.Dni_per,p.brevete,p.Direccion_per,p.Region_per,p.Ciudad_per,p.Distrito_per,p.Telefono_per,
        cp.cargo
        FROM usuario u
        INNER JOIN personal p ON u.fk_idper = p.id_per
        INNER JOIN cargopersonal cp ON p.id_cargo = cp.id_cargo
        WHERE u.id_usu = :codigo");
        $sql->bindParam(":codigo",$codigo);   
        }

        $sql->execute();
        return $sql;

    }

}

?>