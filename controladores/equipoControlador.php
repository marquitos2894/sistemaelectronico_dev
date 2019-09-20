<?php

if($peticionAjax){
    require_once '../modelos/equipoModelo.php';
}else{
    require_once './modelos/equipoModelo.php';
}

Class equipoControlador extends equipoModelo {

    public function paginador_equipos($paginador,$registros,$privilegio,$buscador,$vista){

        $paginador=mainModel::limpiar_cadena($paginador);
        $registros=mainModel::limpiar_cadena($registros);
        $privilegio=mainModel::limpiar_cadena($privilegio);
        $tabla='';
        //echo $_SESSION['nombre_sbp'];
        $paginador=(isset($paginador) && $paginador>0)?(int)$paginador:1; 
        $inicio=($paginador>0)?(($paginador*$registros)-$registros):0;

        $conexion = mainModel::conectar();
        
        if($buscador!=""){
            $datos=$conexion->query("SELECT SQL_CALC_FOUND_ROWS e.Id_Equipo,e.Nombre_Equipo,e.AnoFab_Equipo,e.FechaLlegada_Equipo,
            e.Tipo_Equipo,e.Aplicacion_Equipo,e.Marca_Equipo,e.Modelo_Equipo,e.NSerie_Equipo,
            e.Capacidad_Equipo,e.ModeloMotor_Equipo,e.SerieMotor_Equipo,e.MarcaMotor_Equipo,e.id_categoria
            FROM equipos e
            WHERE ( e.Marca_Equipo  like '%$buscador%' or e.Modelo_Equipo like '%$buscador%' or e.NSerie_Equipo 
            like '%$buscador%' or e.Tipo_Equipo like '%$buscador%' or e.Aplicacion_Equipo like '%$buscador%') 
            AND Id_Equipo !=1 AND var_propiedad = 1 AND est = 1 AND est_baja = 1 LIMIT {$inicio},{$registros} ");
            
        }else{
            $datos=$conexion->query("SELECT SQL_CALC_FOUND_ROWS *
            FROM equipos
            WHERE Id_Equipo !=1 AND var_propiedad = 1 AND est = 1 AND est_baja = 1  LIMIT {$inicio},{$registros}");           
        }
        //$datos->execute();
        $datos = $datos->fetchAll();
        $total = $conexion->query("SELECT FOUND_ROWS()");
        $total = (int)$total->fetchColumn();

        
        //devuel valor entero redondeado hacia arriba 4.2 = 5
        $Npaginas = ceil($total/$registros);
        $tabla.="
        <div class='table-responsive'><table class='table table-bordered'>
            <thead>
                <tr>
                    <th scope='col'>#</th>
                    <th scope='col'>Modelo</th>               
                    <th scope='col'>Tipo-Aplicacion</th>
                    <th scope='col'>Marca</th>
                    <th scope='col'>N°Serie</th>
                    <th scope='col'>Cap.</th>
                    <th scope='col'>AñoFab</th>
                    <th scope='col'>Motor</th>
                    <th scope='col'>MarcaMotor</th>
                    <th scope='col'>N°Ser.Motor</th>";
                    if($privilegio==0 or $privilegio==1){
                    $tabla.="
                    <th colspan='2' scope='col'>Acciones</th>";
                    }
                    //programar privilegios
            $tabla.="</tr>
            </thead>
            <tbody id='table_equipos' >";
        $contador=$inicio+1;
        if($total>=1 && $paginador<=$Npaginas)
        {
        
            foreach($datos as $row){
                $tabla .="
                <tr>

                    <td>{$contador}</td>
                    <td>{$row['Modelo_Equipo']}</td>                      
                    <td>{$row['Tipo_Equipo']}-{$row['Aplicacion_Equipo']}</td>
                    <td>{$row['Marca_Equipo']}</td>
                    <td>{$row['NSerie_Equipo']}</td>
                    <td>{$row['Capacidad_Equipo']}</td>
                    <td>{$row['AnoFab_Equipo']}</td>
                    <td>{$row['ModeloMotor_Equipo']}</td>
                    <td>{$row['MarcaMotor_Equipo']}</td>
                    <td>{$row['SerieMotor_Equipo']}</td>";
                    if($privilegio==0 or $privilegio==1){                                 
                    $tabla .="
                    <td><a style='font-size: 1.5em;'  class='fas fa-edit' href='{$row['Id_Equipo']}' id='EditItem' data-equipo='{$row['Id_Equipo']}' data-toggle='modal' data-target='#ModalEdit'></a> </td>";
                    $tabla .="
                    <td >
                        <form name='FrmDelEquipo' action='".SERVERURL."ajax/equiposAjax.php' method='POST' class='FormularioAjax' 
                            data-form='delete' entype='multipart/form-data' autocomplete='off'>
                            <input type='hidden' name='Id_Equipo_darBaja' value='{$row['Id_Equipo']}'/>
                            <input type='hidden'  name='privilegio_sbp' value='{$privilegio}' />
                            <button type='submit' class='btn btn-danger'><i class='fas fa-arrow-circle-down'></i></button> 
                            <div class='RespuestaAjax'></div>   
                        </form>
                    </td>";
                    }        
                $tabla .="
                </tr>";
            $contador++;
            }
        }else{
            $tabla.='<tr><td colspan="7"> No existen registros</td></tr>';
        }

        $tabla.='</tbody></table></div>';
   
        $tabla.= mainModel::paginador($total,$paginador,$Npaginas,$vista);
        return $tabla;
    }

    
    public function paginador_equipos_unidad($paginador,$registros,$privilegio,$buscador,$vista,$unidad){

        $paginador=mainModel::limpiar_cadena($paginador);
        $registros=mainModel::limpiar_cadena($registros);
        $privilegio=mainModel::limpiar_cadena($privilegio);
        $tabla='';
        //echo $_SESSION['nombre_sbp'];
        $paginador=(isset($paginador) && $paginador>0)?(int)$paginador:1; 
        $inicio=($paginador>0)?(($paginador*$registros)-$registros):0;

        $conexion = mainModel::conectar();
        $est_baja=($vista=="miFlota")?$est_baja=1:$est_baja=0;
            if($buscador!=""){
                $datos=$conexion->query("SELECT SQL_CALC_FOUND_ROWS eu.id_equipounidad,eu.fk_idequipo,eu.alias_equipounidad,e.Modelo_Equipo,e.Tipo_Equipo,e.Aplicacion_Equipo,e.Marca_Equipo,
                e.NSerie_Equipo,e.ModeloMotor_Equipo,e.MarcaMotor_Equipo,e.SerieMotor_Equipo,eu.estado_equipounidad
                FROM equipo_unidad eu
                INNER JOIN equipos e ON e.Id_Equipo = eu.fk_idequipo
                WHERE ( eu.alias_equipounidad  like '%$buscador%' or e.Modelo_Equipo like '%$buscador%' or e.NSerie_Equipo 
                like '%$buscador%' or e.Tipo_Equipo like '%$buscador%' or e.Aplicacion_Equipo like '%$buscador%') 
                AND eu.fk_idunidad = {$unidad} AND eu.est_baja = {$est_baja} AND eu.est=1 LIMIT {$inicio},{$registros} ");
                
            }else{
                $datos=$conexion->query("SELECT SQL_CALC_FOUND_ROWS eu.id_equipounidad,eu.fk_idequipo,eu.alias_equipounidad,e.Modelo_Equipo,e.Tipo_Equipo,e.Aplicacion_Equipo,e.Marca_Equipo,
                e.NSerie_Equipo,e.ModeloMotor_Equipo,e.MarcaMotor_Equipo,e.SerieMotor_Equipo,eu.estado_equipounidad
                FROM equipo_unidad eu
                INNER JOIN equipos e ON e.Id_Equipo = eu.fk_idequipo
                WHERE eu.fk_idunidad = {$unidad}  AND eu.est_baja = {$est_baja}  AND eu.est=1 LIMIT {$inicio},{$registros}");           
            }

        //$datos->execute();
        $datos = $datos->fetchAll();
        $total = $conexion->query("SELECT FOUND_ROWS()");
        $total = (int)$total->fetchColumn();

        
        //devuel valor entero redondeado hacia arriba 4.2 = 5
        $Npaginas = ceil($total/$registros);

                $tabla.="<div class='table-responsive'><table class='table table-bordered'>
                <thead>
                    <tr>
                        <th scope='col'>#</th>
                        <th scope='col'>Alias</th>
                        <th scope='col'>Modelo</th>               
                        <th scope='col'>Tipo-Aplicacion</th>
                        <th scope='col'>Marca</th>
                        <th scope='col'>N°Serie</th>
                        <th scope='col'>Motor</th>
                        <th scope='col'>MarcaMotor</th>
                        <th scope='col'>N°Ser.Motor</th>
                        <th scope='col'>Estado</th>";
                        if($privilegio==0 or $privilegio==1){
                        $tabla.="
                        <th colspan='2' scope='col'>Acciones</th>";
                        }
                        //programar privilegios
                $tabla.="</tr>
                </thead>
                <tbody id='table_miFlota' >";
                $contador=$inicio+1;
                if($total>=1 && $paginador<=$Npaginas)
                {
                
                    foreach($datos as $row){
                            $tabla .="
                        <tr>            
                            <td>{$contador}</td>
                                <td>{$row['alias_equipounidad']}</td>  
                                <td>{$row['Modelo_Equipo']}</td>                      
                                <td>{$row['Tipo_Equipo']}-{$row['Aplicacion_Equipo']}</td>
                                <td>{$row['Marca_Equipo']}</td>
                                <td>{$row['NSerie_Equipo']}</td>
                                <td>{$row['ModeloMotor_Equipo']}</td>
                                <td>{$row['MarcaMotor_Equipo']}</td>
                                <td>{$row['SerieMotor_Equipo']}</td>
                                <td>{$row['estado_equipounidad']}</td>";
                        if($privilegio==0 or $privilegio==1){
                                           
                            if($est_baja==1){
                                $tabla .="
                                <td><a style='font-size: 1.5em;'  class='fas fa-edit' href='{$row['id_equipounidad']}' id='EditItem' data-equipo='{$row['id_equipounidad']}' data-toggle='modal' data-target='#ModalEdit'></a> </td>";
                            }                                  
                        
                                        
                                $tabla .="
                                <td>
                                    <form name='FrmDelEquipo' action='".SERVERURL."ajax/equiposAjax.php' method='POST' class='FormularioAjax' 
                                        data-form='update' entype='multipart/form-data' autocomplete='off'>";
                            if($est_baja==1){
                                    $tabla .="
                                        <input type='hidden' name='idequipounidad_darBaja' value='{$row['id_equipounidad']}'/>
                                        <button type='submit' class='btn btn-danger'><i class='fas fa-arrow-circle-down'></i></button>";
                            }else{
                                    $tabla .="
                                        <input type='hidden' name='idequipounidad_darAlta' value='{$row['id_equipounidad']}'/>
                                        <button type='submit' class='btn btn-success'><i class='fas fa-arrow-circle-up'></i></button>";
                            }
                                    $tabla .="
                                        <input type='hidden'  name='privilegio_sbp' value='{$privilegio}' />
                                        <div class='RespuestaAjax'></div>   
                                    </form>
                                </td>";
                            
                            if($est_baja==0){
                                $tabla .="   
                                <td>
                                    <form name='Frm_ue' action='".SERVERURL."ajax/equiposAjax.php' method='POST' class='FormularioAjax' 
                                        data-form='update' entype='multipart/form-data' autocomplete='off'>
                                        <input type='hidden' name='idequipounidad_delete' value='{$row['id_equipounidad']}'/>
                                        <input type='hidden'  name='privilegio_sbp' value='{$privilegio}' />
                                        <button type='submit' class='btn btn-danger'><i class='far fa-trash-alt'></i></button>
                                        <div class='RespuestaAjax'></div>   
                                    </form>
                                </td>";
                            }
                        }
                        $tabla .="
                        </tr>";

                    $contador++;
                    }
                    
                }else{
                    $tabla.='<tr><td colspan="7"> No existen registros</td></tr>';
                }
        
                $tabla.='</tbody></table></div>';
        

   
        $tabla.= mainModel::paginador($total,$paginador,$Npaginas,$vista);
        return $tabla;
    }

    public function validar_paginador_controlador($buscador,$vista,$eliminar_buscador){
        return mainModel::validar_paginador($buscador,$vista,$eliminar_buscador);
    }

    public function save_equipos_controlador(){

        $Modelo_Equipo= mainModel::limpiar_cadena($_POST["Modelo_Equipo_save"]);
        $Tipo_Equipo = mainModel::limpiar_cadena($_POST["Tipo_Equipo_save"]);
        $Aplicacion_Equipo = mainModel::limpiar_cadena($_POST["Aplicacion_Equipo_save"]);
        $Marca_Equipo= mainModel::limpiar_cadena($_POST["Marca_Equipo_save"]);
        $NSerie_Equipo = mainModel::limpiar_cadena($_POST["NSerie_Equipo_save"]);
        $Capacidad_Equipo = mainModel::limpiar_cadena($_POST["Capacidad_Equipo_save"]);
        $AnoFab_Equipo = mainModel::limpiar_cadena($_POST["AnoFab_Equipo_save"]);
        $id_categoria = mainModel::limpiar_cadena($_POST["categoria_equipo_save"]);
        $ModeloMotor_Equipo = mainModel::limpiar_cadena($_POST["ModeloMotor_Equipo_save"]);
        $MarcaMotor_Equipo = mainModel::limpiar_cadena($_POST["MarcaMotor_Equipo_save"]);
        $SerieMotor_Equipo = mainModel::limpiar_cadena($_POST["SerieMotor_Equipo_save"]);
        $privilegio = mainModel::limpiar_cadena($_POST["privilegio_sbp"]);

        $datos = [
            "Modelo_Equipo"=>$Modelo_Equipo,
            "Tipo_Equipo"=>$Tipo_Equipo,
            "Aplicacion_Equipo"=>$Aplicacion_Equipo,
            "Marca_Equipo"=>$Marca_Equipo,
            "NSerie_Equipo"=>$NSerie_Equipo,
            "Capacidad_Equipo"=>$Capacidad_Equipo,
            "AnoFab_Equipo"=>$AnoFab_Equipo,
            "id_categoria"=>$id_categoria,
            "ModeloMotor_Equipo"=>$ModeloMotor_Equipo,
            "MarcaMotor_Equipo"=>$MarcaMotor_Equipo,
            "SerieMotor_Equipo"=>$SerieMotor_Equipo
        ];

        $validarPrivilegios=mainModel::privilegios_transact($privilegio);

        if($validarPrivilegios){
            $validar = equipoModelo::save_equipos_modelo($datos);

            if($validar->rowCount()>0){
                $alerta=[
                    "alerta"=>"recargar",
                    "Titulo"=>"Datos Guardados",
                    "Texto"=>"Los siguientes datos han sido guardados",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta=[
                    "alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"No hemos podido actualizar el equipo seleccionado",
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

    public function update_equipos_controlador(){

        $Id_Equipo = mainModel::limpiar_cadena($_POST["Id_Equipo_edit"]);
        $Modelo_Equipo= mainModel::limpiar_cadena($_POST["Modelo_Equipo_edit"]);
        $Tipo_Equipo = mainModel::limpiar_cadena($_POST["Tipo_Equipo_edit"]);
        $Aplicacion_Equipo = mainModel::limpiar_cadena($_POST["Aplicacion_Equipo_edit"]);
        $Marca_Equipo= mainModel::limpiar_cadena($_POST["Marca_Equipo_edit"]);
        $NSerie_Equipo = mainModel::limpiar_cadena($_POST["NSerie_Equipo_edit"]);
        $Capacidad_Equipo = mainModel::limpiar_cadena($_POST["Capacidad_Equipo_edit"]);
        $AnoFab_Equipo = mainModel::limpiar_cadena($_POST["AnoFab_Equipo_edit"]);
        $ModeloMotor_Equipo = mainModel::limpiar_cadena($_POST["ModeloMotor_Equipo_edit"]);
        $MarcaMotor_Equipo = mainModel::limpiar_cadena($_POST["MarcaMotor_Equipo_edit"]);
        $SerieMotor_Equipo = mainModel::limpiar_cadena($_POST["SerieMotor_Equipo_edit"]);
        $privilegio = mainModel::limpiar_cadena($_POST["privilegio_sbp"]);

        $datos = [
            "Id_Equipo"=>$Id_Equipo,
            "Modelo_Equipo"=>$Modelo_Equipo,
            "Tipo_Equipo"=>$Tipo_Equipo,
            "Aplicacion_Equipo"=>$Aplicacion_Equipo,
            "Marca_Equipo"=>$Marca_Equipo,
            "NSerie_Equipo"=>$NSerie_Equipo,
            "Capacidad_Equipo"=>$Capacidad_Equipo,
            "AnoFab_Equipo"=>$AnoFab_Equipo,
            "ModeloMotor_Equipo"=>$ModeloMotor_Equipo,
            "MarcaMotor_Equipo"=>$MarcaMotor_Equipo,
            "SerieMotor_Equipo"=>$SerieMotor_Equipo
        ];
        
        $validarPrivilegios=mainModel::privilegios_transact($privilegio);

        if($validarPrivilegios){
            $validar = equipoModelo::update_equipos_modelo($datos);

            if($validar->rowCount()>0){
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
                    "Texto"=>"No hemos podido actualizar el equipo seleccionado",
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

    public function darbaja_equipo_controlador(){
        $Id_Equipo = mainModel::limpiar_cadena($_POST["Id_Equipo_darBaja"]);
        $privilegio = mainModel::limpiar_cadena($_POST["privilegio_sbp"]);

        $validar=equipoModelo::darbaja_equipo_modelo($Id_Equipo);

        if($validar->rowCount()>0){
            $alerta=[
                "alerta"=>"recargar",
                "Titulo"=>"Equipo dado de Baja",
                "Texto"=>"El siguiente equipo ha sido dado de baja",
                "Tipo"=>"success"
            ];
        }else{
            $alerta=[
                "alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"No hemos podido realizar la accion requerida en el equipo seleccionado",
                "Tipo"=>"error"
            ];
        }

        return mainModel::sweet_alert($alerta);
    }

    public function delete_equipo_controlador(){
        $Id_Equipo = mainModel::limpiar_cadena($_POST["Id_Equipo_delete"]);
        $privilegio = mainModel::limpiar_cadena($_POST["privilegio_sbp"]);

        $validarPrivilegios=mainModel::privilegios_transact($privilegio);

        if($validarPrivilegios){
            $validar=equipoModelo::delete_equipo_modelo($Id_Equipo);
            if($validar->rowCount()>0){
                $alerta=[
                    "alerta"=>"recargar",
                    "Titulo"=>"Equipo eliminado",
                    "Texto"=>"El siguiente equipo ha sido eliminado",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta=[
                    "alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"No hemos podido realizar la accion requerida en el equipo seleccionado",
                    "Tipo"=>"error"
                ];
            }
        }else{
            $alerta=[
                "alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"No hemos podido realizar la accion requerida en el equipo seleccionado",
                "Tipo"=>"error"
            ];    
        }
        return mainModel::sweet_alert($alerta);
    }

    /***** MI FLOTA*** */


    public function save_flota_controlador(){

        $fk_idequipo = mainModel::limpiar_cadena($_POST["equipo_agregarF"]);
        $fk_idunidad = mainModel::limpiar_cadena($_POST["session_idunidad_agregarF"]);
        $alias_equipounidad = mainModel::limpiar_cadena($_POST["Alias_Equipo_agregarF"]);
        $estado_equipounidad = mainModel::limpiar_cadena($_POST["estado_equipo_agregarF"]);
        $privilegio = mainModel::limpiar_cadena($_POST["privilegio_sbp"]);

        $datos = [
            "fk_idequipo"=>$fk_idequipo,
            "fk_idunidad"=>$fk_idunidad,
            "alias_equipounidad"=>$alias_equipounidad,
            "estado_equipounidad"=>$estado_equipounidad
        ];

        $validarPrivilegios=mainModel::privilegios_transact($privilegio);
        if($validarPrivilegios){
            $validar=mainModel::ejecutar_consulta_validar("SELECT * FROM equipo_unidad WHERE fk_idequipo = {$fk_idequipo} AND fk_idunidad = {$fk_idunidad}");

            if($validar->rowCount()>0){
                $dato=mainModel::ejecutar_consulta_simple("SELECT * FROM  equipo_unidad WHERE fk_idequipo = {$fk_idequipo} ");

                $alerta=[
                    "alerta"=>"simple",
                    "Titulo"=>"Ya se encuentra registrado",
                    "Texto"=>"El equipo que desea agregar ya esta registrado como <h2><strong>{$dato["alias_equipounidad"]}</strong></h2>",
                    "Tipo"=>"info"
                ];    

            }else{
                $validar=equipoModelo::save_flota_modelo($datos);
                if($validar->rowCount()>0){
                    $alerta=[
                        "alerta"=>"recargar",
                        "Titulo"=>"Datos Guardados",
                        "Texto"=>"Los siguientes datos han sido guardados",
                        "Tipo"=>"success"
                    ];
                }else{
                    $alerta=[
                        "alerta"=>"simple",
                        "Titulo"=>"Ocurrio un error inesperado",
                        "Texto"=>"No hemos podido actualizar el equipo seleccionado",
                        "Tipo"=>"error"
                    ];
                }
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

    public function update_flota_controlador(){

        $id_equipounidad = mainModel::limpiar_cadena($_POST["id_eu_edit"]);
        $alias_equipounidad = mainModel::limpiar_cadena($_POST["alias_eu_edit"]);
        $estado_equipounidad = mainModel::limpiar_cadena($_POST["estado_eu_edit"]);
        $privilegio = mainModel::limpiar_cadena($_POST["privilegio_sbp"]);

        $datos = [
            "id_equipounidad"=>$id_equipounidad,
            "alias_equipounidad"=>$alias_equipounidad,
            "estado_equipounidad"=>$estado_equipounidad
        ];

        
        $validarPrivilegios=mainModel::privilegios_transact($privilegio);
        if($validarPrivilegios){
            $validar=equipoModelo::update_flota_modelo($datos);
            if($validar->rowCount()>0){
                $alerta=[
                    "alerta"=>"recargar",
                    "Titulo"=>"Datos Actualizados",
                    "Texto"=>"Los siguientes datos han sido actualizados",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta=[
                    "alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"No hemos podido actualizar el equipo seleccionado",
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

    public function darbaja_flota_controlador(){
        $id_equipounidad = mainModel::limpiar_cadena($_POST["idequipounidad_darBaja"]);
        $privilegio = mainModel::limpiar_cadena($_POST["privilegio_sbp"]);

        $validarPrivilegios=mainModel::privilegios_transact($privilegio);

        if($validarPrivilegios){
            $validar=equipoModelo::darbaja_flota_modelo($id_equipounidad);

            if($validar->rowCount()>0){
                $alerta=[
                    "alerta"=>"recargar",
                    "Titulo"=>"Equipo dado de Baja",
                    "Texto"=>"El siguiente equipo ha sido dado de baja",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta=[
                    "alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"No hemos podido realizar la accion requerida en el equipo seleccionado",
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

    public function darAlta_flota_controlador(){

        $id_equipounidad = mainModel::limpiar_cadena($_POST["idequipounidad_darAlta"]);
        $privilegio = mainModel::limpiar_cadena($_POST["privilegio_sbp"]);

        $validarPrivilegios=mainModel::privilegios_transact($privilegio);
        if($validarPrivilegios){
            $validar=equipoModelo::darAlta_flota_modelo($id_equipounidad);

            if($validar->rowCount()>0){
                $alerta=[
                    "alerta"=>"recargar",
                    "Titulo"=>"Equipo dado de Alta",
                    "Texto"=>"El siguiente equipo ha sido dado de Alta",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta=[
                    "alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"No hemos podido realizar la accion requerida en el equipo seleccionado",
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

    public function delete_flota_controlador(){
        
        $id_equipounidad = mainModel::limpiar_cadena($_POST["idequipounidad_delete"]);
        $privilegio = mainModel::limpiar_cadena($_POST["privilegio_sbp"]);

        $validarPrivilegios=mainModel::privilegios_transact($privilegio);
        if($validarPrivilegios){
            $validar=equipoModelo::delete_flota_modelo($id_equipounidad);
            if($validar->rowCount()>0){
                $alerta=[
                    "alerta"=>"recargar",
                    "Titulo"=>"Equipo eliminado",
                    "Texto"=>"El siguiente equipo ha sido eliminado",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta=[
                    "alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"No hemos podido realizar la accion requerida en el equipo seleccionado",
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

    

    /***END MI FLOTA */
    public function obtener_consulta_json_controlador($consulta){
        return mainModel::obtener_consulta_json($consulta);
    }
    

    public function select_combo($consulta,$val,$vis){
        return mainModel::ejecutar_combo($consulta,$val,$vis);
    }

}