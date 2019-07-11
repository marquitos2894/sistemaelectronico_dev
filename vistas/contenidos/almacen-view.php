<?php 

    require_once "./controladores/almacenControlador.php";
    $almCont = new almacenControlador();
    $pagina = explode("/",$_GET['views']);


    if($_SESSION["almacen"]!=0 ){
        echo $_SESSION["almacen"];
        echo "<script> window.location.href = '../componentes/'; </script>";
    }
?>


<div class="container-fluid">
    <?php echo $almCont->paginador_almacen($pagina[1],8,$pagina[0]) ?>
</div>



<script src="../vistas/js/almacen.js"></script>