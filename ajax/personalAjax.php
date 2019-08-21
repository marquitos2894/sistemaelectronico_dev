<?php 
   $peticionAjax = true;
   require_once '../Core/configGeneral.php';
   require_once '../controladores/personalControlador.php';

    $perCont = new personalControlador();


    if(isset($_POST["nom_per_in"])){
        echo $perCont->save_personal_controlador();
    }

    //VISTA PERSONAL LIST


    if(isset($_POST["id_per_edit"]) &&  isset($_POST["nom_per_edit"])){
        echo $perCont->update_personal_controlador();
    }

    if(isset($_POST["id_per_del"])){
        echo $perCont->delete_personal_controlador();
    }

 




    if(isset($_POST["id_per_json"])){
        $id_per = $_POST["id_per_json"];
        echo $perCont->obtener_consulta_json_controlador("select p.id_per,p.Nom_per,p.Ape_per,p.Dni_per,p.brevete,p.Telefono_per,p.Direccion_per,p.Region_per,p.Ciudad_per,p.Distrito_per,p.urlimagen
        ,p.id_cargo,p.idunidad,cp.cargo,p.Correoe_per
        from personal p 
        INNER JOIN cargopersonal cp
        ON cp.id_cargo = p.id_cargo WHERE p.id_per={$id_per}");
    }
    
    if(isset($_POST["idcargo_json"])){
        $id_cargo = $_POST["idcargo_json"];
        echo $perCont->select_combo("SELECT * FROM cargopersonal WHERE id_cargo != {$id_cargo} AND est=1",0,1);
    }
    



   ?>