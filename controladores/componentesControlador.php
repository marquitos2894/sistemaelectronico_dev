<?php 

if($peticionAjax){
    require_once '../modelos/componentesModelo.php';
}else{
    require_once './modelos/componentesModelo.php';
}

Class componentesControlador extends componentesModelo {

    public function paginador_componentes($paginador,$registros,$privilegio,$buscador,$vista){

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
     
    }

}




?>