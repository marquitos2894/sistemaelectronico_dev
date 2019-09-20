<?php 
   $peticionAjax = true;
   require_once '../core/configGeneral.php';
   require_once '../controladores/categoriacompControlador.php';

   $catCont =  new categoriacompControlador();

   //echo $almCont->obtener_consulta_json_controlador(1);

   if(isset($_POST["categoriacat"])){
     echo $catCont->select_combo("SELECT * FROM categoriacomp WHERE id_categoria != '{$_POST["categoriacat"]}' ",0,1);
   }

   ?>