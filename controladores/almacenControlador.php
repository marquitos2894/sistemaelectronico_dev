<?php

if($peticionAjax){
    require_once '../modelos/almacenModelo.php';
}else{
    require_once './modelos/almacenModelo.php';
}

Class almacenControlador extends almacenModelo {


    
    public function paginador_componentes($paginador,$registros,$privilegio,$buscador,$vista){

        $paginador=mainModel::limpiar_cadena($paginador);
        $registros=mainModel::limpiar_cadena($registros);
        $privilegio=mainModel::limpiar_cadena($privilegio);
        $tabla='';

        $paginador=(isset($paginador) && $paginador>0)?(int)$paginador:1; 
        $inicio=($paginador>0)?(($paginador*$registros)-$registros):0;

        $conexion = mainModel::conectar();
        if($buscador!=""){
            $datos=$conexion->query("SELECT c.id_comp,c.codigo,c.descripcion,c.nparte1,c.nparte2,c.nparte3,c.unidad_med,ac.stock,ac.fk_idalm
                                     FROM componentes c
                                     INNER JOIN almacen_componente ac
                                     ON ac.fk_idcomp = c.id_comp WHERE c.descripcion Like '%{$buscador}%' or c.nparte1 like '%{$buscador}%' or c.nparte2 like '%{$buscador}%' or c.nparte3 like '%{$buscador}%' or c.codigo like '%{$buscador}%' and ac.est=1 LIMIT {$inicio},{$registros} ");
            $datos = $datos->fetchAll();
            $total = $conexion->query("SELECT FOUND_ROWS()");
        }else{
        $datos=$conexion->query("SELECT c.id_comp,c.codigo,c.descripcion,c.nparte1,c.nparte2,c.nparte3,c.unidad_med,ac.stock,ac.fk_idalm
                                 FROM componentes c
                                 INNER JOIN almacen_componente ac
                                 ON ac.fk_idcomp = c.id_comp WHERE ac.est = 1 LIMIT {$inicio},{$registros}");

            $datos = $datos->fetchAll();
            $total = $conexion->query("SELECT FOUND_ROWS()");
        }

        $total = (int)$total->fetchColumn();
        //devuel valor entero redondeado hacia arriba 4.2 = 5
        $Npaginas = ceil($total/$registros);

        $tabla.='<div class="table-responsive"><table class="table table-bordered">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Descripcion</th>
                <th scope="col">Codigo Int.</th>
                <th scope="col">NParte</th>
                <th scope="col">Stock</th>
                <th scope="col">Solicitado</th>
                <th scope="col">Agregar</th>';
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
                            <td>{$row['descripcion']}</td>
                            <td>{$row['codigo']}</td>
                            <td>{$row['nparte1']}</td>
                            <td>{$row['stock']}</td>
                            <td><input type='number'  id='salida$row[0]' /></td>
                            <td> <a href='#' class='card-footer-item' id='addItem' data-producto='$row[0]'>+</a></td>";
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


    function obtener_consulta_json_controlador(){
        $consulta = "SELECT c.id_comp,c.codigo,c.descripcion,c.nparte1,c.nparte2,c.nparte3,c.unidad_med,ac.stock,ac.fk_idalm
                    FROM componentes c
                    INNER JOIN almacen_componente ac
                    ON ac.fk_idcomp = c.id_comp WHERE ac.est = 1";
        return mainModel::obtener_consulta_json($consulta);
    }

}


?>