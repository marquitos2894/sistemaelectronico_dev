<?php 


if($peticionAjax){
    require_once '../core/mainModel.php';
}else{
    require_once './core/mainModel.php';
}

class almacenModelo extends mainModel{

    protected function save_vsalida_modelo($datos){
        $conex  = mainModel::conectar();
        $sql=$conex->prepare("INSERT INTO vale_salida (fk_idusuario,fk_idpersonal,nombres,d_identidad,fecha,turno,fk_idequipo,nom_equipo,horometro,comentario)
                                                            VALUES (:fk_idusuario,:fk_idpersonal,:nombres,:d_identidad,:fecha,:turno,:fk_idequipo,:nom_equipo,:horometro,:comentario)");
        $sql->bindParam(":fk_idusuario",$datos["fk_idusuario"]);
        $sql->bindParam(":fk_idpersonal",$datos["fk_idpersonal"]);
        $sql->bindParam(":nombres",$datos["nombre_per"]);
        $sql->bindParam(":d_identidad",$datos["dni_per"]);
        $sql->bindParam(":fecha",$datos["fecha"]);
        $sql->bindParam(":turno",$datos["turno"]);
        $sql->bindParam(":fk_idequipo",$datos["fk_idequipo"]);
        $sql->bindParam(":nom_equipo",$datos["nom_equipo"]);
        $sql->bindParam(":horometro",$datos["horometro"]);
        $sql->bindParam(":comentario",$datos["comentario"]);
        $sql->execute();
        $id=$conex->lastInsertId();     
        return $id;

    }


    protected function save_vingreso_modelo($datos){
        $conex = mainModel::conectar();
        $sql = $conex->prepare("INSERT INTO vale_ingreso(fk_idusuario,fk_idpersonal,nombres,d_identidad,ref_documento,ref_nrodocumento,fecha,turno,comentario)
                                VALUES (:fk_idusuario,:fk_idpersonal,:nombres,:d_identidad,:documento,:ref_documento,:fecha,:turno,:comentario)");
        
        $sql->bindParam(":fk_idusuario",$datos["fk_idusuario"]);
        $sql->bindParam(":fk_idpersonal",$datos["fk_idpersonal"]);
        $sql->bindParam(":nombres",$datos["nombre_per"]);
        $sql->bindParam(":d_identidad",$datos["dni_per"]);
        $sql->bindParam(":fecha",$datos["fecha"]);
        $sql->bindParam(":turno",$datos["turno"]);
        $sql->bindParam(":documento",$datos["documento"]);
        $sql->bindParam(":ref_documento",$datos["ref_documento"]);
        $sql->bindParam(":comentario",$datos["comentario"]);
        $sql->execute();
        $id=$conex->lastInsertId();     
        return $id;
    }


    protected function save_dvsalida_modelo($id_vsalida,$id_ac,$dv_descripcion,$dv_nparte1,$dv_stock,$dv_solicitado,$dv_entregado,$dv_unombre,$dv_useccion){
        $conex = mainModel::conectar();
        $mensaje = [];
        $sql="";
        $i=0;
        foreach($dv_descripcion[0] as $valor){
            $datoscomponente=mainModel::ejecutar_consulta_simple("SELECT c.codigo,c.descripcion,c.nparte1, ac.stock, concat(ac.u_nombre,'-',ac.u_seccion) as ubicacion FROM almacen_componente ac
                                                                 INNER JOIN componentes c ON c.id_comp = ac.fk_idcomp WHERE ac.id_ac = {$id_ac[0][$i]}");
            $salida=$dv_entregado[0][$i];
            $stock = $datoscomponente["stock"];
            
            if($salida<=$stock){
                $sql=$conex->prepare("INSERT INTO detalle_vale_salida(fk_vsalida,fk_id_ac,dv_descripcion,dv_nparte1,dv_stock,dv_solicitado,dv_entregado,dv_unombre,dv_useccion)
                VALUES (:fk_vsalida,:fk_id_ac,:dv_descripcion,:dv_nparte1,:dv_stock,:dv_solicitado,:dv_entregado,:dv_unombre,:dv_useccion);
                UPDATE almacen_componente ac SET ac.stock = (ac.stock - :salida) WHERE ac.id_ac = {$id_ac[0][$i]}");
                $sql->bindParam(":fk_vsalida",$id_vsalida);
                $sql->bindParam(":fk_id_ac",$id_ac[0][$i]);
                $sql->bindParam(":dv_descripcion",$dv_descripcion[0][$i]);
                $sql->bindParam(":dv_nparte1",$dv_nparte1[0][$i]);
                $sql->bindParam(":dv_stock",$dv_stock[0][$i]);
                $sql->bindParam(":dv_solicitado",$dv_solicitado[0][$i]);
                $sql->bindParam(":dv_entregado",$dv_entregado[0][$i]);
                $sql->bindParam(":dv_unombre",$dv_unombre[0][$i]);
                $sql->bindParam(":dv_useccion",$dv_useccion[0][$i]);
                $sql->bindParam(":salida",$salida);
                $sql->execute();
    
            }else{
                $mensaje[$i] = [
                    "codigo"=>$datoscomponente["codigo"],
                    "descripcion"=>$datoscomponente["descripcion"],
                    "nparte1"=>$datoscomponente["nparte1"],
                    "ubicacion"=>$datoscomponente["ubicacion"]
                ];
            }
            $i++; 
        }
        $return = [$sql,$mensaje];
        return $return;
    }
    
    protected function save_dvingreso_modelo($id_vingreso,$dvi_id_ac,$dvi_codigo,$dvi_descripcion,$dvi_nparte1,$dvi_stock,$dvi_ingreso,$dvi_nom_equipo,$fk_id_equipo){
        $conex = mainModel::conectar();
        $mensaje = [];
        $sql="";
        $i=0;
        foreach($dvi_descripcion[0] as $valor){
            $sql = $conex->prepare("INSERT INTO detalle_vale_ingreso (fk_id_vingreso,fk_id_ac,dvi_codigo,dvi_descripcion,dvi_nparte1,dvi_stock,dvi_ingreso,dvi_nombre_equipo,fk_id_equipo) 
                                                        VALUES(:fk_id_vingreso,:fk_id_ac,:dvi_codigo,:dvi_descripcion,:dvi_nparte1,:dvi_stock,:dvi_ingreso,:dvi_nombre_equipo,:fk_id_equipo);
                                                        UPDATE almacen_componente ac SET ac.stock = (ac.stock + :dvi_ingreso) WHERE ac.id_ac = {$dvi_id_ac[0][$i]}");
            $sql->bindParam(":fk_id_vingreso",$id_vingreso);
            $sql->bindParam(":fk_id_ac",$dvi_id_ac[0][$i]);
            $sql->bindParam(":dvi_codigo",$dvi_codigo[0][$i]);
            $sql->bindParam(":dvi_descripcion",$dvi_descripcion[0][$i]);
            $sql->bindParam(":dvi_nparte1",$dvi_nparte1[0][$i]);
            $sql->bindParam(":dvi_stock",$dvi_stock[0][$i]);
            $sql->bindParam(":dvi_ingreso",$dvi_ingreso[0][$i]);
            $sql->bindParam(":dvi_nombre_equipo",$dvi_nom_equipo[0][$i]);
            $sql->bindParam(":fk_id_equipo",$fk_id_equipo[0][$i]);
            $sql->execute();
            $i++;
        }
        return $sql;
  
    }


    protected function save_registro_almacen_modelo($id_comp,$d_u_nom,$d_u_sec,$d_id_equipo,$d_referencia,$id_alm,$d_stock){
        $conex = mainModel::conectar();
        $i=0;
        foreach($id_comp[0] as $valor){
            $sql = $conex->prepare("CALL i_registroalmacen(:id_alm,:id_comp,:d_stock,:d_u_nom,:d_u_sec,:d_id_equipo,:d_referencia)");
            $sql->bindParam(":id_alm",$id_alm);
            $sql->bindParam(":id_comp",$id_comp[0][$i]);
            $sql->bindParam(":d_stock",$d_stock);
            $sql->bindParam(":d_u_nom",$d_u_nom[0][$i]);
            $sql->bindParam(":d_u_sec",$d_u_sec[0][$i]);
            $sql->bindParam(":d_id_equipo",$d_id_equipo[0][$i]);
            $sql->bindParam(":d_referencia",$d_referencia[0][$i]);
            $sql->execute();
            $i++;
        }

        return $sql;
    }
}


?>