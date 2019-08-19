<?php 

require_once './modelos/reporteModelo.php';
class vistasControladores extends reportesModelo{
    
    public function reporte_valesalida_simple_controlador($idvs,$idalm){
        $conexion = mainModel::conectar();

        $resp = $conexion->prepare("SELECT * FROM vale_salida WHERE id_vsalida = {$idvs} AND fk_idalm = {$idalm}");
        $resp->execute();
        $resp=$resp->fetchAll();

        return $resp;

    }

}