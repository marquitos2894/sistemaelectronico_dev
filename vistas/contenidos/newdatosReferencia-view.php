<?php 



?>

<div class="container-fluid">

    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="<?php echo SERVERURL;?>datosReferencia/"><i class="fas fa-dolly-flatbed"></i> Referencia</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href=""><i class="fas fa-plus-circle"></i> Nuevo</a>
        </li>
    </ul><br>
    <form action="<?php echo SERVERURL;?>ajax/componentesAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data" >
    <div class="card border-primary mb-3">
            <div class="card-body text-primary">
                <h4 class="card-title">Nueva referencia</h4>
                <div class="progress" style="height:1px;">
                    <div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm-6 text-primary">
                        <label for="inputAddress">Referencia</label>
                        <input type="text" name="referencia_dr_nuevo" class="form-control " id="inputAddress" placeholder="Nombre del componente" maxlength="35" required>
                    </div>
                </div>
                <div class="progress" style="height:1px;">
                    <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <div class="form-row">
                    <div class="form-group col-sm-4">
                        <label for="inputEmail4">Descripcion</label>
                        <textarea  name="descripcion_dr_nuevo" value=""  class="form-control" id="exampleFormControlTextarea1" rows="3" maxlength="80"></textarea>   
                    </div>
                </div>
            </div>
        </div>
        <input type="hidden"  name="privilegio_sbp" value="<?php echo $_SESSION['privilegio_sbp']?>"/>    
        <button type="submit" class="btn btn-primary">Guardar</button>
        <div class="RespuestaAjax"></div>
    </form>

</div>