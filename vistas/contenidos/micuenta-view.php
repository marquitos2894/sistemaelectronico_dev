
<?php 
require_once "./controladores/adminControlador.php";
$ClassAdmin = new adminControlador();
$codigo = explode("/",$_GET["views"]);
$datos=$ClassAdmin -> datos_administrador_controlador("Unico",$codigo[1]);
 
if($_SESSION['tipo_sbp']=="super"){
    $boolean = "";
    $inputType="";
  }else{
    $boolean="disabled";
    $inputType="";
  }

if($datos->rowCount()==1):
  $campos = $datos->fetch();

?>
<div class="container-fluid" >
  <form>
    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Datos personales</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Cuenta</a>
      </li>

    </ul>
  <!-- Inicia Formulario-->
  
    <div class="tab-content" id="pills-tabContent">

        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
          <div class="card">
            <div class="card-header text-white bg-primary mb-3">
              Datos personales
            </div>
            <div class="card-body">
              
                    <input type="hidden" name="codigo" value="<?php echo $codigo[1]?>">
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="inputEmail4">Email</label>
                          <input type="email" value="<?php echo $campos["Correo"] ?>" class="form-control" id="inputEmail4" placeholder="Email">
                        </div>
                      </div>
                      <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="inputEmail4">Nombres</label>
                          <input type="text" value="<?php echo $campos["Nom_per"] ?>" class="form-control" id="inputEmail4" placeholder="Email">
                        </div>
                        <div class="form-group col-md-6">
                          <label for="inputPassword4">Apellidos</label>
                          <input type="text" value="<?php echo $campos["Ape_per"] ?>" class="form-control" id="inputPassword4" placeholder="Password">
                        </div>
                      </div>
                      <div class="form-row">
                          <div class="form-group col-md-4">
                            <label for="inputCity">DNI</label>
                            <input type="text" value="<?php echo $campos["Dni_per"] ?>" class="form-control" id="inputCity">
                          </div>
                          <div class="form-group col-md-4">
                            <label for="inputCity">Brevete</label>
                            <input type="text" value="<?php echo $campos["brevete"] ?>" class="form-control" id="inputCity">
                          </div>
                          <div class="form-group col-md-4">
                            <label for="inputZip">Telefono</label>
                            <input type="text" value="<?php echo $campos["Telefono_per"] ?>"  class="form-control" id="inputZip">
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="inputAddress">Direccion</label>
                          <input type="text"  value="<?php echo $campos["Direccion_per"] ?>" class="form-control" id="inputAddress" placeholder="1234 Main St">
                      </div>
                      <div class="form-row">
                          <div class="form-group col-md-4">
                            <label for="inputCity">Region</label>
                            <input type="text" value="<?php echo $campos["Region_per"] ?>" class="form-control" id="inputCity">
                          </div>
                          <div class="form-group col-md-4">
                            <label for="inputCity">Ciudad</label>
                            <input type="text" value="<?php echo $campos["Ciudad_per"] ?>" class="form-control" id="inputCity">
                          </div>
                          <div class="form-group col-md-4">
                            <label for="inputZip">Distrito</label>
                            <input type="text" value="<?php echo $campos["Distrito_per"] ?>"  class="form-control" id="inputZip">
                          </div>
                      </div>
            </div>
          </div>
        </div>

        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
          <div class="card">
            <div class="card-header text-white bg-primary mb-3">
              Cuenta
            </div>
            <div class="card-body">
                <div class="form-row">
                    <div class="form-group col-md-6">
                          <label for="inputEmail4">Email</label>
                          <input type="email" value="<?php echo $campos["Correo"] ?>" class="form-control" id="inputEmail4" placeholder="Email">
                    </div>
                </div>
                        <!--div class="form-check">
                          <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="1" checked>
                          <label class="form-check-label" for="exampleRadios1">
                          <h2><span class="badge badge-danger">1</span><span class="badge badge-success">CREAR</span><span class="badge badge-warning">ACTUALIZAR</span><span class="badge badge-primary">VER</span></h2>
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="2" checked>
                          <label class="form-check-label" for="exampleRadios1">
                          <h2><span class="badge badge-danger">2</span><span class="badge badge-success">CREAR</span><span class="badge badge-primary">VER</span></h2>
                          </label>
                        </div>
                        <div class="form-check">
                          <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="3" checked>
                          <label class="form-check-label" for="exampleRadios1">
                          <h2><span class="badge badge-danger">3</span><span class="badge badge-primary">VER</span></h2>
                          </label>
                        </div-->
                <div class="form-group col-md-6">
                        <label for="inputEmail4">Tipo usuario</label>
                          <div class="form-group">
                            <select class="custom-select" <?php echo $boolean ?> >
                              <option selected value="<?php echo $campos["tipo"] ?>"><?php echo $campos["tipo"] ?></option>
                              <option value="admin">admin</option>
                              <option value="estandar">Estandar</option>
                              <option value="Visita">Visita</option>
                            </select>
                          </div>
                      </div>
                <div class="form-group">
                        <label for="inputEmail4">Activo/Desactivado</label>
                        <div class="form-group">
                            <select class="custom-select" <?php echo $boolean ?> >
                              <option selected value="<?php echo $campos["estado"] ?>"><?php echo $estado =  ($campos["estado"]==1)?'Habilitado' : 'Deshabilitado'; ?></option>
                              <option value="1">Habilitado</option>
                              <option value="2">Deshabilitado</option>
                    
                            </select>
                      </div>
                <div class="form-row">
                        <div class="form-group col-md-6">
                          <label for="inputEmail4">Password</label>
                          <input type="password" value="" class="form-control" id="inputEmail" placeholder="Email">
                        </div>
                        <div class="form-group col-md-6">
                          <label for="inputPassword4">Repite Password</label>
                          <input type="password" value="" class="form-control" id="inputPassword4" placeholder="Password">
                        </div>
                      </div>
                <input type="hidden" name="password_incial" value="<?php echo mainModel::encryption($campos["Clave"]) ?>" id="">
              </div>
          </div card>
        </div 0>

  
    </div 1>
    <button type="submit" class="btn btn-success btn-lg btn-block">Guardar</button>
  </form>
  <!-- Fin de Formulario-->
</div>

<?php
else:
  echo '<h4>Lo sentimos no podemos mostrar la informacion solicitada</h4>';
endif; ?>