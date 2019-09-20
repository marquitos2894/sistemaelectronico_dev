<div class="container-fluid"> 

    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link" href="<?php echo SERVERURL;?>equipos/"><i class="fas fa-tractor"></i> Equipos</a>
        </li>
        <li class="nav-item">
            <a class="nav-link active" href="<?php echo SERVERURL;?>newequipos/"><i class="fas fa-plus-circle"></i> Nuevo</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#">Equipos dados de Baja</a>
        </li>
    </ul><br>
    <form action="<?php echo SERVERURL;?>ajax/equiposAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="inputEmail4">Modelo</label>
                <input type="text" name="Modelo_Equipo_save" value="" class="form-control" placeholder="Modelo de equipo" required>
            </div>
            <div class="form-group col-md-4">
                <label for="inputPassword4">Tipo</label>
                <input type="text" name="Tipo_Equipo_save" value="" class="form-control"  placeholder="Tipo" required>
            </div>
            <div class="form-group col-md-4">
                <label for="inputPassword4">Aplicacion</label>
                <input type="text" name="Aplicacion_Equipo_save" value="" class="form-control"  placeholder="Ejem: Frontonero,Sostenedor">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="inputEmail4">Marca</label>
                <input type="text" name="Marca_Equipo_save" value="" class="form-control" placeholder="Marca del Equipo">
            </div>
            <div class="form-group col-md-4">
                <label for="inputPassword4">N°Serie</label>
                <input type="text" name="NSerie_Equipo_save" value="" class="form-control" placeholder="N° Serie del Equipo">
            </div>
            <div class="form-group col-md-4">
                <label for="inputPassword4">Capacidad</label>
                <input type="text" name="Capacidad_Equipo_save" value="" class="form-control" placeholder="Ejem: 8 pies, 6 yds">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="inputPassword4">Año Fabricacion</label>
                <input type="text" name="AnoFab_Equipo_save" value="" class="form-control"  placeholder="Año Fabricacion">
            </div>
        </div>
        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><strong>Categoria</strong></div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="inputPassword4">Categoria</label>
                <select name="categoria_equipo_save" class="form-control" >
                    <option selected value="4">Equipo Pesado</option>
                </select>
            </div>
        </div>


        <div class="progress">
            <div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"><strong>Datos del motor</strong></div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-4">
                <label for="inputEmail4">Modelo de Motor</label>
                <input type="text" name="ModeloMotor_Equipo_save" value="" class="form-control"  placeholder="Modelo de motor">
            </div>
            <div class="form-group col-md-4">
                <label for="inputPassword4">Marca de motor</label>
                <input type="text" name="MarcaMotor_Equipo_save" value="" class="form-control" placeholder="Marca de motor">
            </div>
            <div class="form-group col-md-4">
                <label for="inputPassword4">N°Serie de motor</label>
                <input type="text" name="SerieMotor_Equipo_save" value="" class="form-control" placeholder="N° serie del motor">
            </div>
        </div>
        <input type="hidden"  name="privilegio_sbp" value="<?php echo $_SESSION['privilegio_sbp']?>"/>
        <button type="submit" class="btn btn-primary">Guardar</button>
        <div class="RespuestaAjax"></div>
    </form>         

</div>