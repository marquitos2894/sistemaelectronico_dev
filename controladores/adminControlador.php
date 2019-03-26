<?php 

if($peticionAjax){
    require_once '../modelos/adminModelo.php';
}else{
    require_once './modelos/adminModelo.php';
}

class adminControlador extends adminModelo
{


    public function paginador_usuarios($paginador,$registros,$privilegio,$codigo){


        $paginador=mainModel::limpiar_cadena($paginador);
        $registros=mainModel::limpiar_cadena($registros);
        $privilegio=mainModel::limpiar_cadena($privilegio);
        $codigo=mainModel::limpiar_cadena($codigo);
        $tabla='';

        $paginador=(isset($paginador) && $paginador>0)?(int)$paginador:1; 
        $inicio=($paginador>0)?(($paginador*$registros)-$registros):0;
        
        $conexion = mainModel::conectar();
        //select limit recibe dos parametros inicio y logitud
        // SQL_CALC_FOUND_ROWS - obtiene la consulta los datos de las columnos de forma temporal y con FOUND_ROWS() -> obtiene el numero de filas
        $datos=$conexion->query("select SQL_CALC_FOUND_ROWS * FROM usuario where id_usu !={$codigo} and id_usu !=3 order by Correo asc limit {$inicio},{$registros}");
        $datos = $datos->fetchAll();
        $total = $conexion->query("SELECT FOUND_ROWS()");
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
                            $tabla.= "<td><a class='far fa-edit' href=".SERVERURL."micuenta/".mainModel::encryption($row[0])."/"."></a></td>";
                        }
                        if($privilegio==0){
                            $tabla.="<td><a class='far fa-edit' href=".SERVERURL."micuenta/".mainModel::encryption($row[0])."/"."></a></td>
                                    <td><i class='far fa-trash-alt'></i></td>";
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

            $tabla.='</ul></nav>';
        }

        return $tabla;
    }

}


?>