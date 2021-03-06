<?php

if($peticionAjax){
    require_once '../modelos/almacenModelo.php';
}else{
    require_once './modelos/almacenModelo.php';
}

Class almacenControlador extends almacenModelo {
    
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
            "fk_idflota"=>$equipo,
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


    public function paginador_kardex($paginador,$registros,$privilegio,$buscador,$vista,$id_alm,$unidad,$fecha_ini,$fecha_fin){
        
        $paginador=mainModel::limpiar_cadena($paginador);
        $registros=mainModel::limpiar_cadena($registros);
        $privilegio=mainModel::limpiar_cadena($privilegio);
        $buscador=mainModel::limpiar_cadena($buscador);
        $vista=mainModel::limpiar_cadena($vista);
        $unidad=mainModel::limpiar_cadena($unidad);
        $id_alm=mainModel::limpiar_cadena($id_alm);
  

        $paginador=(isset($paginador) && $paginador>0)?(int)$paginador:1; 
        $inicio=($paginador>0)?(($paginador*$registros)-$registros):0;

        $tabla='';
        $conexion = mainModel::conectar();

        if($buscador !=0){
            $datos=$conexion->query("SELECT SQL_CALC_FOUND_ROWS k.fecha,k.tipo,k.numero,k.codigo,c.descripcion,c.nparte1,k.entrada,k.salida,k.saldo,
            eu.alias_equipounidad,k.cambio,k.fk_idper,k.fk_idusu
            FROM kardex_almacen k
            INNER JOIN componentes c
            ON c.id_comp = k.codigo
            INNER JOIN equipo_unidad eu
            ON eu.id_equipounidad = k.fk_idflota
            WHERE c.id_comp = {$buscador} AND k.fk_idalm = {$id_alm}  AND date(k.fecha) BETWEEN '{$fecha_ini}' and '{$fecha_fin}'
            order by fecha desc LIMIT {$inicio},{$registros}");


        }else{
            $datos=$conexion->query("SELECT SQL_CALC_FOUND_ROWS k.fecha,k.tipo,k.numero,k.codigo,c.descripcion,c.nparte1,k.entrada,k.salida,k.saldo,
            eu.alias_equipounidad,k.cambio,k.fk_idper,k.fk_idusu
            FROM kardex_almacen k
            INNER JOIN componentes c
            ON c.id_comp = k.codigo
            INNER JOIN equipo_unidad eu
            ON eu.id_equipounidad = k.fk_idflota
            WHERE k.fk_idalm = '{$id_alm}'
            order by fecha desc LIMIT {$inicio},{$registros}");
        }

        $datos = $datos->fetchAll();
        $total = $conexion->query("SELECT FOUND_ROWS()");
        $total = (int)$total->fetchColumn();
        $Npaginas = ceil($total/$registros);
        $i=$inicio+1;
        $tabla.="     
        <div class='table-responsive-sm'>
            <table class='table'>
                <thead class='thead-light'>
                    <tr>
                        <th scope='col'>#</th>
                        <th scope='col'>fecha y hora trans.</th>
                        <th scope='col'>Tipo transaccion</th>
                        <th scope='col'>Numero</th>
                        <th scope='col'>Codigo</th>
                        <th scope='col'>Producto</th>
                        <th scope='col'>N° parte</th>
                        <th scope='col'>Entrada</th>
                        <th scope='col'>Salida</th>
                        <th scope='col'>Saldo</th>
                        <th scope='col'>Equipo</th>
                    </tr>
                </thead>
                <tbody id='contenido_kardex'>         
       ";

        if($total>=1 && $paginador<=$Npaginas)
        {   
            foreach($datos as $row){
                $badge=mainModel::badge_color($row['tipo']);
                $tabla.="
                <tr>
                    <th scope='row'>{$i}</th>  
                    <td>{$row['fecha']}</td>
                    <td><span class='badge badge-{$badge}'>{$row['tipo']} </span></td>
                    <td>{$row['numero']}</td>
                    <td>{$row['codigo']}</td>
                    <td>{$row['descripcion']}</td>
                    <td>{$row['nparte1']}</td>
                    <td>{$row['entrada']}</td>
                    <td>{$row['salida']}</td>
                    <td>{$row['saldo']}</td>
                    <td>{$row['alias_equipounidad']}</td>
                </tr>";
                $i++;
            }
        }else{
            $tabla.='
            <tr><td colspan="10"> No existen registros</td></tr>';        
        }

        $tabla.='
        </tbody>
        </table>
        </div>';

        $tabla.= mainModel::paginador_ajax($total,$paginador,$Npaginas,$vista);
        
        return $tabla;


    }
    public function validar_paginador_controlador($buscador,$vista,$eliminar_buscador){
        return mainModel::validar_paginador($buscador,$vista,$eliminar_buscador);
    }


    public function paginador_log_in_out($paginador,$registros,$privilegio,$buscador,$vista,$id_alm,$tipo,$filtros){
        $paginador=mainModel::limpiar_cadena($paginador);
        $registros=mainModel::limpiar_cadena($registros);
        $privilegio=mainModel::limpiar_cadena($privilegio);
        $buscador=mainModel::limpiar_cadena($buscador);
        $tipo=mainModel::limpiar_cadena($tipo);
        $filtros=mainModel::limpiar_cadena($filtros);
        $tabla='';
        $paginador=(isset($paginador) && $paginador>0)?(int)$paginador:1; 
        $inicio=($paginador>0)?(($paginador*$registros)-$registros):0;

        $conexion = mainModel::conectar();

        $filtros = explode(",",$filtros);
        /*$codigoF= $filtros[0];
        $equipoF= $filtros[1];
        $referenciaF= $filtros[2];*/
        $fecha_ini= $filtros[3];
        $fecha_fin= $filtros[4];
        $switch = $filtros[5];

        //SI VISTA ES PDF, se elimina el limit pero si la vista es html, se considera el limit para el paginado
        //Solo validado para filtro ($switch==true)
        $limit=(substr($vista,0,3)=='PDF')?$limit="":$limit="LIMIT {$inicio},{$registros}";

        if($tipo=='ambos' or $tipo==""){
            if($switch=='false'){
                if($buscador!=""){
                    $datos=$conexion->query("SELECT SQL_CALC_FOUND_ROWS 'salida','danger',vs.id_vsalida as vale,ac.fk_idcomp,dvs.dv_descripcion as descripcion,dvs.dv_nparte1 as nparte1,
                    DATE(vs.fecha) AS fecha ,TIME(vs.fecha) as hora,eu.alias_equipounidad as nom_equipo,vs.dr_referencia,vs.nombres,dvs.dv_entregado as cantidad,
                    CONCAT(u.Nombre,' ',u.Apellido) as usuario
                    FROM almacen_componente ac
                    INNER JOIN detalle_vale_salida dvs ON dvs.fk_id_ac = ac.id_ac
                    INNER JOIN vale_salida vs ON vs.id_vsalida = dvs.fk_vsalida
                    INNER JOIN usuario u ON u.id_usu = vs.fk_idusuario
                    INNER JOIN equipo_unidad eu ON eu.id_equipounidad = dvs.fk_idflota 
                    WHERE (dvs.dv_descripcion like '%$buscador%' or dvs.dv_nparte1 like '%$buscador%' or ac.fk_idcomp like '%$buscador%') AND
                    vs.fk_idalm={$id_alm} AND dvs.fk_id_almacen={$id_alm}  AND  vs.est = 1 
                    UNION
                    SELECT 'ingreso','success',vi.id_vingreso as vale,ac.fk_idcomp,dvi.dvi_descripcion as descripcion,dvi.dvi_nparte1 as nparte1,
                    DATE(vi.fecha) AS fecha ,TIME(vi.fecha) as hora,dvi.dvi_nombre_equipo as nom_equipo,dvi.dr_referencia,vi.nombres,dvi.dvi_ingreso as cantidad,
                    CONCAT(u.Nombre,' ',u.Apellido) as usuario
                    FROM almacen_componente ac
                    INNER JOIN detalle_vale_ingreso dvi ON dvi.fk_id_ac = ac.id_ac
                    INNER JOIN vale_ingreso vi ON vi.id_vingreso = dvi.fk_id_vingreso
                    INNER JOIN usuario u ON u.id_usu = vi.fk_idusuario
                    WHERE (dvi.dvi_descripcion LIKE '%$buscador%' OR dvi.dvi_nparte1 LIKE '%$buscador%' OR ac.fk_idcomp like '%$buscador%') AND 
                    vi.fk_idalm = {$id_alm} AND dvi.fk_id_almacen={$id_alm} AND vi.est = 1
                    ORDER BY fecha DESC, hora DESC  LIMIT {$inicio},{$registros}");
                    
                }else{
                    $datos=$conexion->query("SELECT SQL_CALC_FOUND_ROWS 'salida','danger',vs.id_vsalida as vale,ac.fk_idcomp,dvs.dv_descripcion as descripcion,dvs.dv_nparte1 as nparte1,
                    DATE(vs.fecha) AS fecha ,TIME(vs.fecha) as hora,eu.alias_equipounidad as nom_equipo,vs.dr_referencia,vs.nombres,dvs.dv_entregado as cantidad,
                    CONCAT(u.Nombre,' ',u.Apellido) as usuario
                    FROM almacen_componente ac
                    INNER JOIN detalle_vale_salida dvs ON dvs.fk_id_ac = ac.id_ac
                    INNER JOIN vale_salida vs ON vs.id_vsalida = dvs.fk_vsalida
                    INNER JOIN usuario u ON u.id_usu = vs.fk_idusuario
                    INNER JOIN equipo_unidad eu ON eu.id_equipounidad = dvs.fk_idflota 
                    WHERE vs.fk_idalm={$id_alm} AND dvs.fk_id_almacen={$id_alm} AND vs.est = 1 
                    UNION
                    SELECT 'ingreso','success',vi.id_vingreso as vale,ac.fk_idcomp,dvi.dvi_descripcion as descripcion ,dvi.dvi_nparte1 as nparte1,
                    DATE(vi.fecha) AS fecha ,TIME(vi.fecha) as hora,dvi.dvi_nombre_equipo as nom_equipo,dvi.dr_referencia,vi.nombres,dvi.dvi_ingreso as cantidad,
                    CONCAT(u.Nombre,' ',u.Apellido) as usuario
                    FROM almacen_componente ac
                    INNER JOIN detalle_vale_ingreso dvi ON dvi.fk_id_ac = ac.id_ac
                    INNER JOIN vale_ingreso vi ON vi.id_vingreso = dvi.fk_id_vingreso
                    INNER JOIN usuario u ON u.id_usu = vi.fk_idusuario
                    WHERE vi.fk_idalm = {$id_alm} AND dvi.fk_id_almacen={$id_alm} AND vi.est = 1
                    ORDER BY fecha DESC, hora DESC  LIMIT {$inicio},{$registros}");  
                }
            }else{
                $condiciones = $this->condicionales($tipo,$filtros);                
                $datos=$conexion->query("SELECT SQL_CALC_FOUND_ROWS 'salida','danger',vs.id_vsalida as vale,ac.fk_idcomp,dvs.dv_descripcion as descripcion,dvs.dv_nparte1 as nparte1,
                DATE(vs.fecha) AS fecha ,TIME(vs.fecha) as hora,eu.alias_equipounidad as nom_equipo,vs.dr_referencia,vs.nombres,dvs.dv_entregado as cantidad,
                CONCAT(u.Nombre,' ',u.Apellido) as usuario
                FROM almacen_componente ac
                INNER JOIN detalle_vale_salida dvs ON dvs.fk_id_ac = ac.id_ac
                INNER JOIN vale_salida vs ON vs.id_vsalida = dvs.fk_vsalida
                INNER JOIN usuario u ON u.id_usu = vs.fk_idusuario
                INNER JOIN equipo_unidad eu ON eu.id_equipounidad = dvs.fk_idflota 
                WHERE vs.fk_idalm={$id_alm} AND dvs.fk_id_almacen={$id_alm}  AND vs.est = 1 {$condiciones[1]} AND date(fecha) between '{$fecha_ini}' and '{$fecha_fin}'
                UNION
                SELECT 'ingreso','success',vi.id_vingreso as vale,ac.fk_idcomp,dvi.dvi_descripcion as descripcion ,dvi.dvi_nparte1 as nparte1,
                DATE(vi.fecha) AS fecha ,TIME(vi.fecha) as hora,dvi.dvi_nombre_equipo as nom_equipo,dvi.dr_referencia,vi.nombres,dvi.dvi_ingreso as cantidad,
                CONCAT(u.Nombre,' ',u.Apellido) as usuario
                FROM almacen_componente ac
                INNER JOIN detalle_vale_ingreso dvi ON dvi.fk_id_ac = ac.id_ac
                INNER JOIN vale_ingreso vi ON vi.id_vingreso = dvi.fk_id_vingreso
                INNER JOIN usuario u ON u.id_usu = vi.fk_idusuario
                WHERE vi.fk_idalm = {$id_alm} AND dvi.fk_id_almacen={$id_alm} AND vi.est = 1 {$condiciones[0]} AND date(fecha) between '{$fecha_ini}' and '{$fecha_fin}'
                ORDER BY fecha DESC, hora DESC  
                {$limit}");  
            }


        }
        if($tipo=='salida'){
            if($switch=='false'){
                if($buscador!=""){
                    $datos=$conexion->query("SELECT SQL_CALC_FOUND_ROWS 'salida','danger',vs.id_vsalida as vale,ac.fk_idcomp,dvs.dv_descripcion as descripcion,dvs.dv_nparte1 as nparte1,
                    DATE(vs.fecha) AS fecha ,TIME(vs.fecha) as hora,eu.alias_equipounidad as nom_equipo,vs.dr_referencia,vs.nombres,dvs.dv_entregado as cantidad,
                CONCAT(u.Nombre,' ',u.Apellido) as usuario
                FROM almacen_componente ac
                INNER JOIN detalle_vale_salida dvs ON dvs.fk_id_ac = ac.id_ac
                INNER JOIN vale_salida vs ON vs.id_vsalida = dvs.fk_vsalida
                INNER JOIN usuario u ON u.id_usu = vs.fk_idusuario
                INNER JOIN equipo_unidad eu ON eu.id_equipounidad = dvs.fk_idflota 
                WHERE (dvs.dv_descripcion like '%$buscador%' or dvs.dv_nparte1 like '%$buscador%' or ac.fk_idcomp like '%$buscador%') AND
                vs.fk_idalm={$id_alm} AND dvs.fk_id_almacen={$id_alm} AND vs.est = 1 
                ORDER BY fecha DESC, hora DESC  LIMIT {$inicio},{$registros}");
                    
                }else{
                $datos=$conexion->query("SELECT SQL_CALC_FOUND_ROWS 'salida','danger',vs.id_vsalida as vale,ac.fk_idcomp,dvs.dv_descripcion as descripcion,dvs.dv_nparte1 as nparte1,
                DATE(vs.fecha) AS fecha ,TIME(vs.fecha) as hora,eu.alias_equipounidad as nom_equipo,vs.dr_referencia,vs.nombres,dvs.dv_entregado as cantidad,
                CONCAT(u.Nombre,' ',u.Apellido) as usuario
                FROM almacen_componente ac
                INNER JOIN detalle_vale_salida dvs ON dvs.fk_id_ac = ac.id_ac
                INNER JOIN vale_salida vs ON vs.id_vsalida = dvs.fk_vsalida
                INNER JOIN usuario u ON u.id_usu = vs.fk_idusuario
                INNER JOIN equipo_unidad eu ON eu.id_equipounidad = dvs.fk_idflota 
                WHERE vs.fk_idalm={$id_alm} AND dvs.fk_id_almacen={$id_alm}  AND vs.est = 1 
                ORDER BY fecha DESC, hora DESC  LIMIT {$inicio},{$registros}");
                }
            }else{
                $condiciones = $this->condicionales($tipo,$filtros); 
                $datos=$conexion->query("SELECT SQL_CALC_FOUND_ROWS 'salida','danger',vs.id_vsalida as vale,ac.fk_idcomp,dvs.dv_descripcion as descripcion,dvs.dv_nparte1 as nparte1,
                DATE(vs.fecha) AS fecha ,TIME(vs.fecha) as hora,eu.alias_equipounidad as nom_equipo,vs.dr_referencia,vs.nombres,dvs.dv_entregado as cantidad,
                CONCAT(u.Nombre,' ',u.Apellido) as usuario
                FROM almacen_componente ac
                INNER JOIN detalle_vale_salida dvs ON dvs.fk_id_ac = ac.id_ac
                INNER JOIN vale_salida vs ON vs.id_vsalida = dvs.fk_vsalida
                INNER JOIN usuario u ON u.id_usu = vs.fk_idusuario
                INNER JOIN equipo_unidad eu ON eu.id_equipounidad = dvs.fk_idflota 
                WHERE vs.fk_idalm={$id_alm} AND dvs.fk_id_almacen={$id_alm} AND vs.est = 1  {$condiciones[1]} AND date(fecha) between '{$fecha_ini}' and '{$fecha_fin}'
                ORDER BY fecha DESC, hora DESC  
                {$limit}"); 
            }           
        }

        if($tipo=='ingreso'){
            if($switch=='false'){
                if($buscador!=""){
                    $datos=$conexion->query("SELECT SQL_CALC_FOUND_ROWS 'ingreso','success',vi.id_vingreso as vale,ac.fk_idcomp,dvi.dvi_descripcion as descripcion,dvi.dvi_nparte1 as nparte1,
                    DATE(vi.fecha) AS fecha ,TIME(vi.fecha) as hora,dvi.dvi_nombre_equipo as nom_equipo,dvi.dr_referencia,vi.nombres,dvi.dvi_ingreso as cantidad,
                    CONCAT(u.Nombre,' ',u.Apellido) as usuario
                    FROM almacen_componente ac
                    INNER JOIN detalle_vale_ingreso dvi ON dvi.fk_id_ac = ac.id_ac
                    INNER JOIN vale_ingreso vi ON vi.id_vingreso = dvi.fk_id_vingreso
                    INNER JOIN usuario u ON u.id_usu = vi.fk_idusuario
                    WHERE (dvi.dvi_descripcion LIKE '%$buscador%' OR dvi.dvi_nparte1 LIKE '%$buscador%' OR ac.fk_idcomp like '%$buscador%') AND 
                    vi.fk_idalm = {$id_alm} AND dvi.fk_id_almacen={$id_alm} AND vi.est = 1
                    ORDER BY fecha DESC, hora DESC  LIMIT {$inicio},{$registros}");
                    
                }else{
                $datos=$conexion->query("SELECT SQL_CALC_FOUND_ROWS 'ingreso','success',vi.id_vingreso as vale,ac.fk_idcomp,dvi.dvi_descripcion as descripcion,dvi.dvi_nparte1 as nparte1,
                DATE(vi.fecha) AS fecha ,TIME(vi.fecha) as hora,dvi.dvi_nombre_equipo as nom_equipo,dvi.dr_referencia,vi.nombres,dvi.dvi_ingreso as cantidad,
                CONCAT(u.Nombre,' ',u.Apellido) as usuario
                FROM almacen_componente ac
                INNER JOIN detalle_vale_ingreso dvi ON dvi.fk_id_ac = ac.id_ac
                INNER JOIN vale_ingreso vi ON vi.id_vingreso = dvi.fk_id_vingreso
                INNER JOIN usuario u ON u.id_usu = vi.fk_idusuario
                WHERE vi.fk_idalm = {$id_alm} AND dvi.fk_id_almacen={$id_alm}  AND vi.est = 1
                ORDER BY fecha DESC, hora DESC  LIMIT {$inicio},{$registros}");           
                }
            }else{
                $condiciones = $this->condicionales($tipo,$filtros); 
                $datos=$conexion->query("SELECT SQL_CALC_FOUND_ROWS 'ingreso','success',vi.id_vingreso as vale,ac.fk_idcomp,dvi.dvi_descripcion as descripcion,dvi.dvi_nparte1 as nparte1,
                DATE(vi.fecha) AS fecha ,TIME(vi.fecha) as hora,dvi.dvi_nombre_equipo as nom_equipo,dvi.dr_referencia,vi.nombres,dvi.dvi_ingreso as cantidad,
                CONCAT(u.Nombre,' ',u.Apellido) as usuario
                FROM almacen_componente ac
                INNER JOIN detalle_vale_ingreso dvi ON dvi.fk_id_ac = ac.id_ac
                INNER JOIN vale_ingreso vi ON vi.id_vingreso = dvi.fk_id_vingreso
                INNER JOIN usuario u ON u.id_usu = vi.fk_idusuario
                WHERE vi.fk_idalm = {$id_alm} AND dvi.fk_id_almacen={$id_alm}  AND vi.est = 1 {$condiciones[0]} AND date(fecha) between '{$fecha_ini}' and '{$fecha_fin}'
                ORDER BY fecha DESC, hora DESC  
                {$limit}");  
            }
        }

        

        $datos = $datos->fetchAll();
        $total = $conexion->query("SELECT FOUND_ROWS()");
        $total = (int)$total->fetchColumn();
        $Npaginas = ceil($total/$registros);
        $contador=$inicio+1;
        
        $activeA='';$activeI='';$activeO='';

        if($tipo=='ambos'){
            $activeA='active';
        }else if($tipo=="salida"){
            $activeO='active';
        }else{
            $activeI='active';
        }

        if(substr($vista,0,3)!='PDF'){
            $tabla.="
            <head class='clearfix'>
            <nav>
                <ul class='pagination' id='list_log'>
                    <li id='li_ambos' class='page-item {$activeA}'><a class='page-link' id='ambos' href='#list_log'>Ingreso/Salida</a></li>
                    <li id='li_in' class='page-item {$activeI}'><a class='page-link' id='ingreso' href='#list_log'>Ingreso</a></li>
                    <li id='li_out' class='page-item {$activeO}'><a class='page-link' id='salida' href='#list_log'>Salida</a></li>
                </ul>
            </nav>";
        }


        $tabla.="
        <div class='table-responsive-sm'><table id='tblog' class='table'>
        <thead>
            <tr>
                <th scope='col'>In/Out</th>
                <th scope='col'>N° Vale</th>
                <th scope='col'>Codigo</th>
                <th scope='col'>Descripcion</th>               
                <th scope='col'>NParte</th>
                <th scope='col'>Cant</th>
                <th scope='col'>Fecha</th>
                <th scope='col'>Hora</th>
                <th scope='col'>Equipo</th>
                <th scope='col'>Referencia</th>
                <th scope='col'>Personal</th>
                <th scope='col'>Usuario</th>
            </tr>
        </thead>
        <tbody id='tablelog'>";
        if($total>=1 && $paginador<=$Npaginas)
        {
            foreach($datos as $row){
                $tabla .="
                <tr>
                    <td><span class='badge badge-{$row[1]}'>{$row[0]}</span></td>
                    <td>{$row['vale']}</td>
                    <td>{$row['fk_idcomp']}</td>
                    <td>{$row['descripcion']}</td>                      
                    <td>{$row['nparte1']}</td>
                    <td>{$row['cantidad']}</td>
                    <td><span class='badge badge-{$row[1]}'>".mainModel::dateFormat($row['fecha'])."</span></td>
                    <td><span class='badge badge-{$row[1]}'>{$row['hora']}</span></td>
                    <td>{$row['nom_equipo']}</td>
                    <td>{$row['dr_referencia']}</td>
                    <td>{$row['nombres']}</td>
                    <td>{$row['usuario']}</td>
                </tr>"; 
                $equipo=$row['nom_equipo'];
                $ref=$row['dr_referencia'];    
            }
        }else{
            $tabla.='
            <tr><td colspan="9"> No existen registros</td></tr>';
        }
        
        $tabla.='
            </tbody>
            </table></div>
            </head>';
        
        if(substr($vista,0,3)=='PDF'){
            $equipo=($filtros[1]=='')?$equipo='':$equipo;
            $ref=($filtros[2]=='')?$ref='':$ref;
            $tabla.="
            <h2>Valores de filtrado</h2>
            <div id='project'>
                <div><span>INTERVALO: </span> desde {$this->formato_fecha_hora("fecha",$fecha_ini)} hasta {$this->formato_fecha_hora("fecha",$fecha_fin)}</div>
                <div><span>TIPO : </span>{$tipo} </div>
                <div><span>CODIGO : </span> {$filtros[0]}</div>
                <div><span>EQUIPO : </span> {$equipo}</div>
                <div><span>#REFERENCIA : </span> {$ref}</div>
                
            </div>";
            
            return $tabla;
        }
        
        $tabla.= mainModel::paginador_ajax($total,$paginador,$Npaginas,$vista);
        return $tabla;

    }

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
            um.abreviado,ac.stock,ac.fk_idalm,ac.u_nombre,ac.u_seccion,eu.id_equipounidad,
            eu.alias_equipounidad,ac.Referencia,ac.control_stock,c.nserie,ca.nombre,ca.color,c.medida,c.est_baja,c.est
            FROM componentes c
            INNER JOIN almacen_componente ac ON ac.fk_idcomp = c.id_comp 
            INNER JOIN unidad_medida um ON um.id_unidad_med = c.fk_idunidad_med
            INNER JOIN equipo_unidad eu ON eu.fk_idequipo = ac.fk_idflota
            INNER JOIN categoriacomp ca ON ca.id_categoria  = c.fk_idcategoria
            WHERE ( c.id_comp like '%$buscador%' or c.descripcion  like '%$buscador%' or c.nparte1 like '%$buscador%' or 
            c.nparte2 like '%$buscador%' or c.nparte3 like '%$buscador%' or eu.alias_equipounidad like '%$buscador%' or ac.Referencia like '%$buscador%'
            or c.nserie like '%$buscador%' or c.medida like '%$buscador%' or ca.nombre like '%$buscador%'  ) AND ac.est=1
            AND ac.fk_idalm={$id_alm} LIMIT {$inicio},{$registros} ");
            
        }else{
        $datos=$conexion->query("SELECT SQL_CALC_FOUND_ROWS ac.id_ac,c.id_comp,c.descripcion,c.nparte1,c.nparte2,c.nparte3,
        um.abreviado,ac.stock,ac.fk_idalm,ac.u_nombre,ac.u_seccion,eu.id_equipounidad,
        eu.alias_equipounidad,ac.Referencia,ac.control_stock,c.nserie,ca.nombre,ca.color,c.medida,c.est_baja,c.est
        FROM componentes c
        INNER JOIN almacen_componente ac ON ac.fk_idcomp = c.id_comp 
        INNER JOIN unidad_medida um ON um.id_unidad_med = c.fk_idunidad_med
        INNER JOIN equipo_unidad eu ON eu.fk_idequipo = ac.fk_idflota
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
            <div class='table-responsive-sm'><table class='table-inverse'>
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
        //$fk_idflota=mainModel::limpiar_cadena($_POST["codequipo"]);
        //$horometro=($_POST["horometro"]=="")?$horometro=0:mainModel::limpiar_cadena($_POST["horometro"]);
        $fk_idflota=1;
        $horometro=0;
    
        $comentario=mainModel::limpiar_cadena($_POST["comentario"]);   
        $id_alm= mainModel::limpiar_cadena($_POST["id_alm_vs"]);
        $objDateTime = new DateTime('NOW');
        $fecha=$objDateTime->format('Y-m-d H:i:s');
        $fecha_despacho=mainModel::limpiar_cadena($_POST["fecha_despacho"]);
        //$nom_equipo=mainModel::ejecutar_consulta_simple("SELECT eu.alias_equipounidad FROM equipo_unidad eu WHERE eu.id_equipounidad  = {$fk_idflota} ")['alias_equipounidad'];
        $nom_equipo="sin equipo";   
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
        $dv_idflota[]=$_POST["dv_idflota"];
        $dv_horometro[]=$_POST["dv_horometro"];
        $dv_motivo[]=$_POST["dv_motivo"];
        $dv_cambio[]=$_POST["dv_cambio"];
        
        
        
        $datos = [
            "fk_idusuario"=>$fk_idusuario,
            "fk_idpersonal"=>$fk_idpersonal,
            "turno"=>$turno,
            "comentario"=>$comentario,
            "fecha"=>$fecha,
            "fecha_despacho"=>$fecha_despacho,
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
                $info_dvsalida=almacenModelo::save_dvsalida_modelo($id_vsalida,$id_ac,$dv_descripcion,$dv_nparte1,$dv_stock,$dv_solicitado,
                $dv_entregado,$dv_unombre,$dv_useccion,$id_alm,$dv_idflota,$dv_horometro,$dv_motivo,$dv_cambio,$fecha,$fk_idusuario,
                $fk_idpersonal,$datos_referencia);
                if($id_vsalida!=0){
                    if($info_dvsalida[0]=='false'){
                    mainModel::ejecutar_consulta_simple("UPDATE vale_salida SET est = 0,fecha_anulacion=NOW() WHERE id_vsalida = {$id_vsalida} AND fk_idalm={$id_alm}");                       
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
                            "CarritoVs-{$fk_idusuario}-{$id_alm}"
                        ];
                        
                        echo "<script>
                        document.querySelector('#btnvale').disabled = true;
                        document.querySelector('#btnagregar').disabled = true;
                        setTimeout(function(){
                            window.location.reload(1);
                         }, 5000);
                        </script>";
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
        //$turno = mainModel::limpiar_cadena($_POST["turno"]);
        $turno = "-";
        $ref_documento=mainModel::limpiar_cadena($_POST["ref_documento"]);
        $comentario=mainModel::limpiar_cadena($_POST["comentario"]);
        $id_alm= mainModel::limpiar_cadena($_POST["id_alm_vi"]);
        $objDateTime = new DateTime('NOW');
        $fecha=$objDateTime->format('Y-m-d H:i:s');
        $fecha_llegada=mainModel::limpiar_cadena($_POST["fecha_llegada"]);
        
        $fk_idpersonal = mainModel::limpiar_cadena($_POST["personal"]);
        $documento=mainModel::limpiar_cadena($_POST["documento"]);
        //$fk_idpersonal = ($documento==1)? $fk_idpersonal=$fk_idpersonal:$fk_idpersonal=$fk_idusuario; 
        $privilegio=mainModel::limpiar_cadena($_POST["privilegio_in"]);
        if($documento !="Devolucion"){
            $id_usuario= mainModel::ejecutar_consulta_simple("SELECT fk_idper FROM usuario WHERE id_usu = {$fk_idusuario}");
            $fk_idpersonal = $id_usuario["fk_idper"];
        }
        
        //$documento = ($documento==1)? $documento="guia remision":$documento="devolucion";
        $datospersonal = mainModel::ejecutar_consulta_simple("select  concat(p.nom_per,',',p.Ape_per) as nombres,p.dni_per from personal p where id_per = {$fk_idpersonal} ");
        $nombre_per = mainModel::limpiar_cadena($datospersonal['nombres']);
        $dni_per = mainModel::limpiar_cadena($datospersonal['dni_per']);
        
        //Detalle
        $dvi_id_ac[]=$_POST["id_ac_carritoin"];
        $dvi_codigo[]=$_POST["dv_codigo"];
        $dvi_descripcion[]=$_POST["dv_descripcion"];
        $dvi_nparte1[]=$_POST["dv_nparte1"];
        $dvi_stock[]=$_POST["dv_stock"];
        $dvi_ingreso[]=$_POST["dv_ingreso"];
        $dvi_fkidflota[]=$_POST["dv_id_equipo"];
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
            "fecha_llegada"=>$fecha_llegada,
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

                $ingreso=almacenModelo::save_dvingreso_modelo($id_vingreso,$dvi_codigo,$dvi_id_ac,$dvi_descripcion,$dvi_nparte1,
                $dvi_stock,$dvi_ingreso,$dvi_nom_equipo,$dvi_fkidflota,$id_alm,$dvi_referencia,$fecha,$fk_idpersonal,$fk_idusuario);
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
                            "carritoIn-{$fk_idusuario}-{$id_alm}",
                            "carritoIn2-{$fk_idusuario}-{$id_alm}"
                        ];
                        
                        echo "<script>document.querySelector('#btnvale').disabled = true;</script>";
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

        //STOCK INICIAL
        //datos #1
        $id_alm= mainModel::limpiar_cadena($_POST["id_alm_frmIA"]);
        $privilegio= mainModel::limpiar_cadena($_POST["privilegio_sbp_ia"]);
        $t_reg = mainModel::limpiar_cadena($_POST["t_reg"]);
        $id_comp[] = $_POST["id_comp"];
        $d_nparte1[] = $_POST["d_nparte1"];
        $d_nserie[] = $_POST["d_nserie"];
        $d_descripcion[] = $_POST["d_descripcion"];
        $d_stock = 0;
        $d_cant[]=$_POST["d_cant"];
        $d_u_nom[] = $_POST["d_u_nom"];
        $d_u_sec[] = $_POST["d_u_sec"];
        $d_fk_idflota[] = $_POST["d_id_equipo"];
        $d_nom_equipo[] = $_POST["d_nom_equipo"];
        $d_referencia[] = $_POST["d_referencia"];
        $d_fk_usuario = $_POST["d_fk_usuario"];
        
        // se reemplazara por lo datos 1, se reduce a un solo array datos.
        //datos #2

        $validarPrivilegios=mainModel::privilegios_transact($privilegio);

        if($validarPrivilegios){

            $validar=almacenModelo::save_registro_almacen_modelo($id_comp,$d_u_nom,$d_nserie,$d_descripcion,$d_u_sec,
            $d_fk_idflota,$d_referencia,$id_alm,$d_stock,$d_cant,$t_reg,$d_fk_usuario);
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

                    $newdatos = array(
                        "id_alm"=>$id_alm,
                        "id_comp"=>$id_comp,
                        "d_nparte"=>$d_nparte1,
                        "d_nserie"=>$d_nserie,
                        "d_descripcion"=>$d_descripcion,
                        "d_u_nom"=>$d_u_nom,
                        "d_u_sec"=>$d_u_sec,
                        "d_fk_idflota"=>$d_fk_idflota,
                        "d_nom_equipo"=>$d_nom_equipo,
                        "d_referencia"=>$d_referencia,
                        "d_stock"=>$d_stock,
                        "d_cant"=>$d_cant,
                        "d_id_ac"=>$validar[2]
                    );    

                    
                    $localStorage = [
                        "carritoGen-{$d_fk_usuario}-{$id_alm}",
                    ];
                    echo mainModel::localstorage_reiniciar($localStorage);
  
                    //Seteamos en el nuevo localstorage los datos enviados de ingreso almacen
                    if($t_reg==1){
                        echo mainModel::localstorage_set("carritoIn2-{$d_fk_usuario}-{$id_alm}",$newdatos);

                        $alerta=[
                            "alerta"=>"redire",
                            "Titulo"=>"productos registrados y enviados",
                            "Texto"=>"los productos se enviaron al modulo de vale ingreso",
                            "Tipo"=>"success",
                            "vista"=>"RValeIngreso",
                            "tiempo"=>2000
                        ];
                    }elseif($t_reg==0) {
                        $alerta=[
                            "alerta"=>"recargar",
                            "Titulo"=>"Productos registrados",
                            "Texto"=>"los productos se registraron en su almacen",
                            "Tipo"=>"success"
                            
                        ];
                  
                    }else{
                        $alerta=[
                            "alerta"=>"recargar",
                            "Titulo"=>"Productos registrados, sin tipo de registro",
                            "Texto"=>"Reporte el error al desarrollador",
                            "Tipo"=>"danger"
                            
                        ];
                    }
                    
                    
     
                    
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
                        "Texto"=>"No hemos podido ingresar al almacen el/los componente seleccionado(s)",
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


    /********** REPORTES  - VISTA REPOTEALMACEN *******/

    public function reporte_valesalida_simple_controlador($idvs,$idalm,$formato,$privilegio){
        $SERVERURL=SERVERURL;
        $template = "";
        $conexion = mainModel::conectar();
        if($formato == "ticket"){
            $resp = $conexion->prepare("SELECT vs.id_vsalida, vs.nombres,vs.d_identidad,DATE(vs.fecha) AS fecha,TIME(vs.fecha) AS hora,vs.turno,vs.nom_equipo
            ,DATE(vs.fecha_despacho) as fec_despacho,vs.horometro,vs.comentario,a.Alias,u.Nombre,u.Apellido,vs.dr_referencia,vs.est
            FROM vale_salida vs
            INNER JOIN almacen a ON 
            a.id_alm = vs.fk_idalm
            INNER JOIN usuario u ON
            u.id_usu = vs.fk_idusuario              
            WHERE id_vsalida = {$idvs} AND fk_idalm = {$idalm}");
            $resp->execute();
            $resp=$resp->fetchAll();

            $resp_dv = $conexion->prepare("SELECT c.id_comp,dvs.dv_descripcion,dvs.dv_nparte1,eu.alias_equipounidad as nom_equipo,
            dvs.dv_entregado
            FROM detalle_vale_salida dvs
            INNER JOIN almacen_componente ac
            ON ac.id_ac = dvs.fk_id_ac
            INNER JOIN componentes c
            ON c.id_comp = ac.fk_idcomp
            INNER JOIN equipo_unidad eu 
            ON eu.id_equipounidad = dvs.fk_idflota  
            WHERE dvs.fk_vsalida = {$idvs} AND dvs.fk_id_almacen = {$idalm}");

            $resp_dv->execute();
            $resp_dv=$resp_dv->fetchAll();

            foreach($resp as $row){
                if($row['est']==0){
                    $mensaje="VALE ANULADO";
                }else{
                    $mensaje="";
                }
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
                        VALE DE SALIDA #{$row["id_vsalida"]}
                        <br>
                        <br>".mainModel::dateFormat($row["fecha"])." | {$row["hora"]}
                        <br>Despacho: ".mainModel::dateFormat($row["fec_despacho"])." 
                        <br>{$row["dr_referencia"]}
                        <br>{$row["Alias"]}
                        </p>
                        <table>
                            <thead>
                                <tr>
                                    <th class='codigo'>COD.</th>
                                    <th class='producto'>PRODUCTO</th>
                                    <th class='nparte'>NPARTE</th>
                                    <th class='cantidad'>QTY</th>
                                    <th class='cantidad'>EQUIPO</th>
                                </tr>
                            </thead>
                            <tbody>";
                            foreach($resp_dv as $row_dv){
                                    
                                $template .="
                                    <tr>
                                        <td class='codigo'>{$row_dv["id_comp"]}</td>
                                        <td class='producto'>{$row_dv["dv_descripcion"]}</td>
                                        <td class='nparte'>{$row_dv["dv_nparte1"]}</td>
                                        <td class='cantidad'>{$row_dv["dv_entregado"]}</td>
                                        <td class='nparte'>{$row_dv["nom_equipo"]}</td>
                                    </tr>";
                            }
                        

                            $template .="
                            </tbody>
                        </table>
                        <p class='centrado'>{$row["comentario"]}</p>
                        <br>
                        <p class='firma'>
                        <hr/>
                        <br>Solicita: {$row["nombres"]}</p>
                        <p class='centrado'>Atendido por {$row["Nombre"]},{$row["Apellido"]}</p>
                    </div>
                    <h1>{$mensaje}</h1>
                </body>
            </html>";
            }
        }else if($formato=="vista_simple"){

            $resp = $conexion->prepare("SELECT vs.id_vsalida, vs.nombres,vs.d_identidad,fecha as fecha_hora,DATE(vs.fecha) AS fecha,TIME(vs.fecha) AS hora,vs.turno,
            vs.nom_equipo,DATE(vs.fecha_despacho) as fec_despacho,vs.horometro,vs.comentario,a.Alias,u.Nombre,u.Apellido,vs.est,vs.fecha_anulacion,u.id_usu
            FROM vale_salida vs
            INNER JOIN almacen a ON 
            a.id_alm = vs.fk_idalm
            INNER JOIN usuario u ON
            u.id_usu = vs.fk_idusuario              
            WHERE fk_idalm = {$idalm} ORDER BY vs.id_vsalida DESC ");
            $resp->execute();
            $resp=$resp->fetchAll();
            $contador=1;
            foreach($resp as $row){
                
                if($row['est']==0){
                    $color="table-danger";
                }else{
                    $color="";
                }
                
                $template .="
                <tr class='{$color}'>
                    <td>{$contador}</td>
                    <td>{$row['id_vsalida']}</td>
                    <td>". mainModel::dateFormat($row['fecha']) ."</td>
                    <td>{$row['hora']}</td>
                    <td>". mainModel::dateFormat($row['fec_despacho']) ."</td>
                    <td>{$row['nombres']}</td>
                    <td>{$row['Nombre']}, {$row["Apellido"]}</td>
                    <td><a style='font-size: 2em;' href='../PDFvalesalida/{$row["id_vsalida"]}/{$idalm}' target='_blank' ><i class='fas fa-ticket-alt'></i></a></td>";
                    if($privilegio==0 or $privilegio==1){
                        //$disabled=($row['est']==0)?$disabled='disabled':$disabled='';
                        
                        $fecha_reg= new DateTime($row['fecha_hora']);
                        $fecha_actual = new DateTime('NOW');
                        //$fecha_actual =$objDateTime->format('Y-m-d H:i:s');
                        $diff = $fecha_reg->diff($fecha_actual);
                        $diff_days = $diff->days;
                        $diff_horas = ($diff->h);
                        ;$display='';
                        if($row['est']==0){$disabled='disabled';$display='none';
                        }elseif($diff_days>=1){$disabled='disabled';
                        }elseif($diff_horas>8){$disabled='disabled';
                        }else{$disabled='';
                        }
                            $template .="     
                            <td>
                                <form name='FrmAnularVS' action='".SERVERURL."ajax/almacenAjax.php' method='POST' class='FormularioAjax' data-form='anular' entype='multipart/form-data' autocomplete='off'>
                                    <input type='hidden' name='id_vsalida_anular' value='{$row['id_vsalida']}' />
                                    <input type='hidden' name='almacen_vs_anular' value='{$idalm}' />
                                    <input type='hidden' name='usuario_vs_anular' value='{$row['id_usu']}' />
                                    
                                    <button type='submit' style='display:{$display}' class='btn btn-danger' {$disabled}><i class='fas fa-ban'></i></button>
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
            $resp = $conexion->prepare("SELECT vi.id_vingreso, DATE(vi.fecha) AS fecha ,TIME(vi.fecha) as hora,vi.fecha_llegada,vi.turno,vi.ref_documento,vi.ref_nrodocumento,
            vi.nombres,u.Nombre,u.Apellido,a.Alias,vi.comentario,vi.est
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
                if($row['est']==0){
                    $mensaje="VALE ANULADO";
                }else{
                    $mensaje="";
                }

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
                        VALE DE INGRESO #{$row["id_vingreso"]}
                        <br>
                        <br>".mainModel::dateFormat($row["fecha"])." | {$row["hora"]}
                        <br>Llegada: ".mainModel::dateFormat($row["fecha_llegada"])."
                        <br>{$row["ref_documento"]} : {$row["ref_nrodocumento"]}
                        <br>{$row["Alias"]}
                        </p>
                        <table>
                            <thead>
                                <tr>
                                    <th class='codigo'>COD.</th>
                                    <th class='producto'>PRODUCTO</th>
                                    <th class='nparte'>NPARTE</th>
                                    <th class='cantidad'>QTY</th>
                                    <th class='cantidad'>EQUIPO</th>
                                    
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
                    <h1>{$mensaje}</h1>
                </body>
            </html>";
            }
        }else if($formato=="vista_simple"){
            $resp = $conexion->prepare("SELECT vi.id_vingreso, vi.fecha as fecha_hora,DATE(vi.fecha) AS fecha ,TIME(vi.fecha) as hora,vi.ref_documento,vi.ref_nrodocumento,
            vi.nombres,u.Nombre,u.Apellido,vi.est,vi.fk_idusuario
            FROM vale_ingreso vi
            INNER JOIN almacen a ON 
            a.id_alm = vi.fk_idalm
            INNER JOIN usuario u ON
            u.id_usu = vi.fk_idusuario             
            WHERE  fk_idalm = {$idalm} ORDER BY vi.id_vingreso DESC");
            $resp->execute();
            $resp=$resp->fetchAll();
            $contador=1;
            foreach($resp as $row){

                if($row['est']==0){
                    $color="table-danger";
                }else{
                    $color="";
                }

                $template .=" 
                <tr class='{$color}'>
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

                        $fecha_reg= new DateTime($row['fecha_hora']);
                        $fecha_actual = new DateTime('NOW');
                        //$fecha_actual =$objDateTime->format('Y-m-d H:i:s');
                        $diff = $fecha_reg->diff($fecha_actual);
                        $diff_days = $diff->days;
                        $diff_horas = ($diff->h);
                        ;$display='';
                        if($row['est']==0){$disabled='disabled';$display='none';
                        }elseif($diff_days>=1){$disabled='disabled';
                        }elseif($diff_horas>8){$disabled='disabled';
                        }else{$disabled='';
                        }
                          
                          
                    $template .=" 
                    <td>
                        <form action='".SERVERURL."ajax/almacenAjax.php' method='POST' class='FormularioAjax' data-form='anular' entype='multipart/form-data' autocomplete='off'>
                            <input type='hidden' name='id_vingreso_anular' value='{$row['id_vingreso']}' />
                            <input type='hidden' name='almacen_vi_anular' value='{$idalm}' />
                            <input type='hidden' name='usuario_vi_anular' value='{$row['fk_idusuario']}' />
                            <button type='submit' style='display:{$display}' class='btn btn-danger' {$disabled}><i class='fas fa-ban'></i></button>
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
        $id_alm = mainModel::limpiar_cadena($_POST["almacen_vs_anular"]);
        $usuario = mainModel::limpiar_cadena($_POST["usuario_vs_anular"]);
        $objDateTime = new DateTime('NOW');
        $fecha=$objDateTime->format('Y-m-d H:i:s');

        $validar_anulado = mainModel::ejecutar_consulta_simple("SELECT vs.est FROM vale_salida vs WHERE 
        vs.id_vsalida = {$id_vsalida} AND vs.fk_idalm = {$id_alm} AND est = 0");
        
        if($validar_anulado){
            $alerta=[
                "alerta"=>"recargar",
                "Titulo"=>"Vale salida N°{$id_vsalida} ya ha si anulado",
                "Texto"=>"No puedo voler ha anular este vale",
                "Tipo"=>"warning"
            ];
            return mainModel::sweet_alert($alerta);
        }else{
            $validar=almacenModelo::anular_vsalida_modelo($id_vsalida,$id_alm,$fecha,$usuario);
        }
        
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
        $id_alm = mainModel::limpiar_cadena($_POST["almacen_vi_anular"]);
        $usuario = mainModel::limpiar_cadena($_POST["usuario_vi_anular"]);
        $objDateTime = new DateTime('NOW');
        $fecha=$objDateTime->format('Y-m-d H:i:s');


        $validar_anulado = mainModel::ejecutar_consulta_simple("SELECT vi.est FROM vale_ingreso vi WHERE 
        vi.id_vingreso = {$id_vingreso}  AND vi.fk_idalm={$id_alm} AND vi.est = 0");
        
        if($validar_anulado){
            $alerta=[
                "alerta"=>"recargar",
                "Titulo"=>"Vale ingreso N°{$id_vingreso} ya ha si anulado",
                "Texto"=>"No puedo voler ha anular este vale",
                "Tipo"=>"warning"
            ];
            return mainModel::sweet_alert($alerta);
        }else{
            $validar=almacenModelo::anular_vingreso_modelo($id_vingreso,$id_alm,$fecha,$usuario);
        }

        

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
    
    //FUNCION PARA DELIBERAR LAS CONDICIONALES DE LAS CONSULTAS SEGUN FILTRO
    public function condicionales($tipo,$filtros){
        $codigoF= $filtros[0];
        $equipoF= $filtros[1];
        $referenciaF= $filtros[2];

        if($codigoF != ''){
            $cond_in = "AND (ac.fk_idcomp={$codigoF})";
            $cond_out = "AND (ac.fk_idcomp={$codigoF})";
            if($equipoF!=''){
                $cond_in = "AND (ac.fk_idcomp={$codigoF} AND dvi.fk_idflota = {$equipoF})";
                $cond_out = "AND (ac.fk_idcomp={$codigoF} AND dvs.fk_idflota = {$equipoF})";  
            }
            if($referenciaF!=''){
                $cond_in = "AND (ac.fk_idcomp={$codigoF} AND dvi.dr_referencia='{$referenciaF}')";
                $cond_out = "AND (ac.fk_idcomp={$codigoF} AND vs.dr_referencia = '{$referenciaF}')";  
            }
            if($equipoF!='' && $referenciaF!='' ){
                $cond_in = "AND (ac.fk_idcomp={$codigoF} AND dvi.fk_idflota = {$equipoF} AND dvi.dr_referencia='{$referenciaF}')";
                $cond_out = "AND (ac.fk_idcomp={$codigoF} AND dvs.fk_idflota = {$equipoF} AND vs.dr_referencia='{$referenciaF}')";  
            }
        }else if($equipoF!=''){
            $cond_in = "AND (dvi.fk_idflota = {$equipoF})";
            $cond_out = "AND (dvs.fk_idflota = {$equipoF})";
            if($referenciaF !=''){
                $cond_in = "AND (dvi.fk_idflota = {$equipoF} AND dvi.dr_referencia='{$referenciaF}')";
                $cond_out = "AND (dvs.fk_idflota = {$equipoF} AND vs.dr_referencia = '{$referenciaF}')";  
            }
        }else if($referenciaF!=''){
            $cond_in = "AND (dvi.dr_referencia='{$referenciaF}')";
            $cond_out = "AND (vs.dr_referencia = '{$referenciaF}')";
        }
        else{
            $cond_in='';
            $cond_out='';
        }

        $condiciones=[$cond_in,$cond_out];
        return $condiciones;
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
        $consulta = "SELECT * FROM datos_referencia WHERE id_dr !=1 AND fk_idunidad = {$_SESSION['unidad']}";
        return mainModel::ejecutar_combo($consulta,$val,$vis);
    }

    public function formato_fecha_hora($tipo,$date){
        return mainModel::dateFormat2($tipo,$date);
    }
    
}   


?>