
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
        cp.cargo, p.Correoe_per
        FROM usuario u
        INNER JOIN personal p ON u.fk_idper = p.id_per
        INNER JOIN cargopersonal cp ON p.id_cargo = cp.id_cargo
        WHERE u.id_usu = :codigo");
        $sql->bindParam(":codigo",$codigo);   
        }

        $sql->execute();
        return $sql;
    }

    protected function Update_administrado_modelo($datos){
        $sql=mainModel::conectar()->prepare("UPDATE usuario u
        INNER JOIN personal p ON p.id_per = u.fk_idper
        SET 
        p.Correoe_per = :correo_p,
        p.Nom_per =:nom_p, 
        p.Ape_per =:ape_p,
        p.Dni_per =:dni_p,
        p.brevete =:brevete_p,
        p.Telefono_per =:telf_p,
        p.Direccion_per=:dir_p,
        p.Region_per =:reg_p,
        p.Ciudad_per = :ciu_p,
        p.Distrito_per =:dis_p,
        u.Correo =:correo_u,
        u.tipo=:tipo_u,
        u.estado =:estado_u,
        u.Clave = :pass_u
        WHERE u.id_usu = :codigo");

        $sql->bindParam(":codigo",$datos['codigo']);
        $sql->bindParam(":correo_p",$datos['correo_p']);
        $sql->bindParam(":nom_p",$datos['nom_p']);
        $sql->bindParam(":ape_p",$datos['ape_p']);
        $sql->bindParam(":dni_p",$datos['dni_p']);
        $sql->bindParam(":brevete_p",$datos['brevete_p']);
        $sql->bindParam(":telf_p",$datos['telf_p']);
        $sql->bindParam(":dir_p",$datos['dir_p']);
        $sql->bindParam(":reg_p",$datos['reg_p']);
        $sql->bindParam(":ciu_p",$datos['ciu_p']);
        $sql->bindParam(":dis_p",$datos['dis_p']);
        $sql->bindParam(":correo_u",$datos['correo_u']);
        $sql->bindParam(":tipo_u",$datos['tipo_u']);
        $sql->bindParam(":estado_u",$datos['estado_u']);
        $sql->bindParam(":pass_u",$datos['pass_u']);

        $sql->execute();
        return $sql;

    }

}

?>