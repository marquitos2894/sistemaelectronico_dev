<?php 
   $peticionAjax = true;
   require_once '../Core/configGeneral.php';
   require_once '../controladores/almacenControlador.php';
   require_once '../controladores/equipoControlador.php'; 

   $almCont =  new almacenControlador();
   $equiCont = new equipoControlador();
   //echo $almCont->obtener_consulta_json_controlador(1);

   if(isset($_POST["id_alm"])){
      session_start(['name'=>'SBP']);
      echo $almCont->obtener_consulta_json_controlador("SELECT ac.id_ac,c.id_comp,c.descripcion,c.nparte1,
      c.nparte2,c.nparte3,c.unidad_med,ac.stock,ac.fk_idalm,ac.u_nombre,ac.u_seccion,e.Nombre_Equipo,e.Id_Equipo
      FROM componentes c
      INNER JOIN almacen_componente ac ON ac.fk_idcomp = c.id_comp 
      INNER JOIN equipos e  ON e.Id_Equipo = ac.fk_idequipo 
      WHERE ac.fk_idalm = {$_POST["id_alm"]}");

      if( isset($_POST["id_alm"]) && isset($_POST["nom_almacen"])){
         $almCont->sesion_almacen($_POST["id_alm"],$_POST["nom_almacen"]);
      }

   }

   if(isset($_POST["logout_alm"])){
      session_start(['name'=>'SBP']);
      $almCont->logout_almamcen();
   }

   if(isset($_POST["usuario"]) && $_POST["vale"]=="valesalida" ){
      echo $almCont->save_vsalida_controlador();
      echo "<script>localStorage.setItem('carritoS','[]');</script>";
   } 
   

   if(isset($_POST["usuario"]) && $_POST["vale"]=="valeingreso" ){
      echo $almCont->save_vingreso_controlador();
      echo "<script>localStorage.setItem('carritoIn','[]');</script>";
   } 

   if(isset($_POST["id_comp"]) && isset($_POST["d_id_equipo"]) ){
      echo $almCont->save_registro_almacen_controlador();
   }

   if(isset($_POST["id_ac"])){
      echo $almCont->obtener_consulta_json_controlador("SELECT ac.id_ac,c.id_comp,c.descripcion,c.nparte1,
      c.nparte2,c.nparte3,c.unidad_med,ac.stock,ac.fk_idalm,ac.u_nombre,ac.u_seccion,e.Id_Equipo,e.Nombre_Equipo,ac.Referencia,ac.control_stock
      FROM componentes c
      INNER JOIN almacen_componente ac ON ac.fk_idcomp = c.id_comp 
      INNER JOIN equipos e  ON e.Id_Equipo = ac.fk_idequipo 
      WHERE ac.est = 1 and ac.id_ac = {$_POST["id_ac"]}");


   }

   if(isset($_POST["id_comp_cs"]) && isset($_POST["id_alm_cs"]) ){
      echo $almCont->obtener_consulta_json_controlador("SELECT cs.id_cs,cs.fk_idcomp,cs.fk_idalm,cs.stock,cs.stock_min,cs.stock_max
      FROM control_stock cs
      INNER JOIN componentes c ON cs.fk_idcomp = c.id_comp
      WHERE c.id_comp = {$_POST["id_comp_cs"]} and cs.fk_idalm = {$_POST["id_alm_cs"]}");
   }

   if(isset($_POST["combo_eq"])){
      echo $equiCont->select_combo("SELECT e.Id_Equipo,e.Nombre_Equipo
      from equipos e WHERE e.Nombre_Equipo !='{$_POST["combo_eq"]}' and estado = 'si' 
      ",0,1);
  }
  
   

?>