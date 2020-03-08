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
        $sql=$conex->prepare("call i_valesalida(:fk_idalm,:fk_idusuario,:fk_idpersonal,:nombres,:d_identidad,:fecha,:fecha_despacho,:turno,:comentario,:dr_referencia)");    

        $sql->bindParam(":fk_idusuario",$datos["fk_idusuario"]);
        $sql->bindParam(":fk_idpersonal",$datos["fk_idpersonal"]);
        $sql->bindParam(":fk_idalm",$datos["id_alm"]);
        $sql->bindParam(":nombres",$datos["nombre_per"]);
        $sql->bindParam(":d_identidad",$datos["dni_per"]);
        $sql->bindParam(":fecha",$datos["fecha"]);
        $sql->bindParam(":fecha_despacho",$datos["fecha_despacho"]);
        $sql->bindParam(":turno",$datos["turno"]);
        $sql->bindParam(":comentario",$datos["comentario"]);
        $sql->bindParam(":dr_referencia",$datos["dr_referencia"]);
        $sql->execute();
        //$arr = $conex->errorInfo();
        $sql=$sql->fetchAll();  
        return $sql;

    }


    protected function save_vingreso_modelo($datos){
        $conex = mainModel::conectar();
        /*$sql = $conex->prepare("INSERT INTO vale_ingreso(fk_idusuario,fk_idpersonal,fk_idalm,nombres,d_identidad,ref_documento,ref_nrodocumento,fecha,turno,comentario)
                                VALUES (:fk_idusuario,:fk_idpersonal,:fk_idalm,:nombres,:d_identidad,:documento,:ref_documento,:fecha,:turno,:comentario)");*/
        
        $sql = $conex->prepare("call i_valeingreso(:fk_idalm,:fk_idusuario,:fk_idpersonal,:nombres,:d_identidad,:documento,:ref_documento,:fecha,:fecha_llegada,:turno,:comentario)");
        $sql->bindParam(":fk_idusuario",$datos["fk_idusuario"]);
        $sql->bindParam(":fk_idpersonal",$datos["fk_idpersonal"]);
        $sql->bindParam(":fk_idalm",$datos["id_alm"]);
        $sql->bindParam(":nombres",$datos["nombre_per"]);
        $sql->bindParam(":d_identidad",$datos["dni_per"]);
        $sql->bindParam(":fecha",$datos["fecha"]);
        $sql->bindParam(":fecha_llegada",$datos["fecha_llegada"]);
        $sql->bindParam(":turno",$datos["turno"]);
        $sql->bindParam(":documento",$datos["documento"]);
        $sql->bindParam(":ref_documento",$datos["ref_documento"]);
        $sql->bindParam(":comentario",$datos["comentario"]);
        $sql->execute();
        $sql = $sql->fetchAll();
        //$id=$conex->lastInsertId();     
        return $sql;
    }


    protected function save_dvsalida_modelo($id_vsalida,$id_ac,$dv_descripcion,$dv_nparte1,$dv_stock,$dv_solicitado,$dv_entregado,$dv_unombre,
    $dv_useccion,$id_alm,$dv_idflota,$dv_horometro,$dv_motivo,$dv_cambio,$fecha,$fk_idusuario,$fk_idpersonal,$datos_referencia){
        $conex = mainModel::conectar();
        $mensaje = [];
        $sql="";
        $i=0;
        foreach($dv_descripcion[0] as $valor){
            $datoscomponente=mainModel::ejecutar_consulta_simple("SELECT c.id_comp,c.descripcion,c.nparte1, ac.stock, concat(ac.u_nombre,'-',ac.u_seccion) as ubicacion FROM almacen_componente ac
                                                                 INNER JOIN componentes c ON c.id_comp = ac.fk_idcomp WHERE ac.id_ac = {$id_ac[0][$i]}");
            $salida=$dv_entregado[0][$i];
            $stock = $datoscomponente["stock"];
            $tipo="salida";
            $entrada=0;

            $saldo=$dv_stock[0][$i]-$dv_entregado[0][$i];

            if($salida<=$stock){
                $sql=$conex->prepare("INSERT INTO detalle_vale_salida(fk_vsalida,fk_id_ac,fk_id_almacen,dv_descripcion,dv_nparte1,dv_stock,dv_solicitado,
                dv_entregado,dv_unombre,dv_useccion,fk_idflota,horometro,motivo,cambio)
                VALUES (:fk_vsalida,:fk_id_ac,:id_alm,:dv_descripcion,:dv_nparte1,:dv_stock,:dv_solicitado,:dv_entregado,
                :dv_unombre,:dv_useccion,:fk_idflota,:horometro,:motivo,:dv_cambio);                
                UPDATE almacen_componente ac SET ac.stock = (ac.stock - :salida) WHERE ac.id_ac = {$id_ac[0][$i]};");
                
                $sql->bindParam(":fk_vsalida",$id_vsalida);
                $sql->bindParam(":fk_id_ac",$id_ac[0][$i]);
                $sql->bindParam(":id_alm",$id_alm);
                $sql->bindParam(":dv_descripcion",$dv_descripcion[0][$i]);
                $sql->bindParam(":dv_nparte1",$dv_nparte1[0][$i]);
                $sql->bindParam(":dv_stock",$dv_stock[0][$i]);
                $sql->bindParam(":dv_solicitado",$dv_solicitado[0][$i]);
                $sql->bindParam(":dv_entregado",$dv_entregado[0][$i]);
                $sql->bindParam(":dv_unombre",$dv_unombre[0][$i]);
                $sql->bindParam(":dv_useccion",$dv_useccion[0][$i]); 
                $sql->bindParam(":fk_idflota",$dv_idflota[0][$i]);
                $sql->bindParam(":horometro",$dv_horometro[0][$i]);
                $sql->bindParam(":motivo",$dv_motivo[0][$i]);
                $sql->bindParam(":dv_cambio",$dv_cambio[0][$i]);
                //salida=>valida el error al stock de la bd
                $sql->bindParam(":salida",$salida);//salida = entregado

                $stmt=$conex->prepare("call i_kardex_almacen(:tipo,:fk_vsalida,:id_comp,:dv_cant,:fecha,:fk_idflota,:ref,:entrada,:dv_entregado,
                :saldo,:dv_cambio,:personal,:usuario,:id_alm)");
                $stmt->bindParam(":tipo",$tipo);
                $stmt->bindParam(":fk_vsalida",$id_vsalida);
                $stmt->bindParam(":id_comp",$datoscomponente["id_comp"]);
                $stmt->bindParam(":dv_cant",$dv_entregado[0][$i]);
                $stmt->bindParam(":fecha",$fecha);
                $stmt->bindParam(":fk_idflota",$dv_idflota[0][$i]);
                $stmt->bindParam(":ref",$datos_referencia);
                $stmt->bindParam(":entrada",$entrada);
                $stmt->bindParam(":dv_entregado",$dv_entregado[0][$i]);
                $stmt->bindParam(":saldo",$saldo);
                $stmt->bindParam(":dv_cambio",$dv_cambio[0][$i]);
                $stmt->bindParam(":personal",$fk_idpersonal);
                $stmt->bindParam(":usuario",$fk_idusuario);
                $stmt->bindParam(":id_alm",$id_alm);
                
                $stmt->execute();
                
                if($sql->execute()){
                    $sql='true';
                }else{
                    $sql='false';
                }
    
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
        $resp = [$sql,$mensaje];
        return $resp;
    }
    
    protected function save_dvingreso_modelo($id_vingreso,$dvi_codigo,$dvi_id_ac,$dvi_descripcion,$dvi_nparte1,$dvi_stock,
    $dvi_ingreso,$dvi_nom_equipo,$fk_idflota,$id_alm,$dvi_referencia,$fecha,$fk_idpersonal,$fk_idusuario){
        $conex = mainModel::conectar();
        $mensaje = [];
        $sql="";
        $i=0;
     

        foreach($dvi_descripcion[0] as $valor){

            $tipo="ingreso";
            $salida=0;
            $dvi_cambio='false';
            $saldo=$dvi_stock[0][$i]+$dvi_ingreso[0][$i];
            
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

            $stmt=$conex->prepare("call i_kardex_almacen(:tipo,:fk_id_vingreso,:id_comp,:dvi_cant,:fecha,:fk_idflota,:ref,
            :entrada,:dv_entregado,:saldo,:dv_cambio,:personal,:usuario,:id_alm)");
            
            $stmt->bindParam(":tipo",$tipo);
            $stmt->bindParam(":fk_id_vingreso",$id_vingreso);
            $stmt->bindParam(":id_comp",$dvi_codigo[0][$i]);
            $stmt->bindParam(":dvi_cant",$dvi_ingreso[0][$i]);
            $stmt->bindParam(":fecha",$fecha);
            $stmt->bindParam(":fk_idflota",$fk_idflota[0][$i]);
            $stmt->bindParam(":ref",$dvi_referencia[0][$i]);
            $stmt->bindParam(":entrada",$dvi_ingreso[0][$i]);
            $stmt->bindParam(":dv_entregado",$salida);
            $stmt->bindParam(":saldo",$saldo);
            $stmt->bindParam(":dv_cambio",$dvi_cambio);
            $stmt->bindParam(":personal",$fk_idpersonal);
            $stmt->bindParam(":usuario",$fk_idusuario);
            $stmt->bindParam(":id_alm",$id_alm);

            $stmt->execute();
            $sql->execute();

            $i++;
        }
        return $sql;
  
    }


    protected function save_registro_almacen_modelo($id_comp,$d_u_nom,$d_nserie,$d_descripcion,$d_u_sec,$d_fk_idflota,
    $d_referencia,$id_alm,$d_stock,$d_cant,$t_reg,$d_fk_usuario){
        $conex = mainModel::conectar();
        //$conex->beginTransaction();
        $i=0;
        $id=[];
        $mensaje=[];
        $sql="";
        $statement="";
        $objDateTime = new DateTime('NOW');
        $fecha=$objDateTime->format('Y-m-d H:i:s');
        foreach($id_comp[0] as $valor){
            
            $validar_duplicado=0;
            if($d_nserie[0][$i]!=''){
                $validar_duplicado = mainModel::ejecutar_consulta_validar("SELECT ac.id_ac,c.id_comp,c.nserie
                FROM almacen_componente ac
                INNER JOIN componentes c
                ON ac.fk_idcomp = c.id_comp
                WHERE ac.fk_idcomp = '{$id_comp[0][$i]}' AND c.nserie = '{$d_nserie[0][$i]}' AND ac.fk_idalm = {$id_alm} AND ac.est =1 ");

                $validar_duplicado= $validar_duplicado->rowCount();
                $d_cant[0][$i]=1;
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
                    //$t_reg = 1 => cuando se envian los datos a vale ingreso
                    $sql->bindParam(":d_stock",$d_stock);
                }else{
                     //$t_reg = 2 => cuando se registran como stock inicial o nuevo registro
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
                        
                    $stmt=$conex->prepare("call i_kardex_almacen(:tipo,:numero,:id_comp,:dvi_cant,:fecha,:fk_idflota,:ref,
                    :entrada,:dv_entregado,:saldo,:dv_cambio,:personal,:usuario,:id_alm)");
                    $tipo="nuevo_registro";
                    $salida=0;$numero='-';
                    $d_cambio='false';
                    $stmt->bindParam(":tipo",$tipo);
                    $stmt->bindParam(":numero",$numero);
                    $stmt->bindParam(":id_comp",$id_comp[0][$i]);
                    $stmt->bindParam(":dvi_cant",$d_cant[0][$i]);
                    $stmt->bindParam(":fecha",$fecha);
                    $stmt->bindParam(":fk_idflota",$d_fk_idflota[0][$i]);
                    $stmt->bindParam(":ref",$d_referencia[0][$i]);
                    $stmt->bindParam(":entrada",$d_cant[0][$i]);
                    $stmt->bindParam(":dv_entregado",$salida);
                    $stmt->bindParam(":saldo",$d_cant[0][$i]);//saldo sera igual a la cantidad que se ingresa porque es un nuevo registro
                    $stmt->bindParam(":dv_cambio",$d_cambio);
                    $stmt->bindParam(":personal",$$d_fk_usuario);
                    $stmt->bindParam(":usuario",$$d_fk_usuario);
                    $stmt->bindParam(":id_alm",$id_alm);
        
                    $stmt->execute();

                }else{
                    $sql = "";
                    $statement="";
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

    protected function anular_vsalida_modelo($id_vsalida,$id_alm,$fecha,$usuario){
        $conex = mainModel::conectar();
       
        //PROCEDE A LA ANULACION DEL VALE
        $sql=$conex->prepare("CALL anular_vale_salida(:id_vsalida,:id_alm)");
        $sql->bindParam(":id_vsalida",$id_vsalida);
        $sql->bindParam(":id_alm",$id_alm);  
        
        if($sql->execute()){

            $comp=mainModel::ejecutar_consulta_lista("SELECT dvs.fk_vsalida,dvs.fk_id_ac,ac.fk_idcomp,dvs.dv_descripcion,dvs.fk_id_almacen,dvs.dv_entregado,dvs.fk_idflota
            FROM detalle_vale_salida dvs 
            inner join almacen_componente ac 
            ON ac.id_ac = dvs.fk_id_ac 
            WHERE dvs.fk_vsalida={$id_vsalida} and dvs.fk_id_almacen = {$id_alm}");

            foreach($comp as  $row){

                $stock['stock']=mainModel::ejecutar_consulta_simple("select ac.stock from almacen_componente ac where id_ac = {$row['fk_id_ac']}");
                $saldo=$stock['stock'][0]+$row['dv_entregado'];

                //ACTUALIZAR COMPONENTES AFECTADOS A LA ANULACION
                $stmt=$conex->prepare("UPDATE almacen_componente ac SET ac.stock = (ac.stock + :dvi_ingreso) WHERE ac.id_ac = {$row['fk_id_ac']}");
                $stmt->bindParam(":dvi_ingreso",$row['dv_entregado']);
                $stmt->execute();

                //INSERT KARDEX
                $stmt2=$conex->prepare("call i_kardex_almacen(:tipo,:numero,:id_comp,:cant,:fecha,:fk_idflota,:ref,
                :entrada,:dv_entregado,:saldo,:dv_cambio,:personal,:usuario,:id_alm)");
                $tipo="anulado-salida";$ref="-"; $salida=0;

                $dvi_cambio='false';
                $fk_idflota = ($row['fk_idflota']==0)?$fk_idflota=1:$fk_idflota=$row['fk_idflota'];

                $stmt2->bindParam(":tipo",$tipo);
                $stmt2->bindParam(":numero",$id_vsalida);
                $stmt2->bindParam(":id_comp",$row['fk_idcomp']);
                $stmt2->bindParam(":cant",$row['dv_entregado']);
                $stmt2->bindParam(":fecha",$fecha);
                $stmt2->bindParam(":fk_idflota",$fk_idflota);
                $stmt2->bindParam(":ref",$ref);
                $stmt2->bindParam(":entrada",$row['dv_entregado']);
                $stmt2->bindParam(":dv_entregado",$salida);
                $stmt2->bindParam(":saldo",$saldo);
                $stmt2->bindParam(":dv_cambio",$dvi_cambio);
                $stmt2->bindParam(":personal",$usuario);
                $stmt2->bindParam(":usuario",$usuario);
                $stmt2->bindParam(":id_alm",$id_alm);
                $stmt2->execute();
            }
            return $sql;
        }else{
            return $sql='null'; 
        }
        
    }

    protected function anular_vingreso_modelo($id_vingreso,$id_alm,$fecha,$usuario){

        $conex = mainModel::conectar();
    
         //PROCEDE A LA ANULACION DEL VALE
        $sql=$conex->prepare("CALL anular_vale_ingreso(:id_vingreso,:id_alm)");
        $sql->bindParam(":id_vingreso",$id_vingreso);
        $sql->bindParam(":id_alm",$id_alm);

        if($sql->execute()){

            $comp=mainModel::ejecutar_consulta_lista("SELECT dvi.id_dvingreso,dvi.fk_id_ac,ac.fk_idcomp,
            dvi.dvi_descripcion,dvi.fk_id_almacen,dvi.dvi_ingreso,dvi.fk_idflota
            FROM detalle_vale_ingreso dvi
            INNER JOIN almacen_componente ac
            ON ac.id_ac = dvi.fk_id_ac
            WHERE dvi.fk_id_vingreso = {$id_vingreso} AND dvi.fk_id_almacen={$id_alm}");

            foreach($comp as $row){
                $stock['stock']=mainModel::ejecutar_consulta_simple("select ac.stock from almacen_componente ac where id_ac = {$row['fk_id_ac']}");
                $saldo=$stock['stock'][0]-$row['dvi_ingreso'];
    
                $stmt = $conex->prepare("UPDATE almacen_componente ac SET ac.stock = (ac.stock - :dvi_ingreso) WHERE ac.id_ac = {$row['fk_id_ac']}");
                $stmt->bindParam(":dvi_ingreso",$row["dvi_ingreso"]);
                $stmt->execute();
    
                //INSERT KARDEX
                $stmt2=$conex->prepare("call i_kardex_almacen(:tipo,:numero,:id_comp,:cant,:fecha,:fk_idflota,:ref,
                :entrada,:salida,:saldo,:dv_cambio,:personal,:usuario,:id_alm)");
               
                $tipo="anulado-ingreso";$ref="-"; $ingreso=0;
                $dvi_cambio='false';
                $fk_idflota = ($row['fk_idflota']==0)?$fk_idflota=1:$fk_idflota=$row['fk_idflota'];
    
                $stmt2->bindParam(":tipo",$tipo);
                $stmt2->bindParam(":numero",$id_vingreso);
                $stmt2->bindParam(":id_comp",$row['fk_idcomp']);
                $stmt2->bindParam(":cant",$row['dvi_ingreso']);
                $stmt2->bindParam(":fecha",$fecha);
                $stmt2->bindParam(":fk_idflota",$fk_idflota);
                $stmt2->bindParam(":ref",$ref);
                $stmt2->bindParam(":entrada",$ingreso);
                $stmt2->bindParam(":salida",$row['dvi_ingreso']);//dvi_ingreso es la salida de un vale ingreso anulado
                $stmt2->bindParam(":saldo",$saldo);
                $stmt2->bindParam(":dv_cambio",$dvi_cambio);
                $stmt2->bindParam(":personal",$usuario);
                $stmt2->bindParam(":usuario",$usuario);
                $stmt2->bindParam(":id_alm",$id_alm);
                $stmt2->execute();
            }
            return $sql;
        }else{
            return $sql='null'; 
        }


    }
}


?>