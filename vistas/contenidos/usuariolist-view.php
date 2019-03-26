<?php 
    require_once "./controladores/adminControlador.php";
    $insAdmin = new adminControlador();
    $pagina= explode("/",$_GET['views']);
    var_dump($pagina);
    
?>
<div class="container-fluid" >

    <ul class="list-group list-group-horizontal">
        <li class="list-group-item"><a href="<?php echo SERVERURL;?>usuariolist/">Lista de Usuarios</a></li>
        <li class="list-group-item"><a href="<?php echo SERVERURL;?>usuario/">+ Nuevo Usuario</a></li>
    </ul>
    <div class="card o-hidden border-0 shadow-lg my-5">
        <div class="text-center">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-10 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Lista de usuarios</div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
            <!-- Nested Row within Card Body -->
            <div class="row">
                <div class="col-lg-10">
                    <div class="p-5">
                        <div class="text-center">
                                 <!-- Earnings (Monthly) Card Example -->

                        </div>
                        <?php 
                        echo $pagina = $insAdmin->paginador_usuarios($pagina[1],6, $_SESSION['privilegio_sbp'],$_SESSION['id_sbp']);?>
                        <nav aria-label="Page navigation example">
                            <ul class="pagination">
                                <li class="page-item"><a class="page-link" href="#">Previous</a></li>
                                <li class="page-item"><a class="page-link" href="#">1</a></li>
                                <li class="page-item"><a class="page-link" href="#">2</a></li>
                                <li class="page-item"><a class="page-link" href="#">3</a></li>
                                <li class="page-item"><a class="page-link" href="#">Next</a></li>
                            </ul>
                        </nav>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>