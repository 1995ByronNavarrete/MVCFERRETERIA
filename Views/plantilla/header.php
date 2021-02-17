<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title></title>
  <!-- estilos -->
    <link href="<?= PLANTILLA ?>css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= PLANTILLA ?>css/footer.css" rel="stylesheet">
    <link href="<?= PLANTILLA ?>css/main.css" rel="stylesheet">
    <link href="<?= PLANTILLA ?>css/header.css" rel="stylesheet">
    <link href="<?= PLANTILLA ?>css/home.css" rel="stylesheet">
    <link href="<?= PLANTILLA ?>css/cat_aside.css" rel="stylesheet">
    <link href="<?= PLANTILLA ?>css/productos.css" rel="stylesheet">
    <link href="<?= PLANTILLA ?>css/proforma.css" rel="stylesheet">

  <!-- Custom fonts for this template-->
  <link href="<?= PLANTILLA ?>vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this page -->
  <link href="<?= PLANTILLA ?>vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

  <link rel="stylesheet" type="text/css" href="//cdn.datatables.net/buttons/1.3.1/css/buttons.bootstrap4.min.css"/>
  
</head>

<body>
<input type="hidden" id="base" value="<?= BASE_URL ?>">
<input type="hidden" id="fotosAdmin" value="<?= PLANTILLAFOTO ?>">
<input type="hidden" id="accesoSistema" value="<?= Accesos::getDatos('acceso') ?>">
<input type="hidden" id="clienteId" value="<?= Accesos::getDatos('cliente')['cliente_id'] ?>">
<header><!--header-->
		<div class="header_top"><!--header_top-->
			<div class="container">
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<div class="info_contacto">
							<ul class="nav nav-pills">
								<li><a href="#"><i class="fa fa-phone"></i> +505 <span id="telefonoSucursal"></span></a></li>
								<li><a href="#"><i class="fa fa-envelope"></i> <span id="correoSucursal"></span></a></li>
								<?php if(Accesos::getDatos('acceso')):?>
								<li><a href="<?=BASE_URL?>login/salir"><i class="fa fa-door-closed"></i> Cerrar Sesion</a></li>
								<?php endif; ?>
							</ul>
						</div>
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						<div class="social-icons pull-right">
							<ul class="nav navbar-nav">
								<li><a href="#" class="text-white"><i class="fab fa-facebook"></i></a></li>
								<li><a href="#"><i class="fab fa-twitter"></i></a></li>
								<li><a href="#"><i class="fab fa-instagram"></i></a></li>
							</ul>
						</div>
						
					</div>
				</div>
			</div>
		</div><!--/header_top-->

		<div class="row container" style="margin:auto">
				<div class="col-md-3 col-lg-4">
					<div class="header-middle"><!--header-middle-->
						<div class="container">
							<div class="row">
								<div class="col-sm-4">
									<div class="pull-left">
										<a href="<?=BASE_URL?>home"><img src="<?= PLANTILLA?>/img/logo/logo.png" alt="" style="width:100px"/>
											<span id="nameSucursal"></span>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div><!--/header-middle-->
				</div>
				<div class="col-md-7 col-lg-7" style="display:flex;padding-top:48px">
					<h4 style="margin-left:15px"><b>Seleccione la Sucursal:</b></h4>
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb" id="sucursalMostrar">
						</ol>
					</nav>
				</div>
				<div class="col-md-1 col-lg-1" >
				<?php if(!Accesos::getDatos('acceso')):?>
					<div class="text-right" style="padding-top:45px"><a href="<?=BASE_URL?>login"><i class="fa fa-user"></i> Login</a></div>
				<?php endif;?>
				</div>
				
		</div>

	<div class="container Mostraocultar" style="box-shadow: 1px 1px 10px #cacaca;display:none">
        <div class="row">
            <!-- Elementos generados a partir del JSON -->
            <main id="items" class="col-md-12 row"></main>
            <!-- Carrito -->
            <aside class="col-md-12">
                <h2 class="text-center">Presupuesto</h2>
                <!-- Elementos del carrito -->
                <ul id="carrito" class="list-group"></ul>
                
                <!-- Precio total -->
                <p class="text-right font-black" style="margin-right:20px"><b>Total: C$ </b> <span id="total"></span></p>
                <div class="col-md-12">
					<button id="boton-vaciar" class="btn btn-danger" style="margin:10px">Vaciar</button>
					<button id="imprimir" class="btn btn-success" style="margin: 0px 5px">Imprimir</button>
				</div>
            </aside>
        </div>
    </div>
		

        <div class="header-bottom"><!--header-bottom-->
			<div class="container" style="border-bottom: 1px solid #ccc">
				<div class="row">
					<div class="col-sm-9">
						<div class="navbar-header">
							<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
								<span class="sr-only">Toggle navigation</span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
								<span class="icon-bar"></span>
							</button>
						</div>
						<div class="menu_principal pull-left">
							<ul class="nav navbar-nav collapse navbar-collapse">
								<li><a href="<?=BASE_URL?>home" class="active">Inicio</a></li>
								<li><a href="<?=BASE_URL?>producto">Productos</a></li>								
								<li><a href="<?=BASE_URL?>contacto">Contactanos</a></li>
								<li id="proformaOcultar">
									<a href="#" class="proformaToggle">
										<span class="fa fa-book-reader"></span> Proforma <span class="badge badge-primary cant">0</span>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
        </div><!--/header-bottom-->
</header>
