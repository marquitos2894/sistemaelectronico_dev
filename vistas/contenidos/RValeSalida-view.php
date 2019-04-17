<script src="../vistas/js/carrito.js"></script>
<?php 
      require_once "./controladores/almacenControlador.php";
      $almCont = new almacenControlador();     
?>

<div class="container-fluid">
            <!-- CATALOGO DE PRODUCTOS -->
        <section class="section">
        <div class="container">
            <div class="columns is-multiline" id="catalogo">



            </div>
        </div>

</div>
<div class="container-fluid">
        </section>

        <!-- item de local storage para salida del almacen-->

            <section>
                <div id="productosCarrito">
                    <!-- PRODUCTOS AGREGADOS AL CARRITO -->

                </div>
            </section>
</div>
