<?php 
   $peticionAjax = true;
   require_once '../Core/configGeneral.php';
   require_once '../controladores/almacenControlador.php';

   $almCont =  new almacenControlador();

   if(isset($_POST["id_alm"])){
      echo $almCont->obtener_consulta_json_controlador($_POST["id_alm"]);
   }


   if(isset($_POST["usuario"])){
     
      echo $almCont->save_vsalida_controlador();
      echo "<script>localStorage.setItem('carrito','[]');</script>";
   }  

?>