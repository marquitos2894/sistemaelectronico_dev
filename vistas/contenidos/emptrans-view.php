
<div class="container" >

    <ul class="list-group list-group-horizontal">
        <li class="list-group-item"><a href="<?php echo SERVERURL;?>emptranslist">Lista de empresa de transporte</a></li>
        <li class="list-group-item"><a href="<?php echo SERVERURL;?>emptrans">+ Nueva Empresa transporte</a></li>
    </ul>

    <div class="card o-hidden border-0 shadow-lg my-5">
    <div class="text-center">
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-10 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Nueva empresa de transporte</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Nested Row within Card Body -->
        <div class="row">
        <div class="col-lg-10">
            <div class="p-5">
            <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">Crear empresa de transporte</h1>
            </div>
            <form action="<?php echo SERVERURL;?>ajax/emptransAjax.php"  method="POST" data-form="save" class="FormularioAjax , user" autocomplete="off" >
                <div class="form-group row">
                <div class="col-sm-6 mb-3 mb-sm-0">
                    <input type="text" class="form-control form-control-user" name="razonsocial" id="exampleFirstName" placeholder="Razon social">
                </div>
                <div class="col-sm-6">
                    <input type="text" class="form-control form-control-user" name="ruc" id="exampleLastName" placeholder="Ruc">
                </div>
                </div>
                <div class="form-group row">
                </div>
    
                <input type="submit" class="btn btn-primary btn-user btn-block" value="GUARDAR">
                <hr>
                <div class="RespuestaAjax"></div>
            </form>
            <hr>
            </div>
        </div>
        </div>
    </div>
    </div>
</div>

