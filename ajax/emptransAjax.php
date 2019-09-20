<?php 
    $peticionAjax=true;
    require_once '../core/configGeneral.php';
    if(isset($_POST['razonsocial'])){
        require_once '../controladores/emptransControlador.php';
        $guardarET = new emptransControlador();
        echo $guardarET->agregar_emptrans_controlador();

    }else{
        //session_start();
        session_destroy();
        echo '<script>window.location.href="'.SERVERURL.'login"</script>';
    }


?>