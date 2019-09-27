<?php 

class vistasModelo{

    protected function obtener_vistas_modelo($vistas){
        $lista_blanca=["emptrans","inicio","emptranslist","usuariolist","usuario","perfil","personal","personallist","componentes",
                        "RValeSalida","RValeIngreso","newcomponente","ingresoAlmacen","almacen","insideAlmacen","unidadmedlist",
                        "newunidadmed","reporteAlmacen","datosReferencia","newdatosReferencia","equipos","newequipos","miFlota"
                        ,"miFlotaBaja","componentesBaja","NoAccessVista"];
             
        if(isset($_SESSION['nombre_sbp'])){
            //echo $_SESSION['RvistasUsuario'];
            $Rvista_usuario =   explode("-",$_SESSION['RvistasUsuario']);      
            if(in_array($vistas,$lista_blanca)){
                
                if(is_file("./vistas/contenidos/{$vistas}-view.php")){
                    if(in_array($vistas,$Rvista_usuario)){
       
                        $contenido="./vistas/contenidos/NoAccessVista-view.php";
                    }else{
                        $contenido="./vistas/contenidos/{$vistas}-view.php";
                    }

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
        $lista_blanca=["PDFvalesalida","PDFvaleingreso","PDFlogalmacen"];
        if(in_array($reporte,$lista_blanca)){

            if(is_file("./vistas/reportes/{$reporte}-pdf.php")){
                $contenido="./vistas/reportes/{$reporte}-pdf.php";
            }
            
        return $contenido;
        }
    }

}



