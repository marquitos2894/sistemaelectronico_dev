<?php 

if($peticionAjax){
    require_once '../modelos/personalModelo.php';
}else{
    require_once './modelos/personalModelo.php';
}

class personalControlador extends personalModelo {


    public function paginador_personal($paginador,$registros,$privilegio,$buscador,$vista,$unidad){

        $paginador=mainModel::limpiar_cadena($paginador);
        $registros=mainModel::limpiar_cadena($registros);
        $privilegio=mainModel::limpiar_cadena($privilegio);
        $tabla='';
        //echo $_SESSION['nombre_sbp'];
        $paginador=(isset($paginador) && $paginador>0)?(int)$paginador:1; 
        $inicio=($paginador>0)?(($paginador*$registros)-$registros):0;

        $conexion = mainModel::conectar();
        
        if($buscador!=""){
            $datos=$conexion->query("SELECT SQL_CALC_FOUND_ROWS p.id_per,p.Nom_per,p.Ape_per,p.Dni_per,cp.id_cargo,cp.cargo
            FROM personal p
            INNER JOIN cargopersonal cp ON p.id_cargo = cp.id_cargo
            WHERE ( p.Nom_per  like '%$buscador%' or p.Ape_per  like '%$buscador%' or p.Dni_per like '%$buscador%' or 
            cp.cargo like '%$buscador%' ) AND p.idunidad = {$unidad} AND p.est_baja = 1 AND p.est = 1
            ORDER BY Ape_per ASC   LIMIT {$inicio},{$registros}");
            
        }else{
            $datos=$conexion->query("SELECT SQL_CALC_FOUND_ROWS p.id_per,p.Nom_per,p.Ape_per,p.Dni_per,cp.id_cargo,cp.cargo
            FROM personal p
            INNER JOIN cargopersonal cp ON p.id_cargo = cp.id_cargo
            WHERE p.idunidad = {$unidad} AND p.est_baja = 1 AND p.est = 1
            ORDER BY Ape_per ASC   LIMIT {$inicio},{$registros}");           
        }
        //$datos->execute();
        $datos = $datos->fetchAll();
        $total = $conexion->query("SELECT FOUND_ROWS()");
        $total = (int)$total->fetchColumn();

        
        //devuel valor entero redondeado hacia arriba 4.2 = 5
        $Npaginas = ceil($total/$registros);
        
        /*$contenido.="<div class='card-group' style='width: 90%;' align='center' >";
        foreach(array_slice($datos,0,4) as $row){
            $contenido .="
                <div class='card'>
                    <img src='../vistas/img/avatar1.png' class='card-img-top'>
                    <div class='card-body'>
                        <h5 class='card-title'>{$row["Nom_per"]},{$row["Ape_per"]}</h5>
                        <p class='card-text'>N°DI/DNI: {$row["Dni_per"]}</p>
                        <p class='card-text'>Cargo: {$row["cargo"]}</p>
                    </div>
                    <div class='card-footer'>
                        <div class='form-row'>
                            <div class='form-group col-sm-4'>
                                <a style='font-size: 1.5em;'  class='fas fa-edit' href='{$row['id_per']}' id='EditItem' data-producto='{$row['id_per']}' data-toggle='modal' data-target='#ModalEdit'></a>
                            </div>
                            <div class='form-group col-sm-4'>
                                <form name='FrmDelComp' action='".SERVERURL."ajax/componentesAjax.php' method='POST' class='FormularioAjax' 
                                    data-form='delete' entype='multipart/form-data' autocomplete='off'>
                                    <input type='hidden' name='id_per_del' value='{$row['id_per']}'/>
                                    <button type='submit' class='btn btn-danger'><i class='fas fa-arrow-circle-down'></i></button> 
                                    <div class='RespuestaAjax'></div>   
                                </form>
                            </div>
                        </div>   
                    </div>
                </div>";
        }
        $contenido.="</div><br>";
        $contenido.="<div class='card-group' style='width: 90%;' align='center' >";
        foreach(array_slice($datos,4,8) as $row){
            $contenido .="
                <div class='card'>
                    <img src='../vistas/img/avatar1.png' class='card-img-top'>
                    <div class='card-body'>
                        <h5 class='card-title'>{$row['Nom_per']},{$row["Ape_per"]}</h5>
                        <p class='card-text'>N°DI/DNI: {$row["Dni_per"]}</p>
                        <p class='card-text'>Cargo: {$row["cargo"]}</p>
                    </div>
                    <div class='card-footer'>
                        <small class='text-muted'><a style='font-size: 1.5em;'  class='fas fa-edit' href='{$row['id_per']}' id='EditItem' data-producto='{$row['id_per']}' data-toggle='modal' data-target='#ModalEdit'></a></small>
                        <small class='text-muted'>
                            <form name='FrmDelComp' action='".SERVERURL."ajax/componentesAjax.php' method='POST' class='FormularioAjax' 
                                data-form='delete' entype='multipart/form-data' autocomplete='off'>
                                <input type='hidden' name='id_per_del' value='{$row['id_per']}'/>
                                <button type='submit' class='btn btn-danger'><i class='fas fa-arrow-circle-down'></i></button> 
                                <div class='RespuestaAjax'></div>   
                            </form>
                        </small>
                    </div>
                </div>";
        }
        $contenido.="</div>";*/

        $tabla.="<div class='table-responsive'><table class='table table-bordered'>
        <thead>
            <tr>
                <th scope='col'>#</th>
                <th scope='col'>Nombres</th>               
                <th scope='col'>Apellidos</th>
                <th scope='col'>Cargo</th>";
                if($privilegio==0 or $privilegio==1){
            $tabla.="
                <th colspan='2' scope='col'>Acciones</th>";
                //programar privilegios
                }
        $tabla.="</tr>
        </thead>
        <tbody id='table_personal' >";
        if($total>=1 && $paginador<=$Npaginas)
        {
              $i=1;  
            foreach($datos as $row){
                $tabla .="
            <tr>
                            <td>{$i}</td>
                            <td>{$row['Nom_per']}</td>                      
                            <td>{$row['Ape_per']}</td>
                            <td>{$row['cargo']}</td>";    

                if($privilegio==0 or $privilegio==1){
                    $tabla .="<td><a style='font-size: 1.5em;'  class='fas fa-edit' href='{$row['id_per']}' id='EditItem' data-item='{$row['id_per']}' data-toggle='modal' data-target='#ModalEdit'></a> </td>";
                            
                    $tabla .="
                    <td >
                        <form name='FrmDel_UM' action='".SERVERURL."ajax/personalAjax.php' method='POST' class='FormularioAjax' 
                            data-form='delete' entype='multipart/form-data' autocomplete='off'>
                            <input type='hidden' name='id_per_del' value='{$row['id_per']}'/>
                            <input type='hidden'  name='privilegio_sbp' value='{$privilegio}' />
                            <button type='submit' class='btn btn-danger'><i class='far fa-trash-alt'></i></button> 
                            <div class='RespuestaAjax'></div>   
                        </form>
                    </td>";
                }            
  

            $tabla .="
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

    public  function save_personal_controlador(){
        $correo_per= mainModel::limpiar_cadena($_POST["correo_per_in"]);
        $nom_per = mainModel::limpiar_cadena($_POST["nom_per_in"]);
        $ape_per = mainModel::limpiar_cadena($_POST["ape_per_in"]);
        $dni_per = mainModel::limpiar_cadena($_POST["dni_per_in"]);
        $brevete = mainModel::limpiar_cadena($_POST["brevete_in"]);
        $telefono = mainModel::limpiar_cadena($_POST["telefono_in"]);
        $direccion = mainModel::limpiar_cadena($_POST["direccion_in"]);
        $region = mainModel::limpiar_cadena($_POST["region_in"]);
        $ciudad = mainModel::limpiar_cadena($_POST["ciudad_in"]);
        $distrito = mainModel::limpiar_cadena($_POST["distrito_in"]);
        $cargo = mainModel::limpiar_cadena($_POST["cargo_in"]);
        $unidad = mainModel::limpiar_cadena($_POST["unidad_in"]);
        $privilegio = mainModel::limpiar_cadena($_POST["privilegio_sbp"]);

        $datosIN = [
            "correo_p"=>$correo_per,
            "nom_p"=>$nom_per,
            "ape_p"=>$ape_per,
            "dni_p"=>$dni_per,
            "brevete_p"=>$brevete,
            "telf_p"=>$telefono,
            "dir_p"=>$direccion,
            "urlimagen"=>"img3",
            "reg_p"=>$region,
            "ciu_p"=>$ciudad,
            "dis_p"=>$distrito,
            "cargo"=>$cargo,
            "unidad"=>$unidad
        ];

        $validarPrivilegios=mainModel::privilegios_transact($privilegio);

        if($validarPrivilegios){

            $validar = ($dni_per=="")?$validar=0:$validar=mainModel::ejecutar_consulta_validar("SELECT * FROM personal WHERE Dni_per = '{$dni_per}' AND est = 1")->rowCount();

            if($validar>0){

                $alerta=[
                    "alerta"=>"simple",
                    "Titulo"=>"Dni registrado",
                    "Texto"=>"El dni ya ha sido registrado, por favor verifique !",
                    "Tipo"=>"info"
                ];


            }else{

                if(personalModelo::save_personal_modelo($datosIN)->rowCount()>=1){
                    $alerta=[
                        "alerta"=>"recargar",
                        "Titulo"=>"Datos guardados",
                        "Texto"=>"Los siguientes datos han sido guardados",
                        "Tipo"=>"success"
                    ];
                }else{
                    $alerta=[
                        "alerta"=>"simple",
                        "Titulo"=>"Ocurrio un error inesperado",
                        "Texto"=>"No hemos podido actualizar los datos, contacte al admin",
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


    public  function update_personal_controlador(){
        $id_per= mainModel::limpiar_cadena($_POST["id_per_edit"]);
        $correo_per= mainModel::limpiar_cadena($_POST["correo_per_edit"]);
        $nom_per = mainModel::limpiar_cadena($_POST["nom_per_edit"]);
        $ape_per = mainModel::limpiar_cadena($_POST["ape_per_edit"]);
        $dni_per = mainModel::limpiar_cadena($_POST["dni_per_edit"]);
        $brevete = mainModel::limpiar_cadena($_POST["brevete_edit"]);
        $telefono = mainModel::limpiar_cadena($_POST["telefono_edit"]);
        $direccion = mainModel::limpiar_cadena($_POST["direccion_edit"]);
        $region = mainModel::limpiar_cadena($_POST["region_edit"]);
        $ciudad = mainModel::limpiar_cadena($_POST["ciudad_edit"]);
        $distrito = mainModel::limpiar_cadena($_POST["distrito_edit"]);
        $cargo = mainModel::limpiar_cadena($_POST["cargo_edit"]);
        $unidad = mainModel::limpiar_cadena($_POST["unidad_edit"]);
        $privilegio = mainModel::limpiar_cadena($_POST["privilegio_sbp"]);

        $datosIN = [
            "id_per"=>$id_per,
            "correo_p"=>$correo_per,
            "nom_p"=>$nom_per,
            "ape_p"=>$ape_per,
            "dni_p"=>$dni_per,
            "brevete_p"=>$brevete,
            "telf_p"=>$telefono,
            "dir_p"=>$direccion,
            "urlimagen"=>"img3",
            "reg_p"=>$region,
            "ciu_p"=>$ciudad,
            "dis_p"=>$distrito,
            "cargo"=>$cargo,
            "unidad"=>$unidad
        ];

        $validarPrivilegios=mainModel::privilegios_transact($privilegio);

        if($validarPrivilegios){
            $validar=personalModelo::update_personal_modelo($datosIN);
            if($validar->rowCount()>0){
                $alerta=[
                    "alerta"=>"recargar",
                    "Titulo"=>"Datos guardados",
                    "Texto"=>"Los siguientes datos han sido guardados",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta=[
                    "alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"No hemos podido actualizar los datos, contacte al admin",
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


    public function delete_personal_controlador(){

        $id_per = mainModel::limpiar_cadena($_POST["id_per_del"]);
        $privilegio = mainModel::limpiar_cadena($_POST["privilegio_sbp"]);
        
        
        $validarPrivilegios=mainModel::privilegios_transact($privilegio);

        if($validarPrivilegios){
            $validar=personalModelo::delete_personal_modelo($id_per);
            if($validar->rowCount()>=1){
                $alerta=[
                    "alerta"=>"recargar",
                    "Titulo"=>"Datos Eliminados",
                    "Texto"=>"Los siguientes datos han sido eliminados",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta=[
                    "alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"No hemos podido actualizar los datos, contacte al admin",
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

    public function obtener_consulta_json_controlador($consulta){
        return mainModel::obtener_consulta_json($consulta);
    }
    

    //SE DEJARA DE USAR** POR select_combo
    public function chosen_cargo($val,$vis){

        $consulta = "select * from cargopersonal";

        return mainModel::ejecutar_combo($consulta,$val,$vis);
    }

    //SE DEJARA DE USAR** POR select_combo
    public function chosen_unidad($val,$vis){

        $consulta = "select * from unidad";

        return mainModel::ejecutar_combo($consulta,$val,$vis);
    }

    public function select_combo($consulta,$val,$vis){
        return mainModel::ejecutar_combo($consulta,$val,$vis);
    }
}
?>