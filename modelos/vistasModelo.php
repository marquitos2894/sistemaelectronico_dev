<?php 

class vistasModelo{

    protected function obtener_vistas_modelo($vistas){
        $lista_blanca=["emptrans","inicio","emptranslist","usuariolist","usuario","perfil","personal","personallist","componentes",
                        "RValeSalida","RValeIngreso","newcomponente","ingresoAlmacen","almacen","insideAlmacen","unidadmedlist",
                        "newunidadmed","reporteAlmacen","datosReferencia","newdatosReferencia","equipos","newequipos","miFlota"
                        ,"miFlotaBaja"];
      if(isset($_SESSION['nombre_sbp'])){
        if(in_array($vistas,$lista_blanca)){
            if(is_file("./vistas/contenidos/{$vistas}-view.php")){
                $contenido="./vistas/contenidos/{$vistas}-view.php";
            }else{
                $contenido = "login";
            }
        }elseif($vistas=="login"){
            $contenido="login";
        }elseif($vistas=="index"){
            $contenido="login";
        }else{  
            $contenido="404";
        }
        //echo $_SESSION['nombre_sbp'];
        return $contenido;
        }
        $contenido = "login";
        return $contenido;
    }

    protected function obtener_reporte_modelo($reporte){
        $lista_blanca=["PDFvalesalida","PDFvaleingreso"];
        if(in_array($reporte,$lista_blanca)){

            if(is_file("./vistas/reportes/{$reporte}-pdf.php")){
                $contenido="./vistas/reportes/{$reporte}-pdf.php";
            }
            
        return $contenido;
        }
    }

}



