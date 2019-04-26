
<?php 
      require_once "./controladores/almacenControlador.php";
      $almCont = new almacenControlador(); 
      
      $pagina = explode("/",$_GET['views']);
      $buscador = "";
      $text = "";   
      if(isset($_POST['buscador']) && $_POST['buscador'] != "" ){
          $buscador=$_POST['buscador'];
          $text = '<h3><small class="text-muted">su busqueda fue :</small>"'.$buscador.'"</h3>';
      }else{
        $text="";
      }


?>

<div class="container-fluid">
<div class="RespuestaAjax"></div>
    
        <div class="accordion" id="accordionExample">
            <div class="card">
                <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Detalle de componentes
                    </button>
                    <button style="position: relative;left: 70%;" class="btn btn-success">Emitir Vale</button>
                </h2>
                
                </div>
                <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#accordionExample">
                    <div class="card-body">
                            <div class="columns is-multiline" id="catalogo">
                                <form action="" method="POST">
                                        <div class="input-group mb-3">                        
                                                <div class="input-group-prepend">                            
                                                    <button class="btn btn-primary" type="submit" id="button-addon1">Buscar</button>
                                                </div>
                                                <input type="text" name="buscador" class="form-control" placeholder="Buscar componentes"  aria-describedby="button-addon1">
                                        </div>
                                </form>

                                <?php echo $text; ?>   
                                <?php  echo $almCont->paginador_componentes($pagina[1],5,"",$buscador,$pagina[0]);?>   
                            </div>
    <form action="<?php echo SERVERURL;?>ajax/almacenAjax.php" method="POST" data-form="save" class="FormularioAjax" autocomplete="off" enctype="multipart/form-data">    
                            <div id="productosCarrito">
                                <!-- item de local storage para salida del almacen-->
                            </div>  
                    </div>
                </div>
            </div>
            <input type="hidden" name="usuario" value="<?php echo $_SESSION['id_sbp'];?>"/>
            <div class="card">
                <div class="card-header" id="headingTwo">
                    <h2 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#Productos" aria-expanded="false" aria-controls="collapseTwo">
                        Datos de vale de salida
                        </button>
                    </h2>
                </div>
                
                <div id="Productos" >                    
                    <div class="card-body">
                        <div class="card-deck">
                            <div class="card">
                                <div class="card-header">
                                    Quote
                                </div>
                                <div class="card-body">
                                    <blockquote >
                                        <div class="form-row">                                  
                                            <div class="form-group col-8"> 
                                                <label for="inputEmail4">Solicitado por</label>                              
                                                <select data-placeholder="Seleccione personal" name="personal" class="chosen-select" >
                                                    <option value=""></option>
                                                    <?php echo $almCont->chosen_personal(0,1)?>
                                                </select>
                                            </div>
                                            <div class="form-group col-10"> 
                                                <label for="inputEmail4">Turno</label>                              
                                                <select class="form-control" name="turno">
                                                    <option>Seleccione</option><option value="dia">Dia</option><option value="noche">Noche</option>
                                                </select>
                                            </div>
                                        </div>
                                        <footer class="blockquote-footer">Someone famous in <cite title="Source Title">Source Title</cite></footer>
                                    </blockquote>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-header">
                                    Quote
                                </div>
                                <div class="card-body">
                                    <blockquote class="">
                                        <div class="form-row">                                  
                                            <div class="form-group col-10"> 
                                                <label for="inputEmail4">Cod. Equipo</label>                              
                                                <select name="codequipo" data-placeholder="Seleccione Equipo"  class="chosen-select" >
                                                    <option value=""></option>
                                                    <?php echo $almCont->chosen_equipo(0,1)?>
                                                </select>
                                            </div>
                                            <div class="form-group col-10"> 
                                                <label for="inputEmail4">Horometro</label>                              
                                                <input type="number" name="horometro" class="form-control"  placeholder="Horometro">
                                            </div>
                                        </div>
                                        <footer class="blockquote-footer">Someone famous in <cite title="Source Title">Source Title</cite></footer>
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                                <label for="exampleFormControlTextarea1">Comentario de salida de los repuestos</label>
                                <textarea  name="comentario" class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-success btn-lg btn-block">Emitir Vale</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="RespuestaAjax"></div>
    </form>     
    
</div>
<script src="../vistas/js/carrito.js"></script>