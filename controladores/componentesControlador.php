<?php 

if($peticionAjax){
    require_once '../modelos/componentesModelo.php';
}else{
    require_once './modelos/componentesModelo.php';
}

Class componentesControlador extends componentesModelo {

    /*public function paginador_componentes($paginador,$registros,$privilegio,$buscador,$vista){

        $paginador=mainModel::limpiar_cadena($paginador);
        $registros=mainModel::limpiar_cadena($registros);
        $privilegio=mainModel::limpiar_cadena($privilegio);
        $tabla='';

        $paginador=(isset($paginador) && $paginador>0)?(int)$paginador:1; 
        $inicio=($paginador>0)?(($paginador*$registros)-$registros):0;

        $conexion = mainModel::conectar();
        if($buscador!=""){
            $datos=$conexion->query("SELECT SQL_CALC_FOUND_ROWS c.id_comp,c.codigo,c.descripcion,c.nparte1,c.nparte2,c.nparte3,c.unidad_med,ac.stock,ac.fk_idalm,ac.id_ac,CONCAT(ac.u_nombre,'-',ac.u_seccion) as ubicacion,ac.modelo_equipo
                                     FROM componentes c
                                     INNER JOIN almacen_componente ac
                                     ON ac.fk_idcomp = c.id_comp WHERE (c.codigo like '%{$buscador}%' or c.descripcion  like '%{$buscador}%'  or c.nparte1 like '%{$buscador}%' or c.nparte2 like '%{$buscador}%' or ac.modelo_equipo like '%{$buscador}%' or CONCAT(ac.u_nombre,'-',ac.u_seccion) like '%{$buscador}%' ) and ac.est = 1 and ac.fk_idalm=1  order by  c.codigo LIMIT {$inicio},{$registros} ");

        }else{
            $datos=$conexion->query("SELECT SQL_CALC_FOUND_ROWS c.id_comp,c.codigo,c.descripcion,c.nparte1,c.nparte2,c.nparte3,c.unidad_med,ac.stock,ac.fk_idalm,ac.id_ac,CONCAT(ac.u_nombre,'-',ac.u_seccion) as ubicacion,ac.modelo_equipo
                                    FROM componentes c
                                    INNER JOIN almacen_componente ac
                                    ON ac.fk_idcomp = c.id_comp WHERE ac.est = 1 and ac.fk_idalm=1  order by  c.codigo LIMIT {$inicio},{$registros} ");

            

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
                <th scope="col">NParte1</th>
                <th scope="col">NParte2</th>
                <th scope="col">NParte3</th>
                <th scope="col">Ubicacion</th>
                <th scope="col">Stock</th>
                <th scope="col">U.medida</th>
                <th scope="col">Modelo equipo</th>';
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
                            <td>{$row['nparte2']}</td>
                            <td>{$row['nparte3']}</td>
                            <td>{$row['ubicacion']}</td>
                            <td>{$row['stock']}</td>
                            <td>{$row['unidad_med']}</td>
                            <td>{$row['modelo_equipo']}</td>";

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

    public function paginador_componentes($paginador,$registros,$privilegio,$buscador,$vista){

        $paginador=mainModel::limpiar_cadena($paginador);
        $registros=mainModel::limpiar_cadena($registros);
        $privilegio=mainModel::limpiar_cadena($privilegio);
        $tabla='';
        //echo $_SESSION['nombre_sbp'];
        $paginador=(isset($paginador) && $paginador>0)?(int)$paginador:1; 
        $inicio=($paginador>0)?(($paginador*$registros)-$registros):0;

        $conexion = mainModel::conectar();
        
        if($buscador!=""){
            $datos=$conexion->query("SELECT SQL_CALC_FOUND_ROWS *
                                    FROM componentes c WHERE ( c.descripcion  like '%$buscador%' or c.nparte1 like '%$buscador%' or c.nparte2 like '%$buscador%' or c.nparte3 like '%$buscador%'  )  LIMIT {$inicio},{$registros} ");
            
        }else{
            $datos=$conexion->query("SELECT SQL_CALC_FOUND_ROWS *
                                    FROM componentes  WHERE est = 1  LIMIT {$inicio},{$registros}");           
        }
        //$datos->execute();
        $datos = $datos->fetchAll();
        $total = $conexion->query("SELECT FOUND_ROWS()");
        $total = (int)$total->fetchColumn();

        
        //devuel valor entero redondeado hacia arriba 4.2 = 5
        $Npaginas = ceil($total/$registros);
        $tabla.="<div><table class='table table-bordered'>
        <thead>
            <tr>
                <th scope='col'>Cod.Interno</th>
                <th scope='col'>Descripcion</th>               
                <th scope='col'>NParte</th>
                <th scope='col'>NParte2</th>
                <th scope='col'>NParte3</th>
                <th scope='col'>Marca</th>
                <th scope='col'>U.M</th>
                <th scope='col'>Control Stock</th>
                <th colspan='2' scope='col'>Acciones</th>";
                //programar privilegios
        $tabla.="</tr>
        </thead>
        <tbody id='datatable' >";
        if($total>=1 && $paginador<=$Npaginas)
        {
        
            foreach($datos as $row){
                $tabla .="<tr >
                            <td>{$row['id_comp']}</td>
                            <td>{$row['descripcion']}</td>                      
                            <td>{$row['nparte1']}</td>
                            <td>{$row['nparte2']}</td>
                            <td>{$row['nparte3']}</td>
                            <td>{$row['marca']}</td>
                            <td>{$row['unidad_med']}</td>";
                            if($row['control_stock']==1){
                    $tabla .="<td><span style='width:40%' class='badge badge-primary'><i class='fas fa-check'></i></span></td>";      
                            }else{
                    $tabla .="<td><span style='width:40%' class='badge badge-danger'><i class='fas fa-window-close'></i></span></td>";                    
                            }                            
                $tabla .="<td><a style='font-size: 1.5em;'  class='fas fa-edit' href='{$row['id_comp']}' id='EditItem' data-producto='{$row['id_comp']}' data-toggle='modal' data-target='#ModalEdit'></a> </td>";
                            
                $tabla .="<td><form action='".SERVERURL."ajax/administradorAjax.php' method='POST' class='FormularioAjax' 
                data-form='delete' entype='multipart/form-data' autocomplete='off'>
                <input type='hidden' name='id_usu' value='".mainModel::encryption($row[0])."'/>
                
                <i class='far fa-trash-alt'><button type='submit' class='far fa-trash-alt'></button></i>
                <div class='RespuestaAjax'></div>   
                </form></td>";
                      
                $tabla.="</tr>";
            }
        }else{
            $tabla.='<tr><td colspan="7"> No existen registros</td></tr>';
        }

        $tabla.='</tbody></table></div>';
   
        $tabla.= mainModel::paginador($total,$paginador,$Npaginas,$vista);
        return $tabla;
    }
    //VALIDARA al buscador por variables del paginador,y problemas en la consulta entre limit
    public function validar_paginador_controlador($buscador,$vista,$eliminar_buscador){
        return mainModel::validar_paginador($buscador,$vista,$eliminar_buscador);
    }

    public function save_componente_controlador(){
        
        $descripcion =  mainModel::limpiar_cadena($_POST["descripcion_formEdit"]);
        $nparte1 =  mainModel::limpiar_cadena($_POST["nparte1"]);
        $nparte2 =  mainModel::limpiar_cadena($_POST["nparte2"]);
        $nparte3 =  mainModel::limpiar_cadena($_POST["nparte3"]);
        $marca =  mainModel::limpiar_cadena($_POST["marca"]);
        //$tipo =  mainModel::limpiar_cadena($_POST["tipo"]);
        $unidad_med=  mainModel::limpiar_cadena($_POST["unidad_med"]);
        $medida=  mainModel::limpiar_cadena($_POST["medida"]);
        $control_stock= mainModel::limpiar_cadena($_POST["control_stock"]);
        $control_stock = $control_stock == 'on'? $control_stock = 1 : $control_stock =0;
        $stock_min=  mainModel::limpiar_cadena($_POST["stock_min"]);
        $stock_max=  mainModel::limpiar_cadena($_POST["stock_max"]);
        //$id_alm= mainModel::limpiar_cadena($_POST["id_alm"]);

        $datos = [
            "descripcion"=>$descripcion,
            "nparte1"=>$nparte1,
            "nparte2"=>$nparte2,
            "nparte3"=>$nparte3,
            "marca"=>$marca,
            "unidad_med"=>$unidad_med,
            "medida"=>$medida,
            "control_stock"=>$control_stock,
            "stock_min"=>$stock_min,
            "stock_max"=>$stock_max,
            
        ];

        $resp = componentesModelo::save_componentenes_modelo($datos);

        $alerta=[
            "alerta"=>"recargar",
            "Titulo"=>"Datos guardados",
            "Texto"=>"Los siguientes datos han sido guardados",
            "Tipo"=>"success"
        ];

        $localStorage = [
            "BDcomp_gen",
            "BDproductos",
            "carritoGen",
            "carritoIn",
            "carritoS"
        ];

        echo mainModel::localstorage_reiniciar($localStorage);
        return mainModel::sweet_alert($alerta);

    }

    public function update_componente_controlador(){
        $id_comp = mainModel::limpiar_cadena($_POST["id_comp_formEdit"]);
        $descripcion = mainModel::limpiar_cadena($_POST["descripcion_formEdit"]);
        $nparte1 = mainModel::limpiar_cadena($_POST["nparte1"]);
        $nparte2 = mainModel::limpiar_cadena($_POST["nparte2"]);
        $nparte3 = mainModel::limpiar_cadena($_POST["nparte3"]);
        $marca = mainModel::limpiar_cadena($_POST["marca"]);
        $unidad_med = mainModel::limpiar_cadena($_POST["unidad_med"]);
        $control_stock = mainModel::limpiar_cadena($_POST["control_stock"]);

        $datos = [
            "id_comp"=>$id_comp,
            "descripcion"=>$descripcion,
            "nparte1"=>$nparte1,
            "nparte2"=>$nparte2,
            "nparte3"=>$nparte3,
            "marca"=>$marca,
            "unidad_med"=>$unidad_med,
            "control_stock"=>$control_stock
        ];
        
        $resp = componentesModelo::update_componente_modelo($datos);

        if($resp->rowCount()>=1){
            $alerta=[
                "alerta"=>"recargar",
                "Titulo"=>"Datos Actualizados",
                "Texto"=>"Los siguientes datos han sido Actualizados",
                "Tipo"=>"success"
            ];
        }else{
            $alerta=[
                "alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"No hemos podido actualizar el componente seleccionado",
                "Tipo"=>"error"
            ];
        }

        return mainModel::sweet_alert($alerta);
    }

    public function componentes_general(){
        $conexion = mainModel::conectar();
        $datos = $conexion->prepare("call v_comp_general");
        $datos->execute();
        $datos=$datos->fetchAll();
        $contador = 1;
        $dtable = "";
        foreach($datos as $row){
            $dtable .="
                <tr>
                    <td>{$contador}</td>
                    <td>{$row['descripcion']}</td>
                    <td>{$row['id_comp']}</td>
                    <td>{$row['nparte1']}</td>
                    <td>{$row['nparte2']}</td>
                    <td>{$row['nparte3']}</td>
                    <td>{$row['marca']}</td>
                    <td><a href='#' class='card-footer-item' id='addItem'  data-producto='{$row['id_comp']}' data-toggle='modal' data-target='#exampleModalCenter'>+</a></td>
                </tr>
            ";
            $contador++;
        }

        return $dtable;
    }

    public function componentes_gen_json(){
        $consulta = "SELECT * FROM componentes WHERE est = 1";
        return mainModel::obtener_consulta_json($consulta);
    }

    public function dato_componente($id_comp){
        $consulta = "SELECT * FROM componentes WHERE id_comp = {$id_comp}"; 
        return mainModel::obtener_consulta_json($consulta);
    }

    public function select_combo($consulta,$val,$vis){
        return mainModel::ejecutar_combo($consulta,$val,$vis);
    }
    
    /*public function validar_equipo($id){
    $consulta = "SELECT e.Nombre_Equipo FROM equipos e WHERE e.Id_equipo = {$id}";
    return mainModel::obtener_consulta_json($consulta);
    }*/

    



}




?>