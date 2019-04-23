
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
  
        
        <div class="accordion" id="accordionExample">
            <div class="card">
                <div class="card-header" id="headingOne">
                <h2 class="mb-0">
                    <button class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Collapsible Group Item #1
                    </button>
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
                         
                            <div id="productosCarrito">
                                <!-- item de local storage para salida del almacen-->
                            </div>  
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="headingTwo">
                    <h2 class="mb-0">
                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#Productos" aria-expanded="false" aria-controls="collapseTwo">
                        Encabezado
                        </button>
                    </h2>
                </div>

                <div id="Productos" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionExample">
                    <div class="card-body">

                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header" id="headingThree">
                <h2 class="mb-0">
                    <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Collapsible Group Item #3
                    </button>
                </h2>
                </div>
                <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionExample">
                    <div class="card-body">
                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                    </div>
                </div>
            </div>

        </div>
         
  
</div>
<script src="../vistas/js/carrito.js"></script>