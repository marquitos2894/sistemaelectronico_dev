<?php 
   $peticionAjax = true;
   require_once '../Core/configGeneral.php';
   require_once '../controladores/almacenControlador.php';
   $almCont =  new almacenControlador();

   if(isset($_POST["id_alm"])){
      $_POST["id_alm"];
      echo $almCont->obtener_consulta_json_controlador();
   }


?>