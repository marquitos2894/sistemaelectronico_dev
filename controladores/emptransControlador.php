<?php 

if($peticionAjax){
    require_once '../modelos/emptransModelo.php';
}else{
    require_once './modelos/emptransModelo.php';
}

class emptransControlador extends emptransModelo{

    public function agregar_emptrans_controlador(){
        $razonsocial = mainModel::limpiar_cadena($_POST["razonsocial"]);
        $ruc = mainModel::limpiar_cadena($_POST["ruc"]);

        $valruc=mainModel::ejecutar_consulta_simple("select * from emptransporte where ruc ={$ruc}");
        $valrz=mainModel::ejecutar_consulta_simple("select * from emptransporte where razonsocial ='{$razonsocial}'");
       
        if($valruc->rowCount()>=1){
            $alerta=[
                "alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"El ruc {$ruc}, ya esta registrado, por favor verifiquelo",
                "Tipo"=>"warning"
            ];           
        }
        
        elseif($valrz->rowCount()>=1){
            $alerta=[
                "alerta"=>"simple",
                "Titulo"=>"Ocurrio un error inesperado",
                "Texto"=>"La razon social <b>{$razonsocial}</b>, ya esta registrado, por favor verifiquelo",
                "Tipo"=>"warning"
            ];           
        }
        else{
            $dataET=["razonsocial"=>$razonsocial,"ruc"=>$ruc];
            $guardarET=emptransModelo::agregar_emptrans_modelo($dataET);
            if($guardarET->rowCount()>=1){
                $alerta=[
                    "alerta"=>"limpiar",
                    "Titulo"=>"Empresa de transporte registrado",
                    "Texto"=>"Se registro correctamente la empresa de transporte {$razonsocial}",
                    "Tipo"=>"success"
                ];
            }else{
                $alerta=[
                    "alerta"=>"simple",
                    "Titulo"=>"Ocurrio un error inesperado",
                    "Texto"=>"No hemos podido registrar la empresa de transporte {$razonsocial}",
                    "Tipo"=>"error"
                ];
            }
        }
    return mainModel::sweet_alert($alerta);
    }
}


?>