
<!DOCTYPE html>
<html lang="es">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SB Admin 2 - Dashboard</title>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
  <script src="<?php echo SERVERURL?>vistas/vendor/jquery/jquery.min.js"></script>


  <!-- Custom fonts for this template-->
  <link href="<?php echo SERVERURL?>vistas/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="<?php echo SERVERURL?>vistas/css/sb-admin-2.min.css" rel="stylesheet">

  <?php  include "vistas/modulos/Estilos.php"; ?>

  <?php  include "vistas/modulos/logoutscript.php"; ?>
</head>

<body id="page-top">

  <?php   
      
          $peticionAjax=false;
          require_once './controladores/vistasControladores.php'; 
          $vt= new vistasControladores();
          $vistasR=$vt->obtener_vista_controlador();

          if($vistasR == "login" || $vistasR =="404" || $vistasR=="index"){
            if($vistasR == "login"){
              require_once './vistas/contenidos/Login-view.php'; 
            }else if($vistasR == 'index'){
              require_once './vistas/contenidos/Login-view.php'; 
            }else{
              require_once './vistas/contenidos/404-view.php'; 
            }
            
          }
    
          else{

            //session_start(['name'=>'SBP']);
           
            require_once "./controladores/loginControlador.php";
            $lc = new loginControlador();
            if(!isset($_SESSION['token_sbp']) || !isset($_SESSION['usuario_sbp']) ){
                $lc->forzar_cierre_sesion_controlador();
            }
    ?>
 
    

    <?php  include "vistas/modulos/Sidebar1.php";?>

    <?php  require_once $vistasR;     ?>

    <?php  include "vistas/modulos/Sidebar2.php";?>
    
      
          <?php   }?>


  <!-- Bootstrap core JavaScript-->

 <?php  include "vistas/modulos/Script.php"; ?>

</body>

</html>
