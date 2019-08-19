<?php

if($peticionAjax){
    require_once '../core/mainModel.php';
}else{
    require_once './core/mainModel.php';
}

class equipoModelo extends mainModel {


    protected function save_equipos_modelo($datos){
        $conex = mainModel::conectar();
        $sql = $conex->prepare("CALL i_equipos(:Modelo_Equipo,:Tipo_Equipo,:Aplicacion_Equipo,
        :Marca_Equipo,:NSerie_Equipo,:Capacidad_Equipo,:AnoFab_Equipo,:ModeloMotor_Equipo,:MarcaMotor_Equipo,
        :SerieMotor_Equipo,:id_categoria)");

        $sql->bindParam(":Modelo_Equipo",$datos["Modelo_Equipo"]);
        $sql->bindParam(":Tipo_Equipo",$datos["Tipo_Equipo"]);
        $sql->bindParam(":Aplicacion_Equipo",$datos["Aplicacion_Equipo"]);
        $sql->bindParam(":Marca_Equipo",$datos["Marca_Equipo"]);
        $sql->bindParam(":NSerie_Equipo",$datos["NSerie_Equipo"]);
        $sql->bindParam(":Capacidad_Equipo",$datos["Capacidad_Equipo"]);
        $sql->bindParam(":AnoFab_Equipo",$datos["AnoFab_Equipo"]);
        $sql->bindParam(":ModeloMotor_Equipo",$datos["ModeloMotor_Equipo"]);
        $sql->bindParam(":MarcaMotor_Equipo",$datos["MarcaMotor_Equipo"]);
        $sql->bindParam(":SerieMotor_Equipo",$datos["SerieMotor_Equipo"]);
        $sql->bindParam(":id_categoria",$datos["id_categoria"]);
        
        $sql->execute();
        return $sql;
    }

    protected function update_equipos_modelo($datos){
        $conex = mainModel::conectar();
        $sql = $conex->prepare("CALL u_equipos(:Id_Equipo,:Modelo_Equipo,:Tipo_Equipo,:Aplicacion_Equipo,
        :Marca_Equipo,:NSerie_Equipo,:Capacidad_Equipo,:AnoFab_Equipo,:ModeloMotor_Equipo,:MarcaMotor_Equipo,
        :SerieMotor_Equipo)");

        $sql->bindParam(":Id_Equipo",$datos["Id_Equipo"]);
        $sql->bindParam(":Modelo_Equipo",$datos["Modelo_Equipo"]);
        $sql->bindParam(":Tipo_Equipo",$datos["Tipo_Equipo"]);
        $sql->bindParam(":Aplicacion_Equipo",$datos["Aplicacion_Equipo"]);
        $sql->bindParam(":Marca_Equipo",$datos["Marca_Equipo"]);
        $sql->bindParam(":NSerie_Equipo",$datos["NSerie_Equipo"]);
        $sql->bindParam(":Capacidad_Equipo",$datos["Capacidad_Equipo"]);
        $sql->bindParam(":AnoFab_Equipo",$datos["AnoFab_Equipo"]);
        $sql->bindParam(":ModeloMotor_Equipo",$datos["ModeloMotor_Equipo"]);
        $sql->bindParam(":MarcaMotor_Equipo",$datos["MarcaMotor_Equipo"]);
        $sql->bindParam(":SerieMotor_Equipo",$datos["SerieMotor_Equipo"]);
        $sql->execute();
        return $sql;
    } 
    
    
    protected function delete_equipo_modelo($Id_Equipo){
        $conex = mainModel::conectar();
        $sql=$conex->prepare("CALL d_equipos(:Id_Equipo)");
        $sql->bindParam(":Id_Equipo",$Id_Equipo);
        $sql->execute();
        return  $sql;
    }

    protected function darbaja_equipo_modelo($Id_Equipo){
        $conex = mainModel::conectar();
        $sql=$conex->prepare("CALL dardebaja_equipos(:Id_Equipo)");
        $sql->bindParam(":Id_Equipo",$Id_Equipo);
        $sql->execute();
        return  $sql;
    }

    // MI FLOTA

    protected function save_flota_modelo($datos){
        $conex = mainModel::conectar();
        $sql=$conex->prepare("CALL i_equipo_unidad(:fk_idequipo,:fk_idunidad,:alias_equipounidad,:estado_equipounidad)");
        $sql->bindParam(":fk_idequipo",$datos["fk_idequipo"]);
        $sql->bindParam(":fk_idunidad",$datos["fk_idunidad"]);
        $sql->bindParam(":alias_equipounidad",$datos["alias_equipounidad"]);
        $sql->bindParam(":estado_equipounidad",$datos["estado_equipounidad"]);
        $sql->execute();
        return $sql;
    }

    protected function update_flota_modelo($datos){
        $conex = mainModel::conectar();
        $sql=$conex->prepare("CALL u_unidad_equipo(:id_equipounidad,:alias_equipounidad,:estado_equipounidad)");
        $sql->bindParam(":id_equipounidad",$datos["id_equipounidad"]);
        $sql->bindParam(":alias_equipounidad",$datos["alias_equipounidad"]);
        $sql->bindParam(":estado_equipounidad",$datos["estado_equipounidad"]);
        $sql->execute();
        return $sql;
    }

    protected function delete_flota_modelo($id_equipounidad){
        $conex = mainModel::conectar();
        $sql=$conex->prepare("CALL d_equipo_unidad(:id_equipounidad)");
        $sql->bindParam(":id_equipounidad",$id_equipounidad);
        $sql->execute();
        return  $sql;
    }

    protected function darbaja_flota_modelo($id_equipounidad){
        $conex = mainModel::conectar();
        $sql=$conex->prepare("CALL dardebaja_equipo_unidad(:id_equipounidad)");
        $sql->bindParam(":id_equipounidad",$id_equipounidad);
        $sql->execute();
        return  $sql;
    }

    protected function darAlta_flota_modelo($id_equipounidad){
        $conex = mainModel::conectar();
        $sql=$conex->prepare("CALL dardealta_equipo_unidad(:id_equipounidad)");
        $sql->bindParam(":id_equipounidad",$id_equipounidad);
        $sql->execute();
        return  $sql;
    }
    

}

