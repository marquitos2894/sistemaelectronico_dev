
<?php 
        require_once "./controladores/personalControlador.php";
        $perCont = new personalControlador();
        $pagina= explode("/",$_GET['views']);
?>
<div class="container-fluid" >
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link active"  href="<?php echo SERVERURL;?>personallist/">Personal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo SERVERURL;?>personal/">+Nuevo Personal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </li>
            </ul>
        </div>
        <br>

     <?php  echo $perCont->paginador_personal($pagina[1],8,$pagina[0]); ?> 


</div>