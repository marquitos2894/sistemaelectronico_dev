<?php 
   $peticionAjax = true;
   require_once '../Core/configGeneral.php';

   if(isset($_POST['id_usu'])){

      require_once '../controladores/adminControlador.php';
      $Admin =  new adminControlador();
      echo $Admin->eliminar_usuario_controlador();
      
   }
?>