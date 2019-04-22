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
            $datos=$conexion->query("SELECT SQL_CALC_FOUND_ROWS * FROM componentes WHERE descripcion Like '%{$buscador}%' or nparte1 like '%{$buscador}%' or nparte2 like '%{$buscador}%' or nparte3 like '%{$buscador}%' or codigo like '%{$buscador}%' and est=1 LIMIT {$inicio},{$registros} ");
            $datos = $datos->fetchAll();
            $total = $conexion->query("SELECT FOUND_ROWS()");
        }else{
        $datos=$conexion->query("SELECT SQL_CALC_FOUND_ROWS * FROM componentes WHERE est = 1 LIMIT {$inicio},{$registros}");
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
                <th scope="col">Salida</th>
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
                            <td><input type='number' id='salida'/></td>
                            <td> <a href='#' class='card-footer-item' id='addItem' data-producto='$row[0]'>+</a></td>";
                            $contador++;
                $tabla.="</tr>";
            }

        }else{
            $tabla.='<tr><td colspan="4"> No existen registros</td> </tr>';
        }

        $tabla.='</tbody></table></div>';
        $tabla.= mainModel::paginador($total,$paginador,$Npaginas,$vista);
        return $tabla;
     
    }


    function obtener_consulta_json_controlador(){
        $consulta = "select * from componentes";
        return mainModel::obtener_consulta_json($consulta);
    }

}


?>