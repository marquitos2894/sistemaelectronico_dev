<?php 

if($peticionAjax){
    require_once '../core/mainModel.php';
}else{
    require_once './core/mainModel.php';
}

class personalModelo extends mainModel {



protected function save_personal_modelo($datos){
    $sql = mainModel::conectar()->prepare("INSERT INTO personal (Nom_per,Ape_per,Dni_per, brevete,Telefono_per,Direccion_per,Region_per,Ciudad_per,Distrito_per,urlimagen,id_cargo,idunidad,rol,Correoe_per)
    VALUES (:Nom_per,:Ape_per,:Dni_per, :brevete,:Telefono_per,
    :Direccion_per,:Region_per,:Ciudad_per,:Distrito_per,:urlimagen,:id_cargo,
    :idunidad,:rol,:Correoe_per)");
    
    $rol = "multirol";
    $sql->bindParam(":Nom_per",$datos["nom_p"]);
    $sql->bindParam(":Ape_per",$datos["ape_p"]);
    $sql->bindParam(":Dni_per",$datos["dni_p"]);
    $sql->bindParam(":brevete",$datos["brevete_p"]);
    $sql->bindParam(":Telefono_per",$datos["telf_p"]);
    $sql->bindParam(":Direccion_per",$datos["direccion_in"]);
    $sql->bindParam(":urlimagen",$datos["urlimagen"]);
    $sql->bindParam(":Region_per",$datos["reg_p"]);
    $sql->bindParam(":Ciudad_per",$datos["ciu_p"]);
    $sql->bindParam(":Distrito_per",$datos["dis_p"]);
    $sql->bindParam(":id_cargo",$datos["cargo"]);
    $sql->bindParam(":idunidad",$datos["unidad"]);
    $sql->bindParam(":rol",$rol);
    $sql->bindParam(":Correoe_per",$datos["correo_p"]);

    $sql->execute();
    return $sql;


}


}
?>