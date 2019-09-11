<?php

if($peticionAjax){
    require_once '../modelos/almacenModelo.php';
}else{
    require_once './modelos/almacenModelo.php';
}

Class almacenControlador extends almacenModelo {
    
    /*public function paginador_componentes_vales($paginador,$registros,$privilegio,$buscador,$vista,$TipoVale){

        $paginador=mainModel::limpiar_cadena($paginador);
        $registros=mainModel::limpiar_cadena($registros);
        $privilegio=mainModel::limpiar_cadena($privilegio);
        $tabla='';
        echo $_SESSION['nombre_sbp'];
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
    }*/

    public function update_comp_almacen_controlador(){

        $fk_idcomp = mainModel::limpiar_cadena($_POST["id_comp_almacen"]);
        $fk_idalm = mainModel::limpiar_cadena($_POST["fk_idalm_almacen"]);
        $u_nombre= mainModel::limpiar_cadena($_POST["u_nombre"]);
        $u_seccion = mainModel::limpiar_cadena($_POST["u_seccion"]);
        $equipo = mainModel::limpiar_cadena($_POST["equipo"]);
        $referencia = mainModel::limpiar_cadena($_POST["referencia"]);
        $cs_inicial = mainModel::limpiar_cadena($_POST["cs_inicial"]);
        $control_stock = mainModel::limpiar_cadena($_POST["control_stock"]);
        $id_ac = mainModel::limpiar_cadena($_POST["id_ac_almacen"]);
       if($control_stock==1){
        $stock_min = mainModel::limpiar_cadena($_POST["smin"]);
        $stock_max = mainModel::limpiar_cadena($_POST["smax"]);
       }else{
        $stock_min = 0;
        $stock_max = 0;
       }

        
        $datos = [
            "fk_idcomp"=>$fk_idcomp,
            "fk_idalm"=>$fk_idalm,
            "id_ac"=>$id_ac,
            "u_nombre"=>$u_nombre,
            "u_seccion"=>$u_seccion,
            "fk_idequipo"=>$equipo,
            "Referencia"=>$referencia,
            "cs_inicial"=>$cs_inicial,
            "control_stock"=>$control_stock,
            "stock_min"=>$stock_min,
            "stock_max"=>$stock_max
        ];

        $validar=almacenModelo::update_comp_almacen_modelo($datos);
        $var=$validar->rowCount();

        if($validar->rowCount()>0){
            $alerta=[
                "alerta"=>"recargar",
                "Titulo"=>"Componente configurado",
                "Texto"=>"El componente ha sido configurado",
                "Tipo"=>"success"
            ];
        }else{
            $alerta=[
                "alerta"=>"recargar",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"No hemos podido actualizar la configuracion del componente, contacte al admin",
                "Tipo"=>"error"
            ];
        }

        return mainModel::sweet_alert($alerta);
    }        

    /*public function paginador_almacen($paginador,$registros,$vista){
        $paginador=mainModel::limpiar_cadena($paginador);
        $registros=mainModel::limpiar_cadena($registros);
        $vista = mainModel::limpiar_cadena($vista);
        $contenido ="";

        $paginador=(isset($paginador) && $paginador>0)?(int)$paginador:1; 
        $inicio=($paginador>0)?(($paginador*$registros)-$registros):0;

        $conexion = mainModel::conectar();
        $datos = $conexion->query("select SQL_CALC_FOUND_ROWS * from almacen");
        $datos = $datos->fetchAll();
        $total = $conexion->query("SELECT FOUND_ROWS()");
        $total = (int)$total->fetchColumn();
        $Npaginas = ceil($total/$registros);
        $contenido .="";
        $contenido.="
        
        <div id='card-almacen' class='card-group' style='width: 80%;' align='center' >";
        foreach(array_slice($datos,0,4) as $row) {
            $contenido .= "
            <div  class='card'>
                <img src='../vistas/img/almacen.png' class='card-img-top'>
                <div class='card-body'>
                <h5 class='card-title'>{$row["Alias"]}</h5>
                <input type='hidden' id='nom_almacen$row[id_alm]' value='{$row["Alias"]}'/>
                <p class='card-text'></p>
                </div>
                <div class='card-footer'>
                    <a href='#' class='card-footer-item' id='almacen' data-almacen='$row[id_alm]'>Ingresar</a>
                </div>
            </div>";                
        }

        $contenido.="       
        <div  class='card'>
            <img src='' class='card-img-top'>
            <div class='card-body'>
            <h5 class='card-title'>Nuevo Almacen</h5>
            <p class='card-text'></p>
            </div>
            <div class='card-footer'>
            
            </div>
        </div>";
        $contenido.="</div>";
        $contenido.= mainModel::paginador($total,$paginador,$Npaginas,$vista);
        return $contenido;

    }*/

    //paginador para la vistas de las unidades
    public function paginador_almacen_u($paginador,$registros,$privilegio,$buscador,$vista,$unidad){

        $paginador=mainModel::limpiar_cadena($paginador);
        $registros=mainModel::limpiar_cadena($registros);
        $privilegio=mainModel::limpiar_cadena($privilegio);
        $tabla='';
        //echo $_SESSION['nombre_sbp'];
        $paginador=(isset($paginador) && $paginador>0)?(int)$paginador:1; 
        $inicio=($paginador>0)?(($paginador*$registros)-$registros):0;

        $conexion = mainModel::conectar();
        
        if($buscador!=""){
            $datos=$conexion->query("SELECT SQL_CALC_FOUND_ROWS a.id_alm,a.Alias,a.Ubicacion,a.Descripcion,d.idunidad
            FROM almacen a
            INNER JOIN direcciones d ON 
            d.id_direcciones = a.fk_iddirecciones
            WHERE ( a.Alias  like '%$buscador%' or a.Ubicacion like '%$buscador%' ) AND a.est=1 AND d.idunidad = {$unidad} LIMIT {$inicio},{$registros}");
            
        }else{
            $datos=$conexion->query("SELECT SQL_CALC_FOUND_ROWS a.id_alm,a.Alias,a.Ubicacion,a.Descripcion,d.idunidad
            FROM almacen a
            INNER JOIN direcciones d ON 
            d.id_direcciones = a.fk_iddirecciones 
            WHERE a.est = 1 AND d.idunidad = {$unidad} LIMIT {$inicio},{$registros}");           
        }
        //$datos->execute();
        $datos = $datos->fetchAll();
        $total = $conexion->query("SELECT FOUND_ROWS()");
        $total = (int)$total->fetchColumn();

        
        //devuel valor entero redondeado hacia arriba 4.2 = 5
        $Npaginas = ceil($total/$registros);
        $tabla.="<div class='table-responsive' ><table class='table table-bordered'>
        <thead>
            <tr>
                <th scope='col'>#</th>
                <th scope='col'>Almacen</th>               
                <th scope='col'>Ubicacion</th>
                <th scope='col'>Descripcion</th>     
                <th colspan='2' scope='col'>Acciones</th>";
                
                //programar privilegios
        $tabla.="
            </tr>
        </thead>
        <tbody id='table_almacen' >";
        if($total>=1 && $paginador<=$Npaginas)
        {   
            
            $i=1;  
            foreach($datos as $row){
                $tabla .="
                <input type='hidden' id='nom_almacen$row[id_alm]' value='{$row["Alias"]}'/> 
            <tr>
                <td>{$i}</td>
                <td>{$row['Alias']}</td>                      
                <td>{$row['Ubicacion']}</td>
                <td>{$row['Descripcion']}</td>
                           
                <td><a href='#' class='card-footer-item' id='almacen' data-almacen='$row[id_alm]'><i class='fas fa-sign-in-alt'></i> Ingresar</a></td>";
                        
            $tabla .="
            </tr>";
            $i++;
            }

        }else{
            $tabla.='<tr><td colspan="10"> No existen registros</td></tr>';
        }

        $tabla.='</tbody></table></div>';
   
        $tabla.= mainModel::paginador($total,$paginador,$Npaginas,$vista);
        return $tabla;
    }

    public function validar_paginador_controlador($buscador,$vista,$eliminar_buscador){
        return mainModel::validar_paginador($buscador,$vista,$eliminar_buscador);
    }
    /* SE REEMPLARON LOS DATATABLES, LA CARGA ES MUY LENTA
    public function databale_componentes($id_alm,$tipo,$privilegio){
        
        $conexion = mainModel::conectar();
        $datos = $conexion->prepare("SELECT ac.id_ac,c.id_comp,c.descripcion,c.nparte1,c.nparte2,c.nparte3,
        um.abreviado,ac.stock,ac.fk_idalm,ac.u_nombre,ac.u_seccion,e.Nombre_Equipo,e.Id_Equipo,
        eu.alias_equipounidad,ac.Referencia,ac.control_stock
            FROM componentes c
            INNER JOIN almacen_componente ac ON ac.fk_idcomp = c.id_comp 
            INNER JOIN equipos e  ON e.Id_Equipo = ac.fk_Id_Equipo
            INNER JOIN unidad_medida um ON um.id_unidad_med = c.fk_idunidad_med
            INNER JOIN equipo_unidad eu ON eu.fk_idequipo = e.Id_Equipo
            WHERE ac.est = 1 and ac.fk_idalm = {$id_alm}  "); 
        $datos->execute();
        $datos=$datos->fetchAll(); 
       
        $dtable = '';
        $contador = 1;
        if($tipo == "simple"){

            foreach($datos as $row){
            $dtable .="
                    <tr>
                        <td>{$contador}</td>
                        <td>{$row['id_comp']}</td>
                        <td>{$row['descripcion']}</td>
                        <td>{$row['nparte1']}</td>
                        <td>{$row['nparte2']}</td>
                        <td>{$row['nparte3']}</td>
                        <td>{$row['u_nombre']}-{$row['u_seccion']}</td>
                        <td>{$row['stock']}</td>";
                        if($row['control_stock']==1){
                            $dtable .="
                            <td><span style='font-size: 1.2rem; color: Tomato;'><i class='fas fa-check'></i></span></td>";
                        }else{
                            $dtable .="
                            <td><span style='font-size: 1.2rem;'><i class='fas fa-times'></i></span></td>";
                        }
        
                        $dtable .=" 
                        <td>{$row['abreviado']}</td>
                        <td>{$row['alias_equipounidad']}</td>
                        <td>{$row['Referencia']}</td>";
                        if($privilegio==0 or $privilegio==1){   
                        $dtable .=" 
                        <td><a href='#'  data-toggle='modal' data-target='#config_comp' ><span style='font-size: 1.5rem;' ><i id='controlstock' data-producto='{$row['id_ac']}' class='fas fa-cog'></i></span></a></td>";
                        
                        $dtable .="
                        <td>
                            <form name='Frm_del_id_ac' action='".SERVERURL."ajax/almacenAjax.php' method='POST' class='FormularioAjax' 
                                data-form='delete' entype='multipart/form-data' autocomplete='off'>
                                <input type='hidden' name='id_comp_del' value='{$row['id_comp']}'/>
                                <input type='hidden' name='id_alm_del' value='{$id_alm}'/>
                                <input type='hidden' name='id_ac_del' value='".mainModel::encryption($row['id_ac'])."'/>
                                <button type='submit' class='btn btn-danger'><i class='far fa-trash-alt' ></i></button>
                                <div class='RespuestaAjax'></div>   
                            </form>
                        </td>";
                        }    
                    $dtable .="
                    </tr>";    
            
                $contador++;
            }
            
        }else{
            foreach($datos as $row){
                $dtable .="
                        <tr>
                            <td>{$contador}</td>
                            <td>{$row['id_comp']}</td>
                            <td>{$row['descripcion']}</td>
                            <td>{$row['nparte1']}</td>
                            <td>{$row['alias_equipounidad']}</td>
                            <td>{$row['Referencia']}</td>
                            <td>{$row['u_nombre']}-{$row['u_seccion']}</td>
                            <td>{$row['abreviado']}</td>
                            <td>{$row['stock']}</td>
                            <td><input type='number' id='salida{$row['id_ac']}' /></td>
                            <td> <a href='#' class='card-footer-item' id='addItem' data-producto='{$row['id_ac']}'>+</a></td>
                        </tr>
                ";
                $contador++;
              }
    
          }
      

      return $dtable;

    }*/


    public function paginador_componentes_almacen($paginador,$registros,$privilegio,$buscador,$vista,$id_alm,$tipo){

        $paginador=mainModel::limpiar_cadena($paginador);
        $registros=mainModel::limpiar_cadena($registros);
        $privilegio=mainModel::limpiar_cadena($privilegio);
        $buscador=mainModel::limpiar_cadena($buscador);

        $tabla='';
        //echo $_SESSION['nombre_sbp'];
        $paginador=(isset($paginador) && $paginador>0)?(int)$paginador:1; 
        $inicio=($paginador>0)?(($paginador*$registros)-$registros):0;

        $conexion = mainModel::conectar();
        $est_baja=($vista=="componentes")?$est_baja=1:$est_baja=0;
        if($buscador!=""){
            $datos=$conexion->query("SELECT SQL_CALC_FOUND_ROWS ac.id_ac,c.id_comp,c.descripcion,c.nparte1,c.nparte2,c.nparte3,
            um.abreviado,ac.stock,ac.fk_idalm,ac.u_nombre,ac.u_seccion,e.Nombre_Equipo,e.Id_Equipo,
            eu.alias_equipounidad,ac.Referencia,ac.control_stock,c.nserie,ca.nombre,ca.color,c.medida,c.est_baja,c.est
              FROM componentes c
              INNER JOIN almacen_componente ac ON ac.fk_idcomp = c.id_comp 
              INNER JOIN equipos e  ON e.Id_Equipo = ac.fk_Id_Equipo
              INNER JOIN unidad_medida um ON um.id_unidad_med = c.fk_idunidad_med
              INNER JOIN equipo_unidad eu ON eu.fk_idequipo = e.Id_Equipo
              INNER JOIN categoriacomp ca ON ca.id_categoria  = c.fk_idcategoria 
            WHERE ( c.id_comp like '%$buscador%' or c.descripcion  like '%$buscador%' or c.nparte1 like '%$buscador%' or 
            c.nparte2 like '%$buscador%' or c.nparte3 like '%$buscador%' or e.Nombre_Equipo like '%$buscador%' or ac.Referencia like '%$buscador%'
            or c.nserie like '%$buscador%' or c.medida like '%$buscador%' or ca.nombre like '%$buscador%'  ) AND ac.est=1
            AND ac.fk_idalm={$id_alm} LIMIT {$inicio},{$registros} ");
            
        }else{
            $datos=$conexion->query("SELECT SQL_CALC_FOUND_ROWS ac.id_ac,c.id_comp,c.descripcion,c.nparte1,c.nparte2,c.nparte3,
        um.abreviado,ac.stock,ac.fk_idalm,ac.u_nombre,ac.u_seccion,e.Nombre_Equipo,e.Id_Equipo,
        eu.alias_equipounidad,ac.Referencia,ac.control_stock,c.nserie,ca.nombre,ca.color,c.medida,c.est_baja,c.est
        FROM componentes c
        INNER JOIN almacen_componente ac ON ac.fk_idcomp = c.id_comp 
        INNER JOIN equipos e  ON e.Id_Equipo = ac.fk_Id_Equipo
        INNER JOIN unidad_medida um ON um.id_unidad_med = c.fk_idunidad_med
        INNER JOIN equipo_unidad eu ON eu.fk_idequipo = e.Id_Equipo
        INNER JOIN categoriacomp ca ON ca.id_categoria  = c.fk_idcategoria 
        WHERE ac.est = 1 and ac.fk_idalm = {$id_alm}  LIMIT {$inicio},{$registros}");           
        }
        //$datos->execute();
        $datos = $datos->fetchAll();
        $total = $conexion->query("SELECT FOUND_ROWS()");
        $total = (int)$total->fetchColumn();
        $Npaginas = ceil($total/$registros);
        


        if($tipo=="vale"){
            //devuel valor entero redondeado hacia arriba 4.2 = 5
            
            $tabla.="
            <button type='button' class='btn btn-primary'>
                Total de productos <span class='badge badge-light'>{$total}</span>
            </button>
            <div class='table-responsive-sm'><table class='table'>
            <thead>
                <tr>
                    <th scope='col'>Codigo</th>
                    <th scope='col'>Descripcion</th>               
                    <th scope='col'>NParte</th>
                    <th scope='col'>NSerie</th>
                    <th scope='col'>Equipo</th>
                    <th scope='col'>Referencia</th>
                    <th scope='col'>Ubicacion</th>
                    <th scope='col'>Stock</th>
                    <th scope='col'>cantidad</th>
                    <th scope='col'>Add</th>";
                    //programar privilegios
                $tabla.="
                </tr>
            </thead>
            <tbody id='table_componente'>";
            if($total>=1 && $paginador<=$Npaginas)
            {
  
                foreach($datos as $row){
                    if($row['est']==0){
                        $color = "table-danger";
                        $title = "producto eliminado; producto desconituado, recomendable dejar usar este codigo {$row['id_comp']} o eliminarlo de su almacen";
                    }else if($row['est_baja']==0){
                        $color = "table-warning";
                        $title = "producto dado de baja; producto descontinuado";
                    }else{
                        $color="";
                        $title="";
                    }
                    $tabla .="
                <tr class='{$color}' data-toggle='tooltip'  data-placement='top' data-html='true' title='{$title}'>
                    <td>{$row['id_comp']}</td>
                    <td>{$row['descripcion']} <span class='badge badge-{$row['color']}'>{$row['nombre']}</span></td>                      
                    <td>{$row['nparte1']}</td>
                    <td>{$row['nserie']}</td>
                    <td>{$row['alias_equipounidad']}</td>
                    <td>{$row['Referencia']}</td>
                    <td>{$row['u_nombre']}-{$row['u_seccion']}</td>
                    <td>{$row['stock']} {$row['abreviado']}</td>
                    <td><input type='number' class='form-control' id='salida{$row['id_ac']}' /></td>
                    <td> <a href='#productosCarrito' class='card-footer-item' id='addItem' data-producto='{$row['id_ac']}'>+</a></td>
                </tr>";
                    
                }
            }else{
                $tabla.='
                <tr><td colspan="10"> No existen registros</td></tr>';
            }

            //$tabla.='</tbody></table></div>';
        }
        else{
            $contador=$inicio+1;
            if($total>=1 && $paginador<=$Npaginas){
                $tabla .="
                <button type='button' class='btn btn-primary'>
                    Total de productos <span class='badge badge-light'>{$total}</span>
                </button>
                <div class='table-responsive-sm'><table class='table'>
                    <thead>
                        <tr>
                            <th scope='col'>#</th>
                            <th scope='col'>Codigo</th>
                            <th scope='col'>Descripcion</th>               
                            <th scope='col'>NParte1</th>
                            <th scope='col'>NParte2</th>
                            <th scope='col'>NSerie</th>
                            <th scope='col'>Ubicacion</th>
                            <th scope='col'>Stock</th>
                            <th scope='col'>Control Stock</th>
                            <th scope='col'>Equipo</th>
                            <th scope='col'>Referencia</th>";
                            if($privilegio==0 or $privilegio==1):
                            $tabla.="
                            <th scope='col'>Config</th>";
                            endif; 
                   
                     $tabla.="
                        </tr>
                    </thead>                   
                    <tbody id='dtbody'>"; 
                            
                foreach($datos as $row){
                    
                    if($row['est']==0){
                        $color = "table-danger";
                        $title = "producto eliminado; producto desconituado, recomendable dejar usar este codigo";
                    }else if($row['est_baja']==0){
                        $color = "table-warning";
                        $title = "producto dado de baja; producto descontinuado";
                    }else{
                        $color="";
                        $title="";
                    }
                        $tabla.="
                        <tr class='{$color}' data-toggle='tooltip'  data-placement='top' data-html='true' title='{$title}'>
                            <td>{$contador}</td>
                            <td>{$row['id_comp']}</td>
                            <td>{$row['descripcion']} <span class='badge badge-{$row['color']}'>{$row['nombre']}</span></td>
                            <td>{$row['nparte1']}</td>
                            <td>{$row['nparte2']}</td>
                            <td>{$row['nserie']}</td>
                            <td>{$row['u_nombre']}-{$row['u_seccion']}</td>
                            <td>{$row['stock']} {$row['abreviado']}</td>";
                            if($row['control_stock']==1){
                                $tabla .="
                            <td><span style='font-size: 1.2rem; color: Tomato;'><i class='fas fa-check'></i></span></td>";
                            }else{
                                $tabla .="
                            <td><span style='font-size: 1.2rem;'><i class='fas fa-times'></i></span></td>";
                            }
            
                            $tabla .=" 
                            <td>{$row['alias_equipounidad']}</td>
                            <td>{$row['Referencia']}</td>";
                            if($privilegio==0 or $privilegio==1){   
                            $tabla .=" 
                            <td><a href='#' data-toggle='modal' data-target='#config_comp' ><span style='font-size: 1.5rem;' ><i id='controlstock' data-producto='{$row['id_ac']}' class='fas fa-cog'></i></span></a></td>";
                        
                            } 

                        $tabla .="
                        </tr>";  

                    $contador++;
                }

            }else{
                $tabla.='<tr>
                            <td colspan="10"> No existen registros</td>
                        </tr>';
            }
            
            
            /*$tabla.='
            </tbody></table></div>';*/  
            
        }
        $tabla.='
            </tbody>
            </table></div>';

        $tabla.= mainModel::paginador_ajax($total,$paginador,$Npaginas,$vista);
        return $tabla;
    }

    public function save_vsalida_controlador(){
        $SERVERURL=SERVERURL;

        
        $fk_idusuario = mainModel::limpiar_cadena($_POST["usuario"]);
        $fk_idpersonal = mainModel::limpiar_cadena($_POST["personal"]);
        $turno = mainModel::limpiar_cadena($_POST["turno"]);
        $fk_idequipo=mainModel::limpiar_cadena($_POST["codequipo"]);
        $horometro=mainModel::limpiar_cadena($_POST["horometro"]);
        $comentario=mainModel::limpiar_cadena($_POST["comentario"]);   
        $id_alm= mainModel::limpiar_cadena($_POST["id_alm_vs"]);
        $objDateTime = new DateTime('NOW');
        $fecha=$objDateTime->format('c');
        $nom_equipo=mainModel::ejecutar_consulta_simple("select e.nombre_equipo from equipos e where id_equipo = {$fk_idequipo} ")['nombre_equipo'];
        $datospersonal = mainModel::ejecutar_consulta_simple("select  concat(p.nom_per,',',p.Ape_per) as nombres,p.dni_per from personal p where id_per = {$fk_idpersonal} ");
        $nombre_per = $datospersonal['nombres'];
        $dni_per = $datospersonal['dni_per'];
        $datos_referencia = mainModel::limpiar_cadena($_POST["datos_referencia_vale_salida"]);
        $privilegio =  mainModel::limpiar_cadena($_POST["privilegio_sbp_vs"]);

        //Detalle
        $id_ac[]=$_POST["id_ac_vale_salida"];
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
            "dni_per"=>$dni_per,
            "id_alm"=>$id_alm,
            "dr_referencia"=>$datos_referencia
        ];

        $validarPrivilegios=mainModel::privilegios_transact($privilegio);

        if($validarPrivilegios){

            $id_vsalida=almacenModelo::save_vsalida_modelo($datos);
            $id_vsalida=$id_vsalida[0][0];
    
            $validar[0]=mainModel::ejecutar_consulta_simple("SELECT MAX(vs.id_vsalida)FROM vale_salida vs WHERE fk_idalm = {$id_alm};");  
            $validar=$validar[0][0];
            
            if($validar==$id_vsalida){
                $info_dvsalida=almacenModelo::save_dvsalida_modelo($id_vsalida,$id_ac,$dv_descripcion,$dv_nparte1,$dv_stock,$dv_solicitado,$dv_entregado,$dv_unombre,$dv_useccion,$id_alm);
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
                        /*$id_vsalida=mainModel::encryption($id_vsalida);
                        $id_alm=mainModel::encryption($id_alm);*/
                        $datos = ["tipo"=>"success","mensaje"=>"<h5><strong>Vale de salida N°{$id_vsalida}</strong> generado con exito !! haga <a href='../PDFvalesalida/{$id_vsalida}/{$id_alm}' target='_blank' >CLICK AQUI </a> para ver su registro, o la pagina se actualizara en 5s</h5> "];
                        
                        $localStorage = [
                            "BDcomp_gen",
                            "BDproductos",
                            "carritoGen",
                            "carritoIn",
                            "carritoS"
                        ];
    
                        echo mainModel::localstorage_reiniciar($localStorage);
                        echo mainModel::bootstrap_alert($datos);
                        //echo "<script>setTimeout('document.location.reload()',10000)</script>";
                    }
        
                    foreach($info_dvsalida[1] as $i){
                        $mensaje ="El item: | {$i['id_comp']} | {$i['descripcion']} | {$i['nparte1']} | {$i['ubicacion']} | No se registro por desbalance de stock, verificar ";
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
            
            }else{
                $alerta=[
                    "alerta"=>"recargar",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"No hemos podido registrar el vale de salida, contacte al admin",
                    "Tipo"=>"error"
                ];
            }

        }else{

            $alerta=[
                "alerta"=>"recargar",
                "Titulo"=>"Privilegios insuficientes",
                "Texto"=>"Sus privilegios, son solo para vistas",
                "Tipo"=>"info"
            ];
            
        }


        return mainModel::sweet_alert($alerta);

    }

    public function save_vingreso_controlador(){

        $fk_idusuario = mainModel::limpiar_cadena($_POST["usuario"]);
        
        $turno = mainModel::limpiar_cadena($_POST["turno"]);
        
        $ref_documento=mainModel::limpiar_cadena($_POST["ref_documento"]);
        $comentario=mainModel::limpiar_cadena($_POST["comentario"]);
        $id_alm= mainModel::limpiar_cadena($_POST["id_alm_vi"]);
        $objDateTime = new DateTime('NOW');
        $fecha=$objDateTime->format('c');
        $fk_idpersonal = mainModel::limpiar_cadena($_POST["personal"]);
        $documento=mainModel::limpiar_cadena($_POST["documento"]);
        //$fk_idpersonal = ($documento==1)? $fk_idpersonal=$fk_idpersonal:$fk_idpersonal=$fk_idusuario; 
        $privilegio=mainModel::limpiar_cadena($_POST["privilegio_in"]);
        if($documento==1){
            $id_usuario= mainModel::ejecutar_consulta_simple("SELECT fk_idper FROM usuario WHERE id_usu = {$fk_idusuario}");
            $fk_idpersonal = $id_usuario["fk_idper"];
        }
        

        $documento = ($documento==1)? $documento="guia remision":$documento="devolucion";
        $datospersonal = mainModel::ejecutar_consulta_simple("select  concat(p.nom_per,',',p.Ape_per) as nombres,p.dni_per from personal p where id_per = {$fk_idpersonal} ");
        $nombre_per = mainModel::limpiar_cadena($datospersonal['nombres']);
        $dni_per = mainModel::limpiar_cadena($datospersonal['dni_per']);
        
        //Detalle
        $dvi_id_ac[]=$_POST["id_ac_carritoin"];
        //$dvi_codigo[]=$_POST["dv_codigo"];
        $dvi_descripcion[]=$_POST["dv_descripcion"];
        $dvi_nparte1[]=$_POST["dv_nparte1"];
        $dvi_stock[]=$_POST["dv_stock"];
        $dvi_ingreso[]=$_POST["dv_ingreso"];
        $dvi_fkid_equipo[]=$_POST["dv_id_equipo"];
        $dvi_nom_equipo[]=$_POST["dv_nom_equipo"];
        $dvi_referencia[]=$_POST["dv_referencia"];

        
        $datos = [
            "fk_idusuario"=>$fk_idusuario,
            "fk_idpersonal"=>$fk_idpersonal,
            "turno"=>$turno,
            "documento"=>$documento,
            "ref_documento"=>$ref_documento,
            "comentario"=>$comentario,
            "fecha"=>$fecha,
            "nombre_per"=>$nombre_per,
            "dni_per"=>$dni_per,
            "id_alm"=>$id_alm
        ];

        //VALIDAR PRIVILEGIO
        
        $validarPrivilegios=mainModel::privilegios_transact($privilegio);

        if($validarPrivilegios){

            $id_vingreso=almacenModelo::save_vingreso_modelo($datos);
            $id_vingreso = $id_vingreso[0][0];

            $validar[0]=mainModel::ejecutar_consulta_simple("SELECT MAX(vs.id_vingreso)
            FROM vale_ingreso vs WHERE fk_idalm = {$id_alm};");  

            $validar=$validar[0][0];

            if($validar==$id_vingreso){

                $ingreso=almacenModelo::save_dvingreso_modelo($id_vingreso,$dvi_id_ac,$dvi_descripcion,$dvi_nparte1,$dvi_stock,$dvi_ingreso,$dvi_nom_equipo,$dvi_fkid_equipo,$id_alm,$dvi_referencia);
                if($id_vingreso!=0){
                    if($ingreso->rowCount()>0){
                        $alerta=[
                            "alerta"=>"recargar_tiempo",
                            "Titulo"=>"Vale Ingreso N°{$id_vingreso} generado! ",
                            "Texto"=>"Los siguientes datos han sido guardados",
                            "Tipo"=>"success",
                            "tiempo"=>5000
                        ];
                        $datos = ["tipo"=>"success","mensaje"=>"<h5><strong>Vale de ingreso N°{$id_vingreso}</strong> generado con exito !! haga <a href='../PDFvaleingreso/{$id_vingreso}/{$id_alm}' target='_blank' >CLICK AQUI </a>para ver su registro, o la pagina se actualizara en 5s</h5> "];
                        
                        
                        $localStorage = [
                            "BDcomp_gen",
                            "BDproductos",
                            "carritoGen",
                            "carritoIn",
                            "carritoS"
                        ];

                        echo mainModel::localstorage_reiniciar($localStorage);
                        echo mainModel::bootstrap_alert($datos);
                    }else {
                        $alerta=[
                            "alerta"=>"simple",
                            "Titulo"=>"Ocurrio un error inesperado",
                            "Texto"=>"No hemos podido registrar el vale de ingreso, contacte al admin",
                            "Tipo"=>"error"
                        ];
                    }   
                    
                }else{
                    $alerta=[
                        "alerta"=>"simple",
                        "Titulo"=>"Ocurrio un error inesperado",
                        "Texto"=>"No hemos podido registrar el vale de ingreso, contacte al admin",
                        "Tipo"=>"error"
                    ];
                }
            }else{
                $alerta=[
                    "alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"No hemos podido registrar el vale de ingreso, contacte al admin",
                    "Tipo"=>"error"
                ];

            }

        }else{
            
            $alerta=[
                "alerta"=>"recargar",
                "Titulo"=>"Privilegios insuficientes",
                "Texto"=>"Sus privilegios, son solo para vistas",
                "Tipo"=>"info"
            ];
        }
        return mainModel::sweet_alert($alerta);
    }

    public function save_registro_almacen_controlador(){

       /* $id_comp = mainModel::limpiar_cadena($_POST["id_comp"]);
        //$d_descripcion = mainModel::limpiar_cadena($_POST["d_descripcion"]);
        $d_u_nom = mainModel::limpiar_cadena($_POST["d_u_nom"]);
        $d_u_sec = mainModel::limpiar_cadena($_POST["d_u_sec"]);
        $d_id_equipo = mainModel::limpiar_cadena($_POST["d_id_equipo"]);
        $d_referencia = mainModel::limpiar_cadena($_POST["d_referencia"]);*/
        
        $id_alm= mainModel::limpiar_cadena($_POST["id_alm_frmIA"]);
        $privilegio= mainModel::limpiar_cadena($_POST["privilegio_sbp_ia"]);
        $id_comp[] = $_POST["id_comp"];
        $d_nserie[] = $_POST["d_nserie"];
        $d_descripcion[] = $_POST["d_descripcion"];
        $d_stock = 0;
        $d_u_nom[] = $_POST["d_u_nom"];
        $d_u_sec[] = $_POST["d_u_sec"];
        $d_id_equipo[] = $_POST["d_id_equipo"];
        $d_referencia[] = $_POST["d_referencia"];


        $validarPrivilegios=mainModel::privilegios_transact($privilegio);

        if($validarPrivilegios){

            $validar=almacenModelo::save_registro_almacen_modelo($id_comp,$d_u_nom,$d_nserie,$d_descripcion,$d_u_sec,$d_id_equipo,$d_referencia,$id_alm,$d_stock);
            $val_registro=($validar[0]!='')?$val_registro=$validar[0]->rowCount():$val_registro=0;

            if($val_registro==0){

                foreach($validar[1] as $i){
                    $mensaje ="El item: | {$i['id_comp']} | {$i['descripcion']} | NS: {$i['nserie']} | ya se encuentra registrado en su almacen, no puede repetirse, Verificar!";
                    $datos = [
                        "tipo"=>"danger",
                        "mensaje"=>"$mensaje"
                    ];
                    echo mainModel::bootstrap_alert($datos);
                }

            }else{
                if($validar[0]->rowCount()>0){
                    $alerta=[
                        "alerta"=>"recargar",
                        "Titulo"=>"Componentes registrados",
                        "Texto"=>"Registrados en su almacen",
                        "Tipo"=>"success"
                        
                    ];
                    
                    $localStorage = [
                        "carritoGen",
                    ];
                    echo mainModel::localstorage_reiniciar($localStorage);

                    foreach($validar[1] as $i){
                        $mensaje ="El item: | {$i['id_comp']} | {$i['descripcion']} | NS: {$i['nserie']} | ya se encuentra registrado en su almacen, no puede repetirse";
                        $datos = [
                            "tipo"=>"danger",
                            "mensaje"=>"$mensaje"
                        ];
                        echo mainModel::bootstrap_alert($datos);
                    }
        
                }else{
                    $alerta=[
                        "alerta"=>"simple",
                        "Titulo"=>"Ocurrio un error inesperado",
                        "Texto"=>"No hemos podido registrar el componente seleccionado",
                        "Tipo"=>"error"
                    ];
                    
                }
                return mainModel::sweet_alert($alerta);
            }
        }else{
            $alerta=[
                "alerta"=>"recargar",
                "Titulo"=>"Privilegios insuficientes",
                "Texto"=>"Sus privilegios, son solo para vistas",
                "Tipo"=>"info"
            ];

            return mainModel::sweet_alert($alerta);
        }
            
        

    }

    public function delete_componente_almacen_controlador(){

        
        $id_ac = mainModel::limpiar_cadena($_POST["id_ac_del"]);
        $id_comp = mainModel::limpiar_cadena($_POST["id_comp_del"]);
        $id_alm = mainModel::limpiar_cadena($_POST["id_alm_del"]);
        
        
        $validar=almacenModelo::delete_componente_almacen_modelo($id_ac,$id_comp,$id_alm);
        
        if($validar->rowCount()>0){
            $alerta=[
                "alerta"=>"recargar",
                "Titulo"=>"Eliminado",
                "Texto"=>"El componente ha sido eliminado de su almacen",
                "Tipo"=>"success"
            ];
        }else{
            $alerta=[
                "alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"El componente, no ha sido eliminado",
                "Tipo"=>"error"
            ];
        } 

        return mainModel::sweet_alert($alerta);
    }
    public function obtener_consulta_json_controlador($consulta){
        return mainModel::obtener_consulta_json($consulta);
    }

   /* public function obtener_consulta_json_controlador($id_alm){
           
        $consulta = "SELECT ac.id_ac,c.id_comp,c.descripcion,c.nparte1,
        c.nparte2,c.nparte3,c.unidad_med,ac.stock,ac.fk_idalm,ac.u_nombre,ac.u_seccion,e.Nombre_Equipo,e.Id_Equipo
        FROM componentes c
        INNER JOIN almacen_componente ac ON ac.fk_idcomp = c.id_comp 
        INNER JOIN equipos e  ON e.Id_Equipo = ac.fk_idequipo 
        WHERE ac.fk_idalm = {$id_alm} ";
        return mainModel::obtener_consulta_json($consulta);

    }*/

    /********** REPORTES  - VISTA REPOTEALMACEN *******/

    public function reporte_valesalida_simple_controlador($idvs,$idalm,$formato,$privilegio){
        $SERVERURL=SERVERURL;
        $template = "";
        $conexion = mainModel::conectar();
        if($formato == "ticket"){
            $resp = $conexion->prepare("SELECT vs.id_vsalida, vs.nombres,vs.d_identidad,DATE(vs.fecha) AS fecha,TIME(vs.fecha) AS hora,vs.turno,vs.nom_equipo,
            vs.horometro,vs.comentario,a.Alias,u.Nombre,u.Apellido,vs.dr_referencia
            FROM vale_salida vs
            INNER JOIN almacen a ON 
            a.id_alm = vs.fk_idalm
            INNER JOIN usuario u ON
            u.id_usu = vs.fk_idusuario              
            WHERE id_vsalida = {$idvs} AND fk_idalm = {$idalm}");
            $resp->execute();
            $resp=$resp->fetchAll();

            $resp_dv = $conexion->prepare("SELECT c.id_comp,dvs.dv_descripcion,dvs.dv_nparte1,dvs.dv_stock,dvs.dv_solicitado,
            dvs.dv_entregado
            FROM detalle_vale_salida dvs
            INNER JOIN almacen_componente ac
            ON ac.id_ac = dvs.fk_id_ac
            INNER JOIN componentes c
            ON c.id_comp = ac.fk_idcomp 
            WHERE dvs.fk_vsalida = {$idvs} AND dvs.fk_id_almacen = {$idalm}");

            $resp_dv->execute();
            $resp_dv=$resp_dv->fetchAll();

            foreach($resp as $row){
                $template .="
            <html>
                <head>
                    <title>vale salida #{$row["id_vsalida"]}</title>  
                </head>
                <body>
                    <div class='ticket'>
                        <img
                            src='{$SERVERURL}vistas/img/conmiciv.png'
                            alt='Logotipo'>
                      
                        <p class='centrado'>
                        VALE DE SALIDA #0{$row["id_vsalida"]}
                        <br>
                        <br>".mainModel::dateFormat($row["fecha"])." | {$row["hora"]}
                        <br>{$row["nom_equipo"]} | {$row["horometro"]} hrs
                        <br>{$row["dr_referencia"]}
                        <br>{$row["Alias"]}
                        </p>
                        <table>
                            <thead>
                                <tr>
                                    <th class='codigo'>COD.</th>
                                    <th class='producto'>PRODUCTO</th>
                                    <th class='nparte'>NPARTE</th>
                                    <th class='cantidad'>STOCK</th>
                                    <th class='cantidad'>SOL</th>
                                    <th class='cantidad'>SAL</th>
                                </tr>
                            </thead>
                            <tbody>";
                            foreach($resp_dv as $row_dv){
                                    
                                $template .="
                                    <tr>
                                        <td class='codigo'>{$row_dv["id_comp"]}</td>
                                        <td class='producto'>{$row_dv["dv_descripcion"]}</td>
                                        <td class='nparte'>{$row_dv["dv_nparte1"]}</td>
                                        <td class='cantidad'>{$row_dv["dv_stock"]}</td>
                                        <td class='cantidad'>{$row_dv["dv_solicitado"]}</td>
                                        <td class='cantidad'>{$row_dv["dv_entregado"]}</td>
                                    </tr>";
                            }
                        

                            $template .="
                            </tbody>
                        </table>
                        <p class='centrado'>{$row["comentario"]}</p>
                        <br>
                        <p class='firma'>
                        <hr/>
                        <br>Solicitante: {$row["nombres"]}</p>
                        <p class='centrado'>Atendido por: {$row["Nombre"]},{$row["Apellido"]}</p>
                    </div>
                </body>
            </html>";
            }
        }else if($formato=="vista_simple"){

            $resp = $conexion->prepare("SELECT vs.id_vsalida, vs.nombres,vs.d_identidad,DATE(vs.fecha) AS fecha,TIME(vs.fecha) AS hora,vs.turno,
            vs.nom_equipo,vs.horometro,vs.comentario,a.Alias,u.Nombre,u.Apellido
            FROM vale_salida vs
            INNER JOIN almacen a ON 
            a.id_alm = vs.fk_idalm
            INNER JOIN usuario u ON
            u.id_usu = vs.fk_idusuario              
            WHERE fk_idalm = {$idalm} AND vs.est=1 ORDER BY vs.id_vsalida DESC ");
            $resp->execute();
            $resp=$resp->fetchAll();
            $contador=1;
            foreach($resp as $row){

                $template .="
                <tr>
                    <td>{$contador}</td>
                    <td>{$row['id_vsalida']}</td>
                    <td>". mainModel::dateFormat($row['fecha']) ."</td>
                    <td>{$row['hora']}</td>
                    <td>{$row['nom_equipo']}</td>
                    <td>{$row['horometro']}</td>
                    <td>{$row['nombres']}</td>
                    <td>{$row['Nombre']}, {$row["Apellido"]}</td>
                    <td><a style='font-size: 2em;' href='../PDFvalesalida/{$row["id_vsalida"]}/{$idalm}' target='_blank' ><i class='fas fa-ticket-alt'></i></a></td>";
                    if($privilegio==0 or $privilegio==1){
                    $template .="     
                    <td>
                        <form name='FrmAnularVS' action='".SERVERURL."ajax/almacenAjax.php' method='POST' class='FormularioAjax' data-form='anular' entype='multipart/form-data' autocomplete='off'>
                            <input type='hidden' name='id_vsalida_anular' value='{$row['id_vsalida']}' />
                            <button type='submit' class='btn btn-danger'><i class='fas fa-ban'></i></button>
                            <div class='RespuestaAjax'></div>
                        </form>
                    </td>";
                    }
                $template .="
                </tr>
                ";
                $contador++;
            }
        }

        return $template;

    }

    public function reporte_valeingreso_simple_controlador($idvi,$idalm,$formato,$privilegio){
        $SERVERURL=SERVERURL;
        $template = "";
        $conexion = mainModel::conectar();

        if($formato == "ticket"){
            $resp = $conexion->prepare("SELECT vi.id_vingreso, DATE(vi.fecha) AS fecha ,TIME(vi.fecha) as hora,vi.turno,vi.ref_documento,vi.ref_nrodocumento,
            vi.nombres,u.Nombre,u.Apellido,a.Alias,vi.comentario
            FROM vale_ingreso vi
            INNER JOIN almacen a ON 
            a.id_alm = vi.fk_idalm
            INNER JOIN usuario u ON
            u.id_usu = vi.fk_idusuario             
            WHERE id_vingreso = {$idvi} AND fk_idalm = {$idalm}");
            $resp->execute();
            $resp=$resp->fetchAll();

            $resp_dv = $conexion->prepare("SELECT c.id_comp,dvi.dvi_descripcion ,dvi.dvi_nparte1,dvi.dvi_stock,dvi.dvi_ingreso,
            dvi.dvi_nombre_equipo,dvi.dr_referencia
            FROM detalle_vale_ingreso dvi
            INNER JOIN almacen_componente ac
            ON ac.id_ac = dvi.fk_id_ac
            INNER JOIN componentes c
            ON c.id_comp = ac.fk_idcomp 
            WHERE fk_id_vingreso = {$idvi} AND fk_id_almacen = {$idalm}");

            $resp_dv->execute();
            $resp_dv=$resp_dv->fetchAll();
           
            foreach($resp as $row){
                $template .="
            <html>
                <head>
                    <title>vale ingreso #{$row["id_vingreso"]}</title>  
                </head>
                <body>
                    <div class='ticket'>
                        <img
                            src='{$SERVERURL}vistas/img/conmiciv.png'
                            alt='Logotipo'>
                        
                        <p class='centrado'>
                        VALE DE INGRESO #0{$row["id_vingreso"]}
                        <br>
                        <br>".mainModel::dateFormat($row["fecha"])." | {$row["hora"]}
                        <br>{$row["ref_documento"]} : {$row["ref_nrodocumento"]}
                        
                        <br>{$row["Alias"]}
                        </p>
                        <table>
                            <thead>
                                <tr>
                                    <th class='codigo'>COD.</th>
                                    <th class='producto'>PRODUCTO</th>
                                    <th class='nparte'>NPARTE</th>
                                    <th class='cantidad'>ING.</th>
                                    <th class='cantidad'>EQUIPO</th>
                                    <th class='cantidad'>REF.</th>
                                </tr>
                            </thead>
                            <tbody>";
                            foreach($resp_dv as $row_dv){      
                                $template .="
                                    <tr>
                                        <td class='codigo'>{$row_dv["id_comp"]}</td>
                                        <td class='producto'>{$row_dv["dvi_descripcion"]}</td>
                                        <td class='nparte'>{$row_dv["dvi_nparte1"]}</td>
                                        <td class='cantidad'>{$row_dv["dvi_ingreso"]}</td>
                                        <td class='cantidad'>{$row_dv["dvi_nombre_equipo"]}</td>
                                        <td class='cantidad'>{$row_dv["dr_referencia"]}</td>
                                    </tr>";
                            }
                            $template .="
                            </tbody>
                        </table>
                        
                        <p class='centrado'>{$row["comentario"]}</p>
                        <br>
                        <p class='firma'>
                        <hr/>
                        <br>Personal que lo ingresa :{$row["nombres"]}</p>
                        
                        <p class='centrado' >Registrado por: {$row["Nombre"]}, {$row["Apellido"]}</p>
                        
                       
                    </div>
                </body>
            </html>";
            }
        }else if($formato=="vista_simple"){
            $resp = $conexion->prepare("SELECT vi.id_vingreso, DATE(vi.fecha) AS fecha ,TIME(vi.fecha) as hora,vi.ref_documento,vi.ref_nrodocumento,
            vi.nombres,u.Nombre,u.Apellido
            FROM vale_ingreso vi
            INNER JOIN almacen a ON 
            a.id_alm = vi.fk_idalm
            INNER JOIN usuario u ON
            u.id_usu = vi.fk_idusuario             
            WHERE  fk_idalm = {$idalm} AND vi.est=1 ORDER BY vi.id_vingreso DESC");
            $resp->execute();
            $resp=$resp->fetchAll();
            $contador=1;
            foreach($resp as $row){
                $template .=" 
                <tr>
                    <td>{$contador}</td>
                    <td>{$row['id_vingreso']}</td>
                    <td>". mainModel::dateFormat($row['fecha']) ."</td>
                    <td>{$row['hora']}</td>
                    <td>{$row['ref_documento']}</td>
                    <td>{$row['ref_nrodocumento']}</td>
                    <td>{$row['nombres']}</td>
                    <td>{$row['Nombre']}, {$row["Apellido"]}</td>
                    <td><a style='font-size: 2em;' href='../PDFvaleingreso/{$row["id_vingreso"]}/{$idalm}' target='_blank' ><i class='fas fa-ticket-alt'></i></a></td>";
                    if($privilegio==0 or $privilegio==1){
                    $template .=" 
                    <td>
                        <form action='".SERVERURL."ajax/almacenAjax.php' method='POST' class='FormularioAjax' data-form='anular' entype='multipart/form-data' autocomplete='off'>
                            <input type='hidden' name='id_vingreso_anular' value='{$row['id_vingreso']}' />
                            <button type='submit' class='btn btn-danger'><i class='fas fa-ban'></i></button>
                            <div class='RespuestaAjax'></div>
                        </form>
                    </td>";
                    }
                $template .=" 
                </tr>        
                ";
                $contador++;
            }

        }
        return $template;

    }

    public function anular_vsalida_controlador(){
        $id_vsalida = mainModel::limpiar_cadena($_POST["id_vsalida_anular"]);

        $validar=almacenModelo::anular_vsalida_modelo($id_vsalida);

        if($validar->rowCount()>0){
            $alerta=[
                "alerta"=>"recargar",
                "Titulo"=>"Vale salida N°{$id_vsalida} anulado",
                "Texto"=>"Los siguientes ha sido anulados ",
                "Tipo"=>"success"
            ];
        }else{
            $alerta=[
                "alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"No hemos podido actualizar el ticket seleccionado",
                "Tipo"=>"error"
            ];
        }

        return mainModel::sweet_alert($alerta);


    }

    public function anular_vingreso_controlador(){


        $id_vingreso = mainModel::limpiar_cadena($_POST["id_vingreso_anular"]);

        $validar=almacenModelo::anular_vingreso_modelo($id_vingreso);

        if($validar->rowCount()>0){
            $alerta=[
                "alerta"=>"recargar",
                "Titulo"=>"Vale de ingreso N°{$id_vingreso} anulado",
                "Texto"=>"Los siguientes ha sido anulados ",
                "Tipo"=>"success"
            ];
        }else{
            $alerta=[
                "alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"No hemos podido actualizar el ticket seleccionado",
                "Tipo"=>"error"
            ];
        }

        return mainModel::sweet_alert($alerta);
        
    }

    /********FIN REPORTES  ****/

    public function sesion_almacen($id_alm,$nombre_almacen){
        $_SESSION["almacen"]=$id_alm;
        $_SESSION["nom_almacen"]=$nombre_almacen;
    }

    public function logout_almacen(){
        $_SESSION["almacen"]=0;
        $_SESSION["nom_almacen"]="";
    }
    

    public function combo_personal($val,$vis){
        $consulta = "select p.id_per, CONCAT(p.Nom_per,',',p.Ape_per,'-',p.Dni_per)
        from personal p";
        return mainModel::ejecutar_combo($consulta,$val,$vis);
    }

    //EN DESUSO SE ELIMINAR EN CUANTO SE REPASE EL CODIGO
    public function combo_equipo($val,$vis){
        $consulta = "select e.Id_Equipo,e.Nombre_Equipo
        from equipos e WHERE e.Estado='si' and Id_Equipo != 1 ";
        return mainModel::ejecutar_combo($consulta,$val,$vis);
    }

    public function select_combo($consulta,$val,$vis){
        return mainModel::ejecutar_combo($consulta,$val,$vis);
    }
    public function combo_DR($val,$vis){
        $consulta = "select * from datos_referencia WHERE id_dr !=1";
        return mainModel::ejecutar_combo($consulta,$val,$vis);
    }

    
}   


?>