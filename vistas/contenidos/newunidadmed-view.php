<?php 

$url = explode("/",$_GET["views"]);
$paginador = $url[1];
$vista=$url[0];

?>

<div class="container-fluid">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="<?php echo SERVERURL;?>unidadmedlist/"><i class="fas fa-dolly-flatbed"></i>Unidades medida</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="<?php echo SERVERURL;?>newunidadmed/"><i class="fas fa-plus-circle"></i> Nuevo</a>
        </li>
    </ul><br>

    <form action="<?php echo SERVERURL;?>ajax/unidadmedidaAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" >
    <div class="card border-primary mb-3">
            <input type="hidden" name="<?php echo $vista ?>" value="<? echo $vista ?>"/>
            <div class="card-body text-primary">
                <h4 class="card-title">Registrar nueva unidad de medida</h4>
                <div class="progress" style="height:1px;">
                    <div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm-6 text-primary">
                        <label for="inputAddress">Unidad de medida</label>
                        <input type="text" name="descripcion_um" class="form-control " id="inputAddress" placeholder="Unidad de medida :">
                    </div>
                </div>
                <div class="progress" style="height:1px;">
                    <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm-6 text-primary">
                        <label for="inputAddress">Abreviado</label>
                        <input type="text" name="abreviado_um" class="form-control " id="inputAddress" placeholder="Abeviado, ejemplo : galones = gln">
                    </div>
                </div>
            </div>
        </div>
        
        <button type="submit" class="btn btn-primary">Guardar</button>
        <div class="RespuestaAjax"></div>
    </form>

</div>