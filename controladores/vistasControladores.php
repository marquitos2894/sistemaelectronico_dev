<?php 

require_once './modelos/vistasModelo.php';
class vistasControladores extends vistasModelo{

    public function obtener_plantilla_controlador(){
        return require_once './vistas/plantilla.php';
    }

    public function obtener_vista_controlador(){
        if(isset($_GET['views'])){
            $ruta = explode("/",$_GET['views']);
            
            $respuesta = vistasModelo::obtener_vistas_modelo($ruta[0]);
        }else{
            if(isset($_SESSION['nombre_sbp'])){
                $respuesta = vistasModelo::obtener_vistas_modelo("inicio");
            }else{
                $respuesta = vistasModelo::obtener_vistas_modelo("login");   
            } 
        }
        return $respuesta;
    }

    public function obtener_plantilla_report_controlador(){
        return require_once './vistas/plantillaReporte.php';
    }

    public function obtener_vista_report_controlador(){

        $ruta = explode("/",$_GET['views']);

        $respuesta = vistasModelo::obtener_reporte_modelo($ruta[0]);

        return $respuesta;

    }

    
}

