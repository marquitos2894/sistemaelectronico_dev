<?php 

if($peticionAjax){
    require_once '../modelos/personalModelo.php';
}else{
    require_once './modelos/personalModelo.php';
}

class personalControlador extends personalModelo {


    public function paginador_personal($paginador,$registros){

        $paginador=mainModel::limpiar_cadena($paginador);
        $registros=mainModel::limpiar_cadena($registros);
        $contenido='';

        $paginador=(isset($paginador) && $paginador>0)?(int)$paginador:1; 
        $inicio=($paginador>0)?(($paginador*$registros)-$registros):0;
        
        $conexion = mainModel::conectar();
        $datos=$conexion->query("select p.id_per,p.Nom_per,p.Ape_per,p.Dni_per,p.idunidad,pr.nombre
        from prov_empl pe
        INNER JOIN personal p
        ON p.id_per = pe.fk_idper
        INNER JOIN proveedor pr 
        ON pr.id_prove = pe.fk_id_prove 
        WHERE pr.id_prove = 195 and p.Estado_per = 1 limit {$inicio},{$registros}");

        $datos = $datos->fetchAll();
        $json = json_encode($datos);
        $total = $conexion->query("SELECT FOUND_ROWS()");

        $total = (int)$total->fetchColumn();
        //devuel valor entero redondeado hacia arriba 4.2 = 5
        $Npaginas = ceil($total/$registros);
        $contenido.="<div class='card-group' style='width: 90%;' align='center' >";
        foreach(array_slice($datos,0,4) as $row){
            $contenido .="
                <div class='card'>
                    <img src='../vistas/img/avatar1.png' class='card-img-top'>
                    <div class='card-body'>
                    <h5 class='card-title'>{$row["Nom_per"]},{$row["Ape_per"]}</h5>
                    <p class='card-text'>This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    </div>
                    <div class='card-footer'>
                    <small class='text-muted'>Last updated 3 mins ago</small>
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
                    <h5 class='card-title'>{$row[1]},{$row["Ape_per"]}</h5>
                    <p class='card-text'>This is a wider card with supporting text below as a natural lead-in to additional content. This content is a little bit longer.</p>
                    </div>
                    <div class='card-footer'>
                    <small class='text-muted'>Last updated 3 mins ago</small>
                    </div>
                </div>";
        }
        $contenido.="</div>";

        return $contenido;
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

        if(personalModelo::save_personal_modelo($datosIN)->rowCount()>=1){
            $alerta=[
                "alerta"=>"simple",
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

        return mainModel::sweet_alert($alerta);

    }
    
    public function chosen_cargo($val,$vis){

        $consulta = "select * from cargopersonal";

        return mainModel::ejecutar_combo($consulta,$val,$vis);
    }

    public function chosen_unidad($val,$vis){

        $consulta = "select * from unidad";

        return mainModel::ejecutar_combo($consulta,$val,$vis);
    }


}
?>