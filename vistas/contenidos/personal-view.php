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
        <form action="<?php echo SERVERURL;?>ajax/personalAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data"  >
          <div class="card-body">
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="inputEmail4">Nombres</label>
                      <input type="text" name="nom_per_in" value="" class="form-control" id="inputEmail4" placeholder="Nombres" required>
                    </div>
                    <div class="form-group col-md-6">
                      <label for="inputPassword4">Apellidos</label>
                      <input type="text" name="ape_per_in" value="" class="form-control" id="inputPassword4" placeholder="Apellidos" required>
                    </div>
                  </div>
                  <div class="form-row">
                      <div class="form-group col-md-4">
                        <label for="inputCity">DNI</label>
                        <input type="text" name="dni_per_in" placeholder="DNI:0, en caso no lo tenga al momento" class="form-control" id="inputCity" required>
                      </div>
                      <div class="form-group col-md-4">
                        <label for="inputCity">Brevete</label>
                        <input type="text" name="brevete_in" value="" class="form-control" id="inputCity">
                      </div>
                      <div class="form-group col-md-4">
                        <label for="inputZip">Telefono</label>
                        <input type="text" name="telefono_in" value=""  class="form-control" id="inputZip">
                      </div>
                  </div>
                  <div class="form-group">
                      <label for="inputAddress">Direccion</label>
                      <input type="text" name="direccion_in" value="" class="form-control" id="inputAddress" placeholder="Av. jr. ca.">
                  </div>
                  <div class="form-row">
                      <div class="form-group col-md-4">
                        <label for="inputCity">Region</label>
                        <input type="text" name="region_in" value="" class="form-control" id="inputCity">
                      </div>
                      <div class="form-group col-md-4">
                        <label for="inputCity">Ciudad</label>
                        <input type="text" name="ciudad_in" value="" class="form-control" id="inputCity">
                      </div>
                      <div class="form-group col-md-4">
                        <label for="inputZip">Distrito</label>
                        <input type="text" name="distrito_in" value=""  class="form-control" id="inputZip">
                      </div>
                  </div>
                  <div class="form-row">
                      <div class="form-group col-md-4">
                        <label for="inputCity">Cargo</label>
                        <div>
                          <select required data-placeholder="" id="cargo_in" name="cargo_in" class="chosen-select" tabindex="">
                            <option value="">Seleccione cargo</option>
                            <?php echo $perCont->chosen_cargo(0,1)?>
                          </select>
                        </div>
                      </div>

                      <input type="hidden" name="unidad_in" value="<?php echo $_SESSION['unidad'] ?>"/>
                      <div class="form-group col-md-4" style="display:none">
                        <label for="inputCity">Unidad</label>
                         
                          <div>
                            <!--select data-placeholder="Seleccione unidad..." name="unidad_in" class="chosen-select" tabindex="2">
                              <option value=""></option>
                              <?php //echo $perCont->chosen_unidad(0,1)?>
                            </select-->
                        </div>
                      </div>
                  </div>
                  <div class="form-row">
                    <div class="form-group col-md-6">
                      <label for="inputEmail4">Email</label>
                      <input type="email" name="correo_per_in" value="" class="form-control" id="inputEmail4" placeholder="@Email">
                    </div>
                  </div>
          </div>
          <input type="hidden"  name="privilegio_sbp" value="<?php echo $_SESSION['privilegio_sbp']?>"/>
          <div id='mesanje'></div>
          <button type="submit" id="btnsave" class="btn btn-success btn-lg btn-block">Guardar</button>
          <div class="RespuestaAjax"></div>
        </form>
</div>


<script src="../vistas/js/newpersonal.js"></script>