<?php 

$url = explode("/",$_GET["views"]);
$paginador = $url[1];
$vista=$url[0];
?>

<input type="hidden" id="session_idunidad" value="<?php echo $_SESSION['unidad'] ?>" />
<input type="hidden" value="<?php echo $paginador ?>" id="paginador"/>
<input type="hidden" value="<?php echo $vista ?>" id="vista"/>
<input type="hidden" value="<?php echo $_SESSION['privilegio_sbp'] ?>" id="privilegio"/>
<input type="hidden" value="<?php echo $_SESSION['almacen'] ?>" id="id_alm"/>
<div class="container-fluid">

    <div class="jumbotron jumbotron-fluid">
        <div class="container">

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon1">Buscar</span>
                </div>
                <input type="search" class="form-control"  id="buscador_comp_text" placeholder="Buscar componente" aria-label="Username" aria-describedby="basic-addon1">                       
            </div>
            <div id='componentes'></div>
             

            <h1 class="display-4">Componentes</h1>
            <p class="lead">This is a modified jumbotron that occupies the entire horizontal space of its parent.</p>
            <div id="productos"></div>
        </div>
    </div>
</div>

<script src="../vistas/js/emitirOC.js" ></script>