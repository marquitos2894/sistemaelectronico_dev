<?php 
   $peticionAjax = true;
   require_once '../Core/configGeneral.php';
   require_once '../controladores/personalControlador.php';

    $obj_personal = new personalControlador();


    if(isset($_POST["nom_per_in"])){
        
        echo $obj_personal -> save_personal_controlador();

    }


   ?>