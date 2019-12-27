<html lang="es">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <title>Conmciv Admin</title>
</head>

<body id="page-top">
  <!-- Page Wrapper -->
  <div id="wrapper">
    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo SERVERURL;?>">
        <div class="sidebar-brand-icon rotate-n-15">
          <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Conmciv<sup>1.4</sup></div>
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="nav-item active">
        <a class="nav-link" href="<?php echo SERVERURL;?>">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Conmiciv</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Interface
      </div>

      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i class="fas fa-fw fa-cog"></i>
          <span>Configuracion</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Configuracion General</h6>
            <!--a class="collapse-item" href="<?php //echo SERVERURL;?>micuenta/">Mi cuenta</a-->
            <a class="collapse-item" href="">Aplicacion</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Utilities Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
          <i class="fas fa-fw fa-wrench"></i>
          <span>Utilities</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Custom Utilities:</h6>
            <a class="collapse-item" href="utilities-color.html">Colors</a>
            <a class="collapse-item" href="utilities-border.html">Borders</a>
            <a class="collapse-item" href="utilities-animation.html">Animations</a>
            <a class="collapse-item" href="utilities-other.html">Other</a>
          </div>
        </div>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Addons
      </div>

      <!-- Nav Item - Pages Collapse Menu -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-people-carry"></i>
          <span>Persona</span>
        </a>
        <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
           
            <div class="collapse-divider"></div>
            <!--a class="collapse-item" href="<?php //echo SERVERURL;?>usuariolist/">Usuarios</a-->
            <a class="collapse-item" href="<?php echo SERVERURL;?>personallist/">Personal</a>
            
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages-equipos" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-tractor"></i>
          <span>Equipos</span>
        </a>
        <div id="collapsePages-equipos" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <div class="collapse-divider"></div>
            <a class="collapse-item" href="<?php echo SERVERURL;?>equipos/">Equipos</a>
            <a class="collapse-item" href="<?php echo SERVERURL;?>miFlota/">miFlota</a>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages-comp" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-box-open"></i>
          <span>Componentes</span>
        </a>
        <div id="collapsePages-comp" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <div class="collapse-divider"></div>
            <a class="collapse-item" href="<?php echo SERVERURL;?>componentes/">Componente</a>
            <a class="collapse-item" href="<?php echo SERVERURL;?>unidadmedlist/">Unidad Medida</a>
            <a class="collapse-item" href="<?php echo SERVERURL;?>datosReferencia/">Datos de referencia</a>  
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAlmacen" aria-expanded="true" aria-controls="collapseAlmacen">
          <i class="fas fa-store"></i>
          <span>Almacen</span>
        </a>
        <div id="collapseAlmacen" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            
            <!--a class="collapse-item" href="<?php //echo SERVERURL;?>NuevoAlmacen/">Nuevo Almacen</a -->
            <a class="collapse-item" href="<?php echo SERVERURL;?>almacen/">Almacen</a>
            <h6 class="collapse-header">Reportes</h6>
            <!--a class="collapse-item" href="<?php echo SERVERURL;?>almacen/">Reportes</a-->
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseGuia" aria-expanded="true" aria-controls="collapsePages">
          <i class="fas fa-fw fa-folder"></i>
          <span>Guia Remision</span>
        </a>
        <div id="collapseGuia" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">paginas</h6>
            <a class="collapse-item" href="#">Guia remision</a>
            <a class="collapse-item" href="#">Empresa de transporte</a>
            <div class="collapse-divider"></div>
            <a class="collapse-item" href="blank.html">Blank Page</a>
          </div>
        </div>
      </li>

      <!-- Nav Item - Charts -->
      <li class="nav-item">
        <a class="nav-link" href="charts.html">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Charts</span></a>
      </li>

      <!-- Nav Item - Tables -->
      <li class="nav-item">
        <a class="nav-link" href="tables.html">
          <i class="fas fa-fw fa-table"></i>
          <span>Tables</span></a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

         <!-- Topbar Navbar -->
          <?php if($_SESSION['unidad']==1):?>
          <h3 style="aling:center"><span class="badge badge-warning">CIA Minera horizonte</span></h3>
          <?php elseif($_SESSION['unidad']==2):?>
          <h3 style="aling:center"><span class="badge badge-primary">CIA Minera Kolpa</span></h3>
          <?php elseif($_SESSION['unidad']==6):?>
          <h3 style="aling:center"><span class="badge badge-success">Taller/Chorrillos</span></h3>
          <?php elseif($_SESSION['unidad']==28):?>
          <h3 style="aling:center"><span class="badge badge-secondary">Compañia Minera Corona</span></h3>
          <?php endif;?>

          <ul class="navbar-nav ml-auto">
            <!-- Nav Item - Search Dropdown (Visible Only XS) -->
            <li class="nav-item dropdown no-arrow d-sm-none">
              <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-search fa-fw"></i>
              </a>
              <!-- Dropdown - Messages -->
              <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                <form class="form-inline mr-auto w-100 navbar-search">
                  <div class="input-group">
                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                      <button class="btn btn-primary" type="button">
                        <i class="fas fa-search fa-sm"></i>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </li>
            <?php if($_SESSION["privilegio_sbp"]==0 or $_SESSION["privilegio_sbp"]==3 ):?>
            <!-- Nav Item - Alerts -->
            <li class="nav-item dropdown no-arrow mx-1" id="dropdown_cuenta">
              <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-exchange-alt"></i>
                <!-- Counter - Alerts -->
              </a>
              <!-- Dropdown - Alerts -->
              <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                 Cambiar cuenta
                </h6>
                <a class="dropdown-item d-flex align-items-center" href="#" id="" data-cuenta="1">
                  <div class="mr-3">
                    <div class="icon-circle bg-warning" data-cuenta="1">
                      <i class="fab fa-cuttlefish text-white" data-cuenta="1"></i>
                    </div>
                  </div>
                  <div >
                    <div class="small text-gray-500" data-cuenta="1" >Trujillo - La libertad</div>
                    <span class="font-weight" data-cuenta="1">Consorcio minero horizonte</span>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#" data-cuenta="2">
                  <div class="mr-3">
                    <div class="icon-circle bg-primary" data-cuenta="2">
                      <i class="fab fa-kickstarter-k text-white" data-cuenta="2"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500" data-cuenta="2">Huancavelica</div>
                    <span class="font-weight" data-cuenta="2">Cia Minera Kolpa</span>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#" data-cuenta="2">
                  <div class="mr-3">
                    <div class="icon-circle bg-secondary" data-cuenta="28">
                      <i class="fab fa-cuttlefish" data-cuenta="28"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500" data-cuenta="28">Cañete</div>
                    <span class="font-weight" data-cuenta="28">Compañia Minera Corona</span>
                  </div>
                </a>
                <a class="dropdown-item d-flex align-items-center" href="#" data-cuenta="6">
                  <div class="mr-3">
                    <div class="icon-circle bg-success" data-cuenta="6">
                      <i class="fab fa-tumblr text-white" data-cuenta="6"></i>
                    </div>
                  </div>
                  <div>
                    <div class="small text-gray-500" data-cuenta="6">Lima - Chorrillos</div>
                    <span class="font-weight" data-cuenta="6">Taller chorrillos</span>s
                  </div>
                </a>
                <a class="dropdown-item text-center small text-gray-500" href="#">Todas las cuentas</a>
              </div>
            </li>
           
            <?php endif;?>
           
            <div class="topbar-divider d-none d-sm-block"></div>
            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION["nombre_sbp"]; ?></span>
                <img class="img-profile rounded-circle" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTtmPb__cjl6z-clzs0u7MXDNiYVFd_C3AmuhDBVpmki7KFY-9GEg">
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="#">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  Profile
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                  Settings
                </a>
                <a class="dropdown-item" href="#">
                  <i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>
                  Activity Log
                </a>
                <div class="dropdown-divider"></div>
                <a id="btnlogout" class="dropdown-item" href="<?php echo $lc->encryption($_SESSION['token_sbp']); ?>"  >
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>
        </nav>
        <!-- End of Topbar -->
      </div>