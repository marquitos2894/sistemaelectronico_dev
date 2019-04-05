<?php 

if($peticionAjax){
    require_once '../modelos/adminModelo.php';
}else{
    require_once './modelos/adminModelo.php';
}

class adminControlador extends adminModelo
{


    public function paginador_usuarios($paginador,$registros,$privilegio,$codigo,$buscador){


        $paginador=mainModel::limpiar_cadena($paginador);
        $registros=mainModel::limpiar_cadena($registros);
        $privilegio=mainModel::limpiar_cadena($privilegio);
        $codigo=mainModel::limpiar_cadena($codigo);
        $tabla='';

        $paginador=(isset($paginador) && $paginador>0)?(int)$paginador:1; 
        $inicio=($paginador>0)?(($paginador*$registros)-$registros):0;
        
        $conexion = mainModel::conectar();
        if($buscador!=""){

            //select limit recibe dos parametros inicio y logitud
            // SQL_CALC_FOUND_ROWS - obtiene la consulta los datos de las columnos de forma temporal y con FOUND_ROWS() -> obtiene el numero de filas
            $datos=$conexion->query("select SQL_CALC_FOUND_ROWS * FROM usuario where id_usu !={$codigo} and id_usu !=3 and Correo like '%{$buscador}%'  and estado >= 1  order by Correo asc limit {$inicio},{$registros}");
            $datos = $datos->fetchAll();
            $total = $conexion->query("SELECT FOUND_ROWS()");
            // pdo:fetchColumn() obtiene la fila 0 de la primera columna y fetchColumn(1) obtiene la fila 1 de la primera columna 

        }else{
                //select limit recibe dos parametros inicio y logitud
            // SQL_CALC_FOUND_ROWS - obtiene la consulta los datos de las columnos de forma temporal y con FOUND_ROWS() -> obtiene el numero de filas
            $datos=$conexion->query("select SQL_CALC_FOUND_ROWS * FROM usuario where id_usu !={$codigo} and id_usu !=3 and estado >= 1   order by Correo asc limit {$inicio},{$registros}");
            $datos = $datos->fetchAll();
            $total = $conexion->query("SELECT FOUND_ROWS()");
            

        }
        // pdo:fetchColumn() obtiene la fila 0 de la primera columna y fetchColumn(1) obtiene la fila 1 de la primera columna 
        $total = (int)$total->fetchColumn();
        //devuel valor entero redondeado hacia arriba 4.2 = 5
        $Npaginas = ceil($total/$registros);

        $tabla.='<div class="table-responsive"><table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Correo</th>
                <th scope="col">Nombres</th>
                <th scope="col">Privilegio</th>';

            if($privilegio>=1)
            { 
                $tabla.= '<th scope="col">Actualizar</th>';
            }
            if($privilegio==0){
                $tabla.="<th scope='col'>Actualizar</th>
                        <th scope='col'>Eliminar</th>";
            }            

            $tabla.="</tr>
            </thead>
            <tbody>";
           

        if($total>=1 && $paginador<=$Npaginas)
        {
            $contador = $inicio+1;
            foreach($datos as $row)
            {
            $tabla.="<tr>
                        <td>{$contador}</td>
                        <td>{$row[1]}</td>
                        <td>{$row[3]}</td>
                        <td>{$row[6]}</td>";

                        if($privilegio==1)
                        { 
                            $tabla.= "<td><a class='far fa-edit' href=".SERVERURL."perfil/".mainModel::encryption($row[0])."/"."></a></td>";
                        }
                        if($privilegio==0){
                            $tabla.="<td><a class='far fa-edit' href=".SERVERURL."perfil/".mainModel::encryption($row[0])."/"."></a></td>
                                     <td><form action='".SERVERURL."ajax/administradorAjax.php' method='POST' class='FormularioAjax' 
                                        data-form='delete' entype='multipart/form-data' autocomplete='off'>
                                        <input type='hidden' name='id_usu' value='".mainModel::encryption($row[0])."'
                                        
                                        <i class='far fa-trash-alt'><button type='submit' class='far fa-trash-alt'></button></i>
                                        <div class='RespuestaAjax'></div>   
                                        </form></td>";
                        }   
                        
            $tabla.="</tr>";

                    $contador++;
            }
           
        }else
        {
            $tabla.='<tr><td colspan="4"> No existen registros</td> </tr>';
        }


        $tabla.='</tbody></table></div>';

        if($total>=1 && $paginador<=$Npaginas)
        {
            $tabla.='<nav aria-label="Page navigation example"><ul class="pagination">';

            if($paginador==1){
                $tabla.='<li class="page-item"><a class="page-link">Atras</a></li>';
            }else{
                $tabla.='<li class="page-item"><a class="page-link" href="'.SERVERURL.'usuariolist/'.($paginador-1).'">Atras</a></li>';
            }

            for($i=1;$i<=$Npaginas;$i++){
                if($paginador!=$i){
                    $tabla.='<li class="active"><a class="page-link" href="'.SERVERURL.'usuariolist/'.$i.'">'.$i.'</a></li>';
                }else{
                    $tabla.='<li class="page-item"><a class="page-link">'.$i.'</a></li>';
                }
            }

            if($paginador==$Npaginas){
                $tabla.='<li class="page-item"><a class="page-link">Next</a></li>';
            }else{
                $tabla.='<li class="page-item"><a class="page-link" href="'.SERVERURL.'usuariolist/'.($paginador+1).'">Next</a></li>';
            }
            

            $tabla.='</ul></nav>';
        }

        return $tabla;
    }

    public function eliminar_usuario_controlador(){
        $id = mainModel::decryption($_POST['id_usu']);
        $id = mainModel::limpiar_cadena($id);

        $Delusuario=adminModelo::eliminar_usuario_modelo($id);
        if($Delusuario->rowCount()>=1){
            $alerta=[
                "alerta"=>"recargar",
                "Titulo"=>"Usuario eliminado",
                "Texto"=>"El usuario fue eliminado con exito",
                "Tipo"=>"success"
            ];

        }else{
            $alerta=[
                "alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"No se puede eliminar el siguiente usuario en estos momentos, contacte al admin",
                "Tipo"=>"error"
            ];

        }
    return mainModel::sweet_alert($alerta);
    }


    public function Update_administrado_controlador(){
        $codigo = mainModel::decryption($_POST["codigo_up"]);
        $correo_per_up = mainModel::limpiar_cadena($_POST["correo_per_up"]);
        $nom_per_up = mainModel::limpiar_cadena($_POST["nom_per_up"]);
        $ape_per_up = mainModel::limpiar_cadena($_POST["ape_per_up"]);
        $dni_per_up = mainModel::limpiar_cadena($_POST["dni_per_up"]);
        $brevete_up = mainModel::limpiar_cadena($_POST["brevete_up"]);
        $telefono_up = mainModel::limpiar_cadena($_POST["telefono_up"]);
        $direccion_up = mainModel::limpiar_cadena($_POST["direccion_up"]);
        $region_up = mainModel::limpiar_cadena($_POST["region_up"]);
        $ciudad_up = mainModel::limpiar_cadena($_POST["ciudad_up"]);
        $distrito_up = mainModel::limpiar_cadena($_POST["distrito_up"]);
        $correo_usu_up = mainModel::limpiar_cadena($_POST["correo_usu_up"]);
        $tipo_up = mainModel::limpiar_cadena($_POST["tipo_up"]);
        $estado_up = mainModel::limpiar_cadena($_POST["estado_up"]);
        $passwor1_up = mainModel::limpiar_cadena($_POST["passwor1_up"]);
        $passwor2_up = mainModel::limpiar_cadena($_POST["passwor2_up"]);
        $password_incial_up = mainModel::limpiar_cadena($_POST["password_incial_up"]);

        $sql = mainModel::ejecutar_consulta_simple("SELECT u.Correo,p.Dni_per
        FROM usuario u
        INNER JOIN personal p ON  p.id_per = u.fk_idper
        WHERE id_usu  = {$codigo} ");

        $datos = $sql->fetch();
        
       // $valdni = mainModel::ejecutar_consulta_simple("SELECT * FROM personal WHERE Dni_per = {$dni_per_up} ");

            if($correo_usu_up!=$datos["Correo"]){
            $valcorreo = mainModel::ejecutar_consulta_simple("SELECT Correo FROM usuario WHERE Correo = '{$correo_usu_up}' ");
                if($valcorreo->rowCount()>=1){                                            
                        $alerta=[
                        "alerta"=>"simple",
                        "Titulo"=>"El dato que ha ingresa ya existe",
                        "Texto"=>"El correo que ha ingresado  ya se encuentra registrado intente de nuevo ",
                        "Tipo"=>"error"
                    ];
                    return mainModel::sweet_alert($alerta);
                    exit();
                }
            }

            if($dni_per_up!=$datos["Dni_per"]){
            $valdni = mainModel::ejecutar_consulta_simple("SELECT dni_per FROM personal  WHERE Dni_per = {$dni_per_up} ");
                if($valdni->rowCount()>=1){                                            
                        $alerta=[
                        "alerta"=>"simple",
                        "Titulo"=>"El dato que ha ingresa ya existe",
                        "Texto"=>"El DNI que ha ingresado  ya se encuentra registrado intente de nuevo",
                        "Tipo"=>"error"
                    ];
                    return mainModel::sweet_alert($alerta);
                    exit();
                }
            }

            if($passwor1_up!=$passwor2_up){
                $alerta=[
                    "alerta"=>"simple",
                    "Titulo"=>"Contraseñas no coinciden",
                    "Texto"=>"Los datos de password ingresados no coinciden",
                    "Tipo"=>"error"
                ];
            }
            else{
                $password = $password_incial_up ;
                if($passwor1_up!="" && $passwor1_up==$passwor2_up){
                    $password = $passwor1_up;
                }
                
                $datosUP = [
                    "codigo"=>$codigo,
                    "correo_p"=>$correo_per_up,
                    "nom_p"=>$nom_per_up,
                    "ape_p"=>$ape_per_up,
                    "dni_p"=>$dni_per_up,
                    "brevete_p"=>$brevete_up,
                    "telf_p"=>$telefono_up,
                    "dir_p"=>$direccion_up,
                    "reg_p"=>$region_up,
                    "ciu_p"=>$ciudad_up,
                    "dis_p"=>$distrito_up,
                    "correo_u"=>$correo_usu_up,
                    "tipo_u"=>$tipo_up,
                    "estado_u"=>$estado_up,
                    "pass_u"=>$password
                ];

                if(adminModelo::Update_administrado_modelo($datosUP)){
                    $alerta=[
                        "alerta"=>"recargar",
                        "Titulo"=>"Usuario Actualizado",
                        "Texto"=>"El usuario {$correo_usu_up} fue actualizado correctamente",
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

        return mainModel::sweet_alert($alerta);
    }

    public function datos_administrador_controlador($tipo,$codigo){
           $codigo=mainModel::decryption($codigo);
           $tipo = mainModel::limpiar_cadena($tipo);
           return adminModelo::datos_administrador_modelo($tipo,$codigo);
    }
}


?>