<?php 
   $peticionAjax = true;
   require_once '../core/configGeneral.php';
   require_once '../controladores/adminControlador.php';
   $Admin =  new adminControlador();
  

   if(isset($_POST["id_usu"]) || isset($_POST["codigo_up"]))  {


      if(isset($_POST['id_usu'])){
         echo $Admin->eliminar_usuario_controlador();
      }

      if(isset($_POST["codigo_up"]) || isset($_POST["dni_per_up"]) ){
 
        echo $Admin->Update_administrado_controlador();

      }

   }

?>