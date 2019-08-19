<?php 

if($peticionAjax){
    require_once '../modelos/unidadmedidaModelo.php';
}else{
    require_once './modelos/unidadmedidaModelo.php';
}


class unidadmedidaControlador extends unidadmedidaModelo {

    public function paginador_unidadmedida($paginador,$registros,$privilegio,$buscador,$vista){

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
            FROM unidad_medida um WHERE ( um.descripcion  like '%$buscador%' or um.abreviado like '%$buscador%' ) AND est=1 LIMIT {$inicio},{$registros}");
            
        }else{
            $datos=$conexion->query("SELECT SQL_CALC_FOUND_ROWS *
                                    FROM unidad_medida  WHERE est = 1  LIMIT {$inicio},{$registros}");           
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
                <th scope='col'>#</th>
                <th scope='col'>Unidad medida</th>               
                <th scope='col'>Abreviacion</th>
                <th colspan='2' scope='col'>Acciones</th>";
                //programar privilegios
        $tabla.="</tr>
        </thead>
        <tbody id='table_unidadmed' >";
        if($total>=1 && $paginador<=$Npaginas)
        {
              $i=1;  
            foreach($datos as $row){
                $tabla .="
            <tr>
                            <td>{$i}</td>
                            <td>{$row['descripcion']}</td>                      
                            <td>{$row['abreviado']}</td>";                          
                $tabla .="<td><a style='font-size: 1.5em;'  class='fas fa-edit' href='{$row['id_unidad_med']}' id='EditItem' data-item='{$row['id_unidad_med']}' data-toggle='modal' data-target='#ModalEdit'></a> </td>";
                            
                $tabla .="
                <td >
                    <form name='FrmDel_UM' action='".SERVERURL."ajax/unidadmedidaAjax.php' method='POST' class='FormularioAjax' 
                        data-form='delete' entype='multipart/form-data' autocomplete='off'>
                        <input type='hidden' name='id_um_formDel' value='{$row['id_unidad_med']}'/>
                        <button type='submit' class='btn btn-danger'><i class='far fa-trash-alt'></i></button> 
                        <div class='RespuestaAjax'></div>   
                    </form>
                </td>
            </tr>";
            $i++;
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

    public function save_unidadmed_controlador(){
        $descripcion=mainModel::limpiar_cadena($_POST["descripcion_um"]);
        $abreviado=mainModel::limpiar_cadena($_POST["abreviado_um"]);

        $datos = [
            "descripcion"=>$descripcion,
            "abreviado"=>$abreviado
        ];

        $validar = unidadmedidaModelo::save_unidadmed_modelo($datos);

        if($validar->rowCount()>0){

            $alerta=[
                "alerta"=>"recargar",
                "Titulo"=>"Registrado con exito",
                "Texto"=>"Unidad de medida registrado",
                "Tipo"=>"success"
            ];
        }else{
            $alerta=[
                "alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"No hemos podido elinar lo seleccionado",
                "Tipo"=>"error"
            ];
        }

        return mainModel::sweet_alert($alerta);
    }
    

    public function update_unidadmed_controlador(){
        
        $id_unidad_med = mainModel::limpiar_cadena($_POST["id_um_formEdit"]);
        $descripcion = mainModel::limpiar_cadena($_POST["descripcion_formEdit"]);
        $abreviado = mainModel::limpiar_cadena($_POST["abrev_formEdit"]);

        $datos = [
            "id_unidad_med"=>$id_unidad_med,
            "descripcion"=>$descripcion,
            "abreviado"=>$abreviado
        ];

        $validar = unidadmedidaModelo::update_unidadmed_modelo($datos);

        if($validar->rowCount()>0){

            $alerta=[
                "alerta"=>"recargar",
                "Titulo"=>"Actualizado con exito",
                "Texto"=>"Unidad de medida actualizado",
                "Tipo"=>"success"
            ];
        }else{
            $alerta=[
                "alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"No hemos podido actualizar lo seleccionado",
                "Tipo"=>"error"
            ];
        }

        return mainModel::sweet_alert($alerta);

    }


    public function delete_unidadmed_controlador(){
        
        $id_unidad_med = mainModel::limpiar_cadena($_POST["id_um_formDel"]);

        $validar = unidadmedidaModelo::delete_unidadmed_modelo($id_unidad_med);

        if($validar->rowCount()>0){

            $alerta=[
                "alerta"=>"recargar",
                "Titulo"=>"Elimnado con exito",
                "Texto"=>"Unidad de medida actualizado",
                "Tipo"=>"success"
            ];
        }else{
            $alerta=[
                "alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"No hemos podido elinar lo seleccionado",
                "Tipo"=>"error"
            ];
        }

        return mainModel::sweet_alert($alerta);

    }
    public function select_combo($consulta,$val,$vis){
        return mainModel::ejecutar_combo($consulta,$val,$vis);
    }

    public function obtener_consulta_json_controlador($consulta){
        return mainModel::obtener_consulta_json($consulta);
    }






}