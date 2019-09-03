<?php 

require_once './controladores/componentesControlador.php';
$compCont = new componentesControlador();

?>

<div class="container-fluid">
    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="<?php echo SERVERURL;?>componentes/"><i class="fas fa-dolly-flatbed"></i> Componentes</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="<?php echo SERVERURL;?>newcomponente/"><i class="fas fa-plus-circle"></i> Nuevo</a>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="<?php echo SERVERURL;?>componentesBaja/">Componentes dados de baja</a>
        </li>
    </ul><br>
    <form action="<?php echo SERVERURL;?>ajax/componentesAjax.php" method="POST" data-form="save" class="FormularioAjax" id="FormularioAjax" autocomplete="off" enctype="multipart/form-data" >
    <div class="card border-primary mb-3">
            <div class="card-body text-primary">
                <h4 class="card-title">Datos del componente</h4>
                <div class="progress" style="height:1px;">
                    <div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm-6 text-primary">
                        <label for="inputAddress">Descripcion</label>
                        <input type="text" name="descripcion" class="form-control " id="inputAddress" placeholder="Nombre del componente">
                    </div>
                </div>
                <div class="progress" style="height:1px;">
                    <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
                <div class="form-row">
                    <div class="form-group col-sm-4">
                    <label for="inputEmail4">Nparte</label>
                    <input type="text" name="nparte1" class="form-control" id="inputEmail4" placeholder="Nparte">
                    </div>
                    <div class="form-group col-sm-4">
                    <label for="inputPassword4">Nparte 2</label>
                    <input type="text" name="nparte2" class="form-control" id="inputPassword4" placeholder="Nparte 2">
                    </div>
                    <div class="form-group col-sm-4">
                    <label for="inputPassword4">Nparte 3</label>
                    <input type="text" name="nparte3" class="form-control" id="inputPassword4" placeholder="Nparte 3">
                    </div>
                </div>
                <div class="progress" style="height:1px;">
                    <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                </div>

                <div class="form-row">
                    <div class="form-group col-sm-4">
                        <label for="inputEmail4">Marca</label>
                        <input type="text" name="marca" class="form-control" id="inputEmail4" placeholder="Marca">
                    </div>
                    <div class="form-group col-sm-4">
                        <label for="inputEmail4">Unidad de medida</label>
                        <select name="unidad_med_new" class="form-control" placeholder="Seleccione unidad">
                            <option>Seleccione unidad de medida</option>
                            <?php echo $compCont->select_combo("SELECT * FROM unidad_medida WHERE est = 1",0,1); ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>  
        <input type="hidden"  name="privilegio_comp" value="<?php echo $_SESSION['privilegio_sbp']?>"/>   
        <button type="submit" class="btn btn-primary">Guardar</button>
        <div class="RespuestaAjax"></div>
    </form>

</div>