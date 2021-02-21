<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-dark accordion" style="background:rgba(10,10,30,1)" id="accordionSidebar">

<!-- Sidebar - Brand -->
<a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= BASE_URL ?>index">
  <div class="sidebar-brand-icon rotate-n-15">
    <i class="fas fa-industry"></i>
  </div>
  <div class="sidebar-brand-text mx-3"><?= Accesos::getDatos('nameSucursal')?></div>
</a>

<!-- Divider -->
<hr class="sidebar-divider my-0">

<!-- Nav Item - Dashboard -->
<li class="nav-item">
  <a class="nav-link" href="<?= BASE_URL ?>home">
    <i class="fas fa-fw fa-home"></i>
    <span>Inicio</span></a>
</li>
 
<!-- Divider -->
<hr class="sidebar-divider">

<!-- Heading -->
<div class="sidebar-heading">
  General
</div>

<!-- Nav Item - Pages Collapse Menu -->
<li class="nav-item">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#productos" aria-expanded="true" aria-controls="collapseUtilities">
    <i class="fas fa-box"></i>
    <span>Productos/Servicios</span>
  </a>

  <div id="productos" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
    <div class="bg-white py-2 collapse-inner rounded">
      <a class="collapse-item" href="<?= BASE_URL ?>categoria">Categorias</a>
      <a class="collapse-item" href="<?= BASE_URL ?>productos">Productos</a>
      <a class="collapse-item" href="<?= BASE_URL ?>servicios">Servicios</a>
    </div>
  </div>
</li>

<!-- Nav Item - Dashboard -->
<li class="nav-item">
  <a class="nav-link" href="<?= BASE_URL ?>proveedores">
    <i class="fas fa-fw fa-truck"></i>
    <span>Proveedores</span></a>
</li>


<li class="nav-item">
  <a class="nav-link" href="<?= BASE_URL ?>usuario">
    <i class="fas fa-fw fa-walking"></i>
    <span>Trabajadores</span></a>
</li>

<li class="nav-item">
  <a class="nav-link" href="<?= BASE_URL ?>sucursal">
    <i class="fas fa-store"></i>
    <span>Sucursales</span></a>
</li>
<!-- Nav Item - Utilities Collapse Menu -->
<!-- <li class="nav-item">
  <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
    <i class="fas fa-fw fa-wrench"></i>
    <span>Proveedores</span>
  </a>
  <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
    <div class="bg-light py-2 collapse-inner rounded">
      <h6 class="collapse-header text-dark">Acciones:</h6>
      <a class="collapse-item text-dark" href="utilities-color.html">Listar Proveedores</a>
    </div>
  </div>
</li>
 -->

<!-- Divider -->
<hr class="sidebar-divider d-none d-md-block">

<!-- Sidebar Toggler (Sidebar) -->
<div class="text-center d-none d-md-inline">
  <button class="rounded-circle border-0" id="sidebarToggle"></button>
</div>

</ul>
<!-- End of Sidebar -->