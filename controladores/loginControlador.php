<?php 

if($peticionAjax){
    require_once '../modelos/loginModelo.php';
}else{
    require_once './modelos/loginModelo.php';
}

class loginControlador extends loginModelo{

    public function iniciar_sesion_controlador(){

        $correo=mainModel::limpiar_cadena($_POST["correo"]);
        $clave=mainModel::limpiar_cadena($_POST["clave"]);
        
        $datosLogin = [
            "correo"=>$correo,
            "clave"=>$clave
        ];

        $datosUsuario=loginModelo::iniciar_sesion_modelo($datosLogin);
        
        if($datosUsuario->rowCount()==1){
            $row = $datosUsuario->fetch();
            $_SESSION['id_sbp']=$row['id_usu'];
            $_SESSION['fk_idper_sbp']=$row['fk_idper'];
            $_SESSION['usuario_sbp']=$row['Correo'];
            $_SESSION['nombre_sbp']=$row['Nombre'];
            $_SESSION['apellido_sbp']=$row['Apellido'];
            $_SESSION['privilegio_sbp']=$row['privilegio'];
            $_SESSION['tipo_sbp']=$row['tipo'];
            $_SESSION['image_sbp']=$row['imagen'];
            $_SESSION['unidad']=$row['idunidad'];
            $_SESSION['almacen']=0;
            $_SESSION['token_sbp']=md5(uniqid(mt_rand(),true));
            $url = SERVERURL.'inicio';   
            /*if($row['tipo']=="super" ){
                $url = SERVERURL.'inicio';
            }else {
                $url = SERVERURL.'emptrans';
            }*/
            return $urllocation = "<script>window.location='{$url}'</script>";
        }else{
            $alerta=[
                "alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"El correo o contraseña son invalidos, por favor intente nuevamente",
                "Tipo"=>"error"
            ];
        }
        return mainModel::sweet_alert($alerta);
    }


    public function cerrar_sesion_controlador(){
        session_start(['name'=>'SBP']);
        $token=mainModel::decryption($_GET['Token']);
        $datos=[
            "Usuario"=>$_SESSION['usuario_sbp'],
            "Token_S"=>$_SESSION['token_sbp'],
            "Token"=>$token
        ];
        return loginModelo::cerrar_sesion_modelo($datos);
    }

    public function forzar_cierre_sesion_controlador(){
        session_destroy();
        return header("Location:".SERVERURL." ");
    }
}

?>