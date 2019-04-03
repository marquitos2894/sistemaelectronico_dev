
<?php 
        require_once "./controladores/personalControlador.php";
        $perCont = new personalControlador();
        $pagina= explode("/",$_GET['views']);
?>
<div class="container-fluid" >

    <?php  echo $perCont->paginador_personal($pagina[1],8); ?>


</div>