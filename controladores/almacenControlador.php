<?php

if($peticionAjax){
    require_once '../modelos/almacenModelo.php';
}else{
    require_once './modelos/almacenModelo.php';
}


Class almacenControlador extends almacenModelo {
    
    public function paginador_componentes($paginador,$registros,$privilegio,$buscador,$vista,$TipoVale){

        $paginador=mainModel::limpiar_cadena($paginador);
        $registros=mainModel::limpiar_cadena($registros);
        $privilegio=mainModel::limpiar_cadena($privilegio);
        $tabla='';

        $paginador=(isset($paginador) && $paginador>0)?(int)$paginador:1; 
        $inicio=($paginador>0)?(($paginador*$registros)-$registros):0;

        $conexion = mainModel::conectar();
        if($buscador!=""){
            $datos=$conexion->query("SELECT SQL_CALC_FOUND_ROWS c.id_comp,c.codigo,c.descripcion,c.nparte1,c.nparte2,c.nparte3,c.unidad_med,ac.stock,ac.fk_idalm,ac.id_ac,ac.u_nombre,ac.u_seccion
                                     FROM componentes c
                                     INNER JOIN almacen_componente ac
                                     ON ac.fk_idcomp = c.id_comp WHERE (c.codigo like '%{$buscador}%' or c.descripcion  like '%{$buscador}%'  or c.nparte1 like '%{$buscador}%' or c.nparte2 like '%{$buscador}%' ) and ac.est = 1 and ac.fk_idalm=1 LIMIT {$inicio},{$registros} ");
        }else{
            $datos=$conexion->query("SELECT SQL_CALC_FOUND_ROWS c.id_comp,c.codigo,c.descripcion,c.nparte1,c.nparte2,c.nparte3,c.unidad_med,ac.stock,ac.fk_idalm,ac.id_ac,ac.u_nombre,ac.u_seccion
                                    FROM componentes c
                                    INNER JOIN almacen_componente ac
                                    ON ac.fk_idcomp = c.id_comp WHERE ac.est = 1 and ac.fk_idalm=1  LIMIT {$inicio},{$registros}");           
        }
        //$datos->execute();
        $datos = $datos->fetchAll();
        $total = $conexion->query("SELECT FOUND_ROWS()");

        $total = (int)$total->fetchColumn();
        //devuel valor entero redondeado hacia arriba 4.2 = 5
        $Npaginas = ceil($total/$registros);
        $tabla.='<div class="table-responsive"><table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Cod.Interno</th>
                <th scope="col">Descripcion</th>               
                <th scope="col">NParte</th>
                <th scope="col">Ubicacion</th>
                <th scope="col">Stock</th>';
                if($TipoVale=="Salida"){
                    $tabla.= '<th scope="col">Solicitado</th>'; 
                }else{
                    $tabla.= '<th scope="col">Ingreso</th>'; 
                }
                '<th scope="col">Agregar</th>';
                //programar privilegios
        $tabla.="</tr>
        </thead>
        <tbody>";
        if($total>=1 && $paginador<=$Npaginas)
        {
        $contador = $inicio+1;
            foreach($datos as $row){
                $tabla .="<tr>
                            <td>{$contador}</td>
                            <td>{$row['codigo']}</td>
                            <td>{$row['descripcion']}</td>                      
                            <td>{$row['nparte1']}</td>
                            <td>{$row['u_nombre']}-{$row['u_seccion']}</td>
                            <td>{$row['stock']}</td>
                            <td><input type='number'  id='salida$row[id_ac]' /></td>
                            <td> <a href='#' class='card-footer-item' id='addItem' data-producto='$row[id_ac]'>+</a></td>";
                            $contador++;
                $tabla.="</tr>";
            }
        }else{
            $tabla.='<tr><td colspan="4"> No existen registros</td></tr>';
        }

        $tabla.='</tbody></table></div>';
        $tabla.= mainModel::paginador($total,$paginador,$Npaginas,$vista);
        return $tabla;
    }

    public function save_vsalida_controlador(){

        $fk_idusuario = mainModel::limpiar_cadena($_POST["usuario"]);
        $fk_idpersonal = mainModel::limpiar_cadena($_POST["personal"]);
        $turno = mainModel::limpiar_cadena($_POST["turno"]);
        $fk_idequipo=mainModel::limpiar_cadena($_POST["codequipo"]);
        $horometro=mainModel::limpiar_cadena($_POST["horometro"]);
        $comentario=mainModel::limpiar_cadena($_POST["comentario"]);   
        $objDateTime = new DateTime('NOW');
        $fecha=$objDateTime->format('c');
        $nom_equipo=mainModel::ejecutar_consulta_simple("select e.nombre_equipo from equipos e where id_equipo = {$fk_idequipo} ")['nombre_equipo'];
        $datospersonal = mainModel::ejecutar_consulta_simple("select  concat(p.nom_per,',',p.Ape_per) as nombres,p.dni_per from personal p where id_per = {$fk_idpersonal} ");
        $nombre_per = $datospersonal['nombres'];
        $dni_per = $datospersonal['dni_per'];

        //Detalle
        $id_ac[]=$_POST["id_ac"];
        $dv_codigo[]=$_POST["dv_codigo"];
        $dv_descripcion[]=$_POST["dv_descripcion"];
        $dv_nparte1[]=$_POST["dv_nparte1"];
        $dv_stock[]=$_POST["dv_stock"];
        $dv_solicitado[]=$_POST["dv_solicitado"];
        $dv_entregado[]=$_POST["dv_entregado"];
        $dv_unombre[]=$_POST["dv_unombre"];
        $dv_useccion[]=$_POST["dv_useccion"];
        

        $datos = [
            "fk_idusuario"=>$fk_idusuario,
            "fk_idpersonal"=>$fk_idpersonal,
            "turno"=>$turno,
            "fk_idequipo"=>$fk_idequipo,
            "horometro"=>$horometro,
            "comentario"=>$comentario,
            "fecha"=>$fecha,
            "nom_equipo"=>$nom_equipo,
            "nombre_per"=>$nombre_per,
            "dni_per"=>$dni_per
        ];

        $id_vsalida=almacenModelo::save_vsalida_modelo($datos);
        $info_dvsalida=almacenModelo::save_dvsalida_modelo($id_vsalida,$id_ac,$dv_descripcion,$dv_nparte1,$dv_stock,$dv_solicitado,$dv_entregado,$dv_unombre,$dv_useccion);
        if($id_vsalida!=0){
            if($info_dvsalida[0]==""){
            mainModel::ejecutar_consulta_simple("UPDATE vale_salida SET est = 0 WHERE id_vsalida = {$id_vsalida}");                       
                $alerta=[
                    "alerta"=>"simple",
                    "Titulo"=>"Vale salida N°{$id_vsalida} ha sido anulado",
                    "Texto"=>"Por no tener registros asociados, verificar su stock, si persiste contacte con el admin",
                    "Tipo"=>"error"
                ];

                $datos = [
                    "tipo"=>"danger",
                    "mensaje"=>"<h5><strong>Vale de salida N°{$id_vsalida}</strong> ha sido anulado, verificar su stock </h5>"
                ];
                echo mainModel::bootstrap_alert($datos);
            }else{
                $alerta=[
                    "alerta"=>"recargar_tiempo",
                    "Titulo"=>"Vale salida N°{$id_vsalida} generado! ",
                    "Texto"=>"Los siguientes datos han sido guardados",
                    "Tipo"=>"success",
                    "tiempo"=>5000
                ];
                $datos = ["tipo"=>"success","mensaje"=>"<h5><strong>Vale de salida N°{$id_vsalida}</strong> generado con exito !! haga click aqui para ver su registro, o la pagina se actualizara en 5s</h5> "];
                echo mainModel::bootstrap_alert($datos);
                //echo "<script>setTimeout('document.location.reload()',10000)</script>";
            }
   
            foreach($info_dvsalida[1] as $i){
                $mensaje ="El item: | {$i['codigo']} | {$i['descripcion']} | {$i['nparte1']} | {$i['ubicacion']} | No se registro por desbalance de stock, verificar ";
                $datos = [
                    "tipo"=>"danger",
                    "mensaje"=>"$mensaje"
                ];
                echo mainModel::bootstrap_alert($datos);
            }

            
        }else{
            $alerta=[
                "alerta"=>"recargar",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"No hemos podido registrar el vale de salida, contacte al admin",
                "Tipo"=>"error"
            ];
        }
        
        return mainModel::sweet_alert($alerta);

    }

    public function save_vingreso_controlador(){
        $fk_idusuario = mainModel::limpiar_cadena($_POST["usuario"]);
        $fk_idpersonal = mainModel::limpiar_cadena($_POST["personal"]);
        $turno = mainModel::limpiar_cadena($_POST["turno"]);
        $documento=mainModel::limpiar_cadena($_POST["documento"]);
        $ref_documento=mainModel::limpiar_cadena($_POST["ref_documento"]);
        $comentario=mainModel::limpiar_cadena($_POST["comentario"]);
        $objDateTime = new DateTime('NOW');
        $fecha=$objDateTime->format('c');
        $datospersonal = mainModel::ejecutar_consulta_simple("select  concat(p.nom_per,',',p.Ape_per) as nombres,p.dni_per from personal p where id_per = {$fk_idpersonal} ");
        $nombre_per = mainModel::limpiar_cadena($datospersonal['nombres']);
        $dni_per = mainModel::limpiar_cadena($datospersonal['dni_per']);
        
        //Detalle
        $id_ac[]=$_POST["id_ac"];
        $dv_codigo[]=$_POST["dv_codigo"];
        $dv_descripcion[]=$_POST["dv_descripcion"];
        $dv_nparte1[]=$_POST["dv_nparte1"];
        $dv_stock[]=$_POST["dv_stock"];
        $dv_unombre[]=$_POST["dv_unombre"];
        $dv_useccion[]=$_POST["dv_useccion"];

        
        $datos = [
            "fk_idusuario"=>$fk_idusuario,
            "fk_idpersonal"=>$fk_idpersonal,
            "turno"=>$turno,
            "documento"=>$documento,
            "ref_documento"=>$ref_documento,
            "comentario"=>$comentario,
            "fecha"=>$fecha,
            "nombre_per"=>$nombre_per,
            "dni_per"=>$dni_per
        ];

        $id_vingreso=almacenModelo::save_vingreso_modelo($datos);
        if($id_vingreso!=0){
            
        $alerta=[
            "alerta"=>"recargar_tiempo",
            "Titulo"=>"Vale salida N°{$id_vingreso} generado! ",
            "Texto"=>"Los siguientes datos han sido guardados",
            "Tipo"=>"success",
            "tiempo"=>5000
        ];
        $datos = ["tipo"=>"success","mensaje"=>"<h5><strong>Vale de salida N°{$id_vingreso}</strong> generado con exito !! haga click aqui para ver su registro, o la pagina se actualizara en 5s</h5> "];
        echo mainModel::bootstrap_alert($datos);
        }


        return mainModel::sweet_alert($alerta);
    }


    public function obtener_consulta_json_controlador(){
        $consulta = "SELECT ac.id_ac,c.id_comp,c.codigo,c.descripcion,c.nparte1,
        c.nparte2,c.nparte3,c.unidad_med,ac.stock,ac.fk_idalm,ac.u_nombre,ac.u_seccion,e.Nombre_Equipo
        FROM componentes c
        INNER JOIN almacen_componente ac ON ac.fk_idcomp = c.id_comp 
        INNER JOIN equipos e  ON e.Id_Equipo = ac.fk_idequipo 
        WHERE ac.est = 1 ";
        return mainModel::obtener_consulta_json($consulta);
    }

    public function chosen_personal($val,$vis){
        $consulta = "select p.id_per, CONCAT(p.Nom_per,',',p.Ape_per,'-',p.Dni_per)
        from personal p";
        return mainModel::ejecutar_combo($consulta,$val,$vis);
    }

    public function chosen_equipo($val,$vis){
        $consulta = "select e.Id_Equipo,e.Nombre_Equipo
        from equipos e";
        return mainModel::ejecutar_combo($consulta,$val,$vis);
    }

}


?>