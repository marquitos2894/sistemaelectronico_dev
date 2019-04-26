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
            $datos=$conexion->prepare("SELECT c.id_comp,c.codigo,c.descripcion,c.nparte1,c.nparte2,c.nparte3,c.unidad_med,ac.stock,ac.fk_idalm,ac.id,ac.u_nombre,ac.u_seccion
                                     FROM componentes c
                                     INNER JOIN almacen_componente ac
                                     ON ac.fk_idcomp = c.id_comp WHERE (c.descripcion Like '%{$buscador}%' or c.nparte1 like '%{$buscador}%' or c.nparte2 like '%{$buscador}%' or c.nparte3 like '%{$buscador}%' or c.codigo like '%{$buscador}%') and ac.est = 1 and ac.fk_idalm=1 LIMIT {$inicio},{$registros} ");
            $datos->execute();
            $datos = $datos->fetchAll();
            $total = $conexion->query("SELECT FOUND_ROWS()");
        }else{
            $datos=$conexion->prepare("SELECT c.id_comp,c.codigo,c.descripcion,c.nparte1,c.nparte2,c.nparte3,c.unidad_med,ac.stock,ac.fk_idalm,ac.id,ac.u_nombre,ac.u_seccion
                                    FROM componentes c
                                    INNER JOIN almacen_componente ac
                                    ON ac.fk_idcomp = c.id_comp WHERE ac.est = 1 and ac.fk_idalm=1  LIMIT {$inicio},{$registros}");

            $datos->execute();
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
                <th scope="col">Ubicacion</th>
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
                            <td>{$row['u_nombre']}-{$row['u_seccion']}</td>
                            <td>{$row['stock']}</td>
                            <td><input type='number'  id='salida$row[id]' /></td>
                            <td> <a href='#' class='card-footer-item' id='addItem' data-producto='$row[id]'>+</a></td>";
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

    function save_vsalida_controlador(){

        $fk_idusuario = mainModel::limpiar_cadena($_POST["usuario"]);
        $fk_idpersonal = mainModel::limpiar_cadena($_POST["personal"]);
        $turno = mainModel::limpiar_cadena($_POST["turno"]);
        $fk_idequipo=mainModel::limpiar_cadena($_POST["codequipo"]);
        $horometro=mainModel::limpiar_cadena($_POST["horometro"]);
        $comentario=mainModel::limpiar_cadena($_POST["comentario"]);
          
        $objDateTime = new DateTime('NOW');
        $fecha=$objDateTime->format('c');

        $nom_equipo=mainModel::ejecutar_consulta_simple("select e.nombre_equipo from equipos e where id_equipo = {$fk_idequipo} ")['nombre_equipo'];
        $datospersonal = mainModel::ejecutar_consulta_simple("select  concat(p.nom_per,',',p.Ape_per) as nombres,p.dni_per from personal p where id_per = {$fk_idpersonal} ");
        $nombre = $datospersonal['nombres'];
        $dni = $datospersonal['dni_per'];

        $alerta=[
            "alerta"=>"simple",
            "Titulo"=>"Datos guardados",
            "Texto"=>"Los siguientes datos han sido guardados",
            "Tipo"=>"success"
        ];

        
        return mainModel::sweet_alert($alerta);

    }


    function obtener_consulta_json_controlador(){
        $consulta = "SELECT ac.id,c.id_comp,c.codigo,c.descripcion,c.nparte1,c.nparte2,c.nparte3,c.unidad_med,ac.stock,ac.fk_idalm,ac.u_nombre,ac.u_seccion
                    FROM componentes c
                    INNER JOIN almacen_componente ac
                    ON ac.fk_idcomp = c.id_comp WHERE ac.est = 1 ";
        return mainModel::obtener_consulta_json($consulta);
    }

    function chosen_personal($val,$vis){
        $consulta = "select p.id_per, CONCAT(p.Nom_per,',',p.Ape_per,'-',p.Dni_per)
        from personal p";
        return mainModel::ejecutar_combo($consulta,$val,$vis);
    }

    function chosen_equipo($val,$vis){
        $consulta = "select e.Id_Equipo,e.Nombre_Equipo
        from equipos e";
        return mainModel::ejecutar_combo($consulta,$val,$vis);
    }

}


?>