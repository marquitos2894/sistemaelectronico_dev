<?php 


if($peticionAjax){
    require_once '../core/mainModel.php';
}else{
    require_once './core/mainModel.php';
}

class almacenModelo extends mainModel{




    protected function save_vsalida_modelo($datos){
        $conex  = mainModel::conectar();
        /*$sql=$conex->prepare("INSERT INTO vale_salida (fk_idusuario,fk_idpersonal,fk_idalm,nombres,d_identidad,fecha,turno,fk_idequipo,nom_equipo,horometro,comentario)
                                                            VALUES (:fk_idusuario,:fk_idpersonal,:fk_idalm,:nombres,:d_identidad,:fecha,:turno,:fk_idequipo,:nom_equipo,:horometro,:comentario)");*/

        $sql=$conex->prepare("call i_valesalida(:fk_idalm,:fk_idusuario,:fk_idpersonal,:nombres,:d_identidad,:fecha,:turno,:fk_idflota,:nom_equipo,:horometro,:comentario,:dr_referencia)");

        $sql->bindParam(":fk_idusuario",$datos["fk_idusuario"]);
        $sql->bindParam(":fk_idpersonal",$datos["fk_idpersonal"]);
        $sql->bindParam(":fk_idalm",$datos["id_alm"]);
        $sql->bindParam(":nombres",$datos["nombre_per"]);
        $sql->bindParam(":d_identidad",$datos["dni_per"]);
        $sql->bindParam(":fecha",$datos["fecha"]);
        $sql->bindParam(":turno",$datos["turno"]);
        $sql->bindParam(":fk_idflota",$datos["fk_idflota"]);
        $sql->bindParam(":nom_equipo",$datos["nom_equipo"]);
        $sql->bindParam(":horometro",$datos["horometro"]);
        $sql->bindParam(":comentario",$datos["comentario"]);
        $sql->bindParam(":dr_referencia",$datos["dr_referencia"]);
        $sql->execute();
        $sql=$sql->fetchAll();
        //$id=$conex->lastInsertId();     
        return $sql;

    }


    protected function save_vingreso_modelo($datos){
        $conex = mainModel::conectar();
        /*$sql = $conex->prepare("INSERT INTO vale_ingreso(fk_idusuario,fk_idpersonal,fk_idalm,nombres,d_identidad,ref_documento,ref_nrodocumento,fecha,turno,comentario)
                                VALUES (:fk_idusuario,:fk_idpersonal,:fk_idalm,:nombres,:d_identidad,:documento,:ref_documento,:fecha,:turno,:comentario)");*/
        
        $sql = $conex->prepare("call i_valeingreso(:fk_idalm,:fk_idusuario,:fk_idpersonal,:nombres,:d_identidad,:documento,:ref_documento,:fecha,:turno,:comentario)");
        $sql->bindParam(":fk_idusuario",$datos["fk_idusuario"]);
        $sql->bindParam(":fk_idpersonal",$datos["fk_idpersonal"]);
        $sql->bindParam(":fk_idalm",$datos["id_alm"]);
        $sql->bindParam(":nombres",$datos["nombre_per"]);
        $sql->bindParam(":d_identidad",$datos["dni_per"]);
        $sql->bindParam(":fecha",$datos["fecha"]);
        $sql->bindParam(":turno",$datos["turno"]);
        $sql->bindParam(":documento",$datos["documento"]);
        $sql->bindParam(":ref_documento",$datos["ref_documento"]);
        $sql->bindParam(":comentario",$datos["comentario"]);
        $sql->execute();
        $sql = $sql->fetchAll();
        //$id=$conex->lastInsertId();     
        return $sql;
    }


    protected function save_dvsalida_modelo($id_vsalida,$id_ac,$dv_descripcion,$dv_nparte1,$dv_stock,$dv_solicitado,$dv_entregado,$dv_unombre,$dv_useccion,$id_alm){
        $conex = mainModel::conectar();
        $mensaje = [];
        $sql="";
        $i=0;
        foreach($dv_descripcion[0] as $valor){
            $datoscomponente=mainModel::ejecutar_consulta_simple("SELECT c.id_comp,c.descripcion,c.nparte1, ac.stock, concat(ac.u_nombre,'-',ac.u_seccion) as ubicacion FROM almacen_componente ac
                                                                 INNER JOIN componentes c ON c.id_comp = ac.fk_idcomp WHERE ac.id_ac = {$id_ac[0][$i]}");
            $salida=$dv_entregado[0][$i];
            $stock = $datoscomponente["stock"];
            
            if($salida<=$stock){
                $sql=$conex->prepare("INSERT INTO detalle_vale_salida(fk_vsalida,fk_id_ac,dv_descripcion,dv_nparte1,dv_stock,dv_solicitado,dv_entregado,dv_unombre,dv_useccion,fk_id_almacen)
                VALUES (:fk_vsalida,:fk_id_ac,:dv_descripcion,:dv_nparte1,:dv_stock,:dv_solicitado,:dv_entregado,:dv_unombre,:dv_useccion,:fk_id_almacen);
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
                $sql->bindParam(":fk_id_almacen",$id_alm);
                $sql->execute();
    
            }else{
                $mensaje[$i] = [
                    "id_comp"=>$datoscomponente["id_comp"],
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
    
    protected function save_dvingreso_modelo($id_vingreso,$dvi_id_ac,$dvi_descripcion,$dvi_nparte1,$dvi_stock,$dvi_ingreso,$dvi_nom_equipo,$fk_idflota,$id_alm,$dvi_referencia){
        $conex = mainModel::conectar();
        $mensaje = [];
        $sql="";
        $i=0;
        foreach($dvi_descripcion[0] as $valor){
            $sql = $conex->prepare("INSERT INTO detalle_vale_ingreso (fk_id_vingreso,fk_id_ac,dvi_descripcion,dvi_nparte1,dvi_stock,dvi_ingreso,dvi_nombre_equipo,fk_idflota,fk_id_almacen,dr_referencia) 
                                                        VALUES(:fk_id_vingreso,:fk_id_ac,:dvi_descripcion,:dvi_nparte1,:dvi_stock,:dvi_ingreso,:dvi_nombre_equipo,:fk_idflota,:fk_id_almacen,:dr_referencia);
                                                        UPDATE almacen_componente ac SET ac.stock = (ac.stock + :dvi_ingreso) WHERE ac.id_ac = {$dvi_id_ac[0][$i]}");
            $sql->bindParam(":fk_id_vingreso",$id_vingreso);
            $sql->bindParam(":fk_id_ac",$dvi_id_ac[0][$i]);
            $sql->bindParam(":dvi_descripcion",$dvi_descripcion[0][$i]);
            $sql->bindParam(":dvi_nparte1",$dvi_nparte1[0][$i]);
            $sql->bindParam(":dvi_stock",$dvi_stock[0][$i]);
            $sql->bindParam(":dvi_ingreso",$dvi_ingreso[0][$i]);
            $sql->bindParam(":dvi_nombre_equipo",$dvi_nom_equipo[0][$i]);
            $sql->bindParam(":fk_idflota",$fk_idflota[0][$i]);
            $sql->bindParam(":fk_id_almacen",$id_alm);
            $sql->bindParam(":dr_referencia",$dvi_referencia[0][$i]);
            
            $sql->execute();
            $i++;
        }
        return $sql;
  
    }


    protected function save_registro_almacen_modelo($id_comp,$d_u_nom,$d_nserie,$d_descripcion,$d_u_sec,$d_fk_idflota,$d_referencia,$id_alm,$d_stock,$d_cant,$t_reg){
        $conex = mainModel::conectar();
        //$conex->beginTransaction();
        $i=0;
        $id=[];
        $mensaje=[];
        $sql="";
        foreach($id_comp[0] as $valor){
            
            $validar_duplicado=0;
            if($d_nserie[0][$i]!=''){
                $validar_duplicado = mainModel::ejecutar_consulta_validar("SELECT ac.id_ac,c.id_comp,c.nserie
                FROM almacen_componente ac
                INNER JOIN componentes c
                ON ac.fk_idcomp = c.id_comp
                WHERE ac.fk_idcomp = '{$id_comp[0][$i]}' AND c.nserie = '{$d_nserie[0][$i]}' AND ac.fk_idalm = {$id_alm} AND ac.est =1 ");
 
                $validar_duplicado= $validar_duplicado->rowCount();
            }
           
            if($validar_duplicado>0){
                $mensaje[$i] = [
                    "id_comp"=>$id_comp[0][$i],
                    "descripcion"=>$d_descripcion[0][$i],
                    "nserie"=>$d_nserie[0][$i]
                ];
            }else{
                $sql = $conex->prepare("CALL i_registroalmacen(:id_alm,:id_comp,:d_stock,:d_u_nom,:d_u_sec,:d_fk_idflota,:d_referencia)");
                $sql->bindParam(":id_alm",$id_alm);
                $sql->bindParam(":id_comp",$id_comp[0][$i]);

                if($t_reg==1){
                    $sql->bindParam(":d_stock",$d_stock);
                }else{
                    $sql->bindParam(":d_stock",$d_cant[0][$i]);
                }
                
                $sql->bindParam(":d_u_nom",$d_u_nom[0][$i]);
                $sql->bindParam(":d_u_sec",$d_u_sec[0][$i]);
                $sql->bindParam(":d_fk_idflota",$d_fk_idflota[0][$i]);
                $sql->bindParam(":d_referencia",$d_referencia[0][$i]);

                if($sql->execute()){
                    $sql = $sql->fetchAll();
                    $statement = $conex->prepare("SELECT LAST_INSERT_ID() AS id");
                    $statement->execute();       
                    $result = $statement->fetch(PDO::FETCH_ASSOC);
                    array_push($id,$result["id"]);
                }else{
                    $sql = "";
                }
        
            }
            $i++;
        }
        $array = [$statement,$mensaje,$id];
        return $array;
    }

    protected function update_comp_almacen_modelo($datos){
        $conex=mainModel::conectar();
        $sql = $conex->prepare("CALL u_comp_almacen(:fk_idalm,:fk_idcomp,:id_ac,:u_nombre,:u_seccion,:fk_idflota,:Referencia,:control_stock,:cs_inicial,:stock_min,:stock_max)");
        $sql->bindParam(":fk_idalm",$datos["fk_idalm"]);
        $sql->bindParam(":fk_idcomp",$datos["fk_idcomp"]);
        $sql->bindParam(":id_ac",$datos["id_ac"]);
        $sql->bindParam(":u_nombre",$datos["u_nombre"]);
        $sql->bindParam(":u_seccion",$datos["u_seccion"]);
        $sql->bindParam(":fk_idflota",$datos["fk_idflota"]);
        $sql->bindParam(":Referencia",$datos["Referencia"]);
        $sql->bindParam(":cs_inicial",$datos["cs_inicial"]);
        $sql->bindParam(":control_stock",$datos["control_stock"]);
        $sql->bindParam(":stock_min",$datos["stock_min"]);
        $sql->bindParam(":stock_max",$datos["stock_max"]);
        $sql->execute();
        return $sql;
    }

    protected function delete_componente_almacen_modelo($id_ac,$id_comp,$id_alm){
        $conex=mainModel::conectar();
        $sql=$conex->prepare("CALL delete_componente_almacen(:id_ac,:fk_idcomp,:fk_idalm)");
        $sql->bindParam(":id_ac",$id_ac);
        $sql->bindParam(":fk_idcomp",$id_comp);
        $sql->bindParam(":fk_idalm",$id_alm);
        $sql->execute();
        return $sql;
    }
    //protected function 


    //* VISTA REPORTES

    protected function anular_vsalida_modelo($id_vsalida){
        $conex = mainModel::conectar();
        $sql=$conex->prepare("CALL anular_vale_salida(:id_vsalida)");
        $sql->bindParam(":id_vsalida",$id_vsalida); 
        $sql->execute();
        return $sql;
    }

    protected function anular_vingreso_modelo($id_vingreso){
        $conex = mainModel::conectar();
        $sql=$conex->prepare("CALL anular_vale_ingreso(:id_vingreso)");
        $sql->bindParam(":id_vingreso",$id_vingreso); 
        $sql->execute();
        return $sql;

    }
}


?>