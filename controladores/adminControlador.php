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
        if(isset($buscador)){

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
            // pdo:fetchColumn() obtiene la fila 0 de la primera columna y fetchColumn(1) obtiene la fila 1 de la primera columna 

        }
     
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
                            $tabla.= "<td><a class='far fa-edit' href=".SERVERURL."micuenta/".mainModel::encryption($row[0])."/"."></a></td>";
                        }
                        if($privilegio==0){
                            $tabla.="<td><a class='far fa-edit' href=".SERVERURL."micuenta/".mainModel::encryption($row[0])."/"."></a></td>
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
        //$Delusuario->rowCount();
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

    public function datos_administrador_controlador($tipo,$codigo){
           $codigo=mainModel::decryption($codigo);
           $tipo = mainModel::limpiar_cadena($tipo);
           
           return adminModelo::datos_administrador_modelo($tipo,$codigo);

    }

}


?>