<?php 
   $peticionAjax = true;
   require_once '../Core/configGeneral.php';
   require_once '../controladores/almacenControlador.php';
   require_once '../controladores/equipoControlador.php'; 

   $almCont =  new almacenControlador();
   $equiCont = new equipoControlador();
   //echo $almCont->obtener_consulta_json_controlador(1);
   

   if(isset($_POST["id_comp_almacen"]) && isset($_POST["fk_idalm_almacen"])){
      echo $almCont->update_comp_almacen_controlador();  
   }  




   if(isset($_POST["id_alm"])){
      session_start(['name'=>'SBP']);
      echo $almCont->obtener_consulta_json_controlador("SELECT ac.id_ac,c.id_comp,c.descripcion,c.nparte1,
      c.nparte2,c.nparte3,um.id_unidad_med,um.abreviado,ac.stock,ac.fk_idalm,ac.u_nombre,ac.u_seccion,
      eu.alias_equipounidad,e.Nombre_Equipo,e.Id_Equipo,ac.Referencia,c.nserie
      FROM componentes c
      INNER JOIN almacen_componente ac ON ac.fk_idcomp = c.id_comp 
      INNER JOIN equipos e  ON e.Id_Equipo = ac.fk_Id_Equipo
      INNER JOIN unidad_medida um ON um.id_unidad_med = c.fk_idunidad_med
      INNER JOIN equipo_unidad eu ON eu.fk_idequipo = e.Id_Equipo
      WHERE ac.fk_idalm = {$_POST["id_alm"]}");

      if( isset($_POST["id_alm"]) && isset($_POST["nom_almacen"])){
         $almCont->sesion_almacen($_POST["id_alm"],$_POST["nom_almacen"]);
      }

   }

   if(isset($_POST["logout_alm"])){
      session_start(['name'=>'SBP']);
      $almCont->logout_almacen();
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
      echo $almCont->obtener_consulta_json_controlador("SELECT ac.id_ac,c.id_comp,c.descripcion,c.nparte1,c.nparte2,c.nparte3,
      um.abreviado,ac.stock,ac.fk_idalm,ac.u_nombre,ac.u_seccion,e.Nombre_Equipo,e.Id_Equipo,
      eu.alias_equipounidad,ac.Referencia,ac.control_stock,c.nserie
        FROM componentes c
        INNER JOIN almacen_componente ac ON ac.fk_idcomp = c.id_comp 
        INNER JOIN equipos e  ON e.Id_Equipo = ac.fk_Id_Equipo
        INNER JOIN unidad_medida um ON um.id_unidad_med = c.fk_idunidad_med
        INNER JOIN equipo_unidad eu ON eu.fk_idequipo = e.Id_Equipo
      WHERE ac.est = 1 and ac.id_ac = {$_POST["id_ac"]}");

   }

   if(isset($_POST["id_comp_cs"]) && isset($_POST["id_alm_cs"]) ){
      echo $almCont->obtener_consulta_json_controlador("SELECT cs.id_cs,cs.fk_idcomp,cs.fk_idalm,cs.stock,cs.stock_min,cs.stock_max
      FROM control_stock cs
      INNER JOIN componentes c ON cs.fk_idcomp = c.id_comp
      WHERE c.id_comp = {$_POST["id_comp_cs"]} and cs.fk_idalm = {$_POST["id_alm_cs"]}");
   }

   //VISTA RVALESALIDA;RVALE INGRESO; INSIDE ALMACEN

   if(isset($_POST["buscarcompajax"]) && isset($_POST["almacenajax"]) ){
      echo $almCont->paginador_componentes_almacen($_POST["paginadorajax"],10,$_POST["privilegioajax"],$_POST["buscarcompajax"],$_POST["vistaajax"],$_POST["almacenajax"],$_POST["tipoajax"]);
   }
   

   // VISTA INSIDE ALMACEN
   if(isset($_POST["id_ac_del"])){
     echo $almCont->delete_componente_almacen_controlador();
   }

   if(isset($_POST["dataReferencia"])){
      $referencia = $_POST["dataReferencia"];
      echo $almCont->select_combo("SELECT * FROM datos_referencia WHERE dato_referencia != '{$referencia}' ",1,1);
    }

    if(isset($_POST["id_equipo_insideAlm"]) && isset($_POST["id_unidad_insideAlm"]) ){
      echo $equiCont->select_combo("SELECT e.Id_Equipo,eu.alias_equipounidad
      FROM equipos e
      INNER JOIN equipo_unidad eu ON eu.fk_idequipo = e.Id_Equipo
      WHERE (eu.fk_idunidad = 7 OR eu.fk_idunidad = {$_POST["id_unidad_insideAlm"]} ) 
      AND eu.est_baja = 1 AND eu.est = 1 AND eu.fk_idequipo !={$_POST["id_equipo_insideAlm"]}
      ",0,1);
   }
    

   //VISTA REPOTEALMACEN
   
   if(isset($_POST["id_vsalida_anular"])){
      echo $almCont->anular_vsalida_controlador();
    }

    if(isset($_POST["id_vingreso_anular"])){
      echo $almCont->anular_vingreso_controlador();
    }

 
   

?>