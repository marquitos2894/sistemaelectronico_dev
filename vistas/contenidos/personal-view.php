<?php 
      require_once "./controladores/personalControlador.php";
      $perCont = new personalControlador();
?>

<div class="container-fluid" >
        <div class="card-header">
            <ul class="nav nav-tabs card-header-tabs">
                <li class="nav-item">
                    <a class="nav-link"  href="<?php echo SERVERURL;?>personallist/">Personal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link  active" href="<?php echo SERVERURL;?>personal/">+Nuevo Personal</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="inputEmail4">Nombres</label>
                    <input type="text" name="nom_per_up" value="" class="form-control" id="inputEmail4" placeholder="Nombres">
                  </div>
                  <div class="form-group col-md-6">
                    <label for="inputPassword4">Apellidos</label>
                    <input type="text" name="ape_per_up" value="" class="form-control" id="inputPassword4" placeholder="Apellidos" >
                  </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                      <label for="inputCity">DNI</label>
                      <input type="text" name="dni_per_up" value="" class="form-control" id="inputCity">
                    </div>
                    <div class="form-group col-md-4">
                      <label for="inputCity">Brevete</label>
                      <input type="text" name="brevete_up" value="" class="form-control" id="inputCity">
                    </div>
                    <div class="form-group col-md-4">
                      <label for="inputZip">Telefono</label>
                      <input type="text" name="telefono_up" value=""  class="form-control" id="inputZip">
                    </div>
                </div>
                <div class="form-group">
                    <label for="inputAddress">Direccion</label>
                    <input type="text" name="direccion_up" value="" class="form-control" id="inputAddress" placeholder="1234 Main St">
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                      <label for="inputCity">Region</label>
                      <input type="text" name="region_up" value="" class="form-control" id="inputCity">
                    </div>
                    <div class="form-group col-md-4">
                      <label for="inputCity">Ciudad</label>
                      <input type="text" name="ciudad_up" value="" class="form-control" id="inputCity">
                    </div>
                    <div class="form-group col-md-4">
                      <label for="inputZip">Distrito</label>
                      <input type="text" name="distrito_up" value=""  class="form-control" id="inputZip">
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-4">
                      <label for="inputCity">Cargo</label>
                      <div>
                        <select data-placeholder="Seleccione cargo..." class="chosen-select" tabindex="">
                          <option value=""></option>
                          <?php echo $perCont->chosen_cargo(0,1)?>
                        </select>
                     </div>
                    </div>
                    <div class="form-group col-md-4">
                      <label for="inputCity">Unidad</label>
                      <div>
                        <select data-placeholder="Seleccione unidad..." class="chosen-select" tabindex="2">
                          <option value=""></option>
                          <?php echo $perCont->chosen_unidad(0,1)?>
                        </select>
                     </div>
                    </div>
                </div>
                <div class="form-row">
                  <div class="form-group col-md-6">
                    <label for="inputEmail4">Email</label>
                    <input type="email" name="correo_per_up" value="" class="form-control" id="inputEmail4" placeholder="Email">
                  </div>
                </div>
        </div>
</div>