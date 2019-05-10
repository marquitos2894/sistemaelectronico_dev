<?php 

class vistasModelo{

    protected function obtener_vistas_modelo($vistas){
        $lista_blanca=["emptrans","inicio","emptranslist","usuariolist","usuario","perfil","personal","personallist","componentes","RValeSalida","RValeIngreso"];
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
        echo $_SESSION['nombre_sbp'];
        return $contenido;
        }
    }

}



