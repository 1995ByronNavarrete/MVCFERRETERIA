<?php if (Accesos::getDatos('validado')) : ?>
  </div>
  <!-- /.container-fluid -->

  </div>
  <!-- End of Main Content -->

  <!-- Footer -->
  <footer class="sticky-footer bg-white">
    <div class="container my-auto">
      <div class="copyright text-center my-auto">
        <span>Copyright &copy; Your Website 2020</span>
      </div>
    </div>
  </footer>
  <!-- End of Footer -->

  </div>
  <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Listo para irse?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Seleccione "Cerrar sesión" a continuación si está listo para finalizar su sesión actual.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="<?= BASE_URL ?>login/salir">Cerrar sesión</a>
        </div>
      </div>
    </div>
  </div>

  <!-- show Modal trabajador-->
  <div class="modal fade" id="showTrabajadorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Informacion general del trabajador</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col-sm-4 col-md-4 text-center">
              <img src="" id="imgTra" class="img-fluid" alt="" width="100" height="100">
            </div>
            <div class="col-sm-8 col-md-8 row">
              <div class="tituloTra col-md-4">Nombre: </div> <span id="nomTra" class="col-md-8"></span>
              <div class="tituloTra col-md-4">Apellido:</div> <span id="apeTra" class="col-md-8"></span>
              <div class="tituloTra col-md-4">Nombre Usuario: </div><span id="nUsTra" class="col-md-8"></span>
              <div class="tituloTra col-md-4">Correo: </div> <span id="corTra" class="col-md-8"></span>
              <div class="tituloTra col-md-4">Direccion: </div> <span id="dirTra" class="col-md-8"></span>
              <div class="tituloTra col-md-4">Telefono:</div> <span id="telTra" class="col-md-8"></span>
              <div class="tituloTra col-md-4">Rol: </div><span id="rolTra" class="col-md-8"></span>
              <div class="redesSociales border-top d-flex col-md-12 mt-3 p-2 justify-content-around">
                <!-- <p><a href="#" class="text-decoration-none"><span class="fab fa-facebook"></span> Facebook</a></p>
                    <p><a href="#" class="text-decoration-none"><span class="fab fa-twitter"></span> Twitter</a></p>
                    <p><a href="#" class="text-decoration-none"><span class="fab fa-instagram"></span> Instagram</a></p>
                    <p><a href="#" class="text-decoration-none" id="numWhat" title=""><span class="fab fa-whatsapp"></span> Whatsapp</a></p> -->
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- update Modal trabajador-->
  <div class="modal fade" id="updateTrabajadorModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Actualiza Informacion del trabajador</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">

          <form method="post" class="row updateTrabajador">
            <input type="hidden" name="id" id="updid">
            <input type="hidden" name="rol" id="updrol">

            <div class="form-group col-md-6">
              <label for="nombre">Nombre</label>
              <input type="text" name="nombre" id="updnombre" class="form-control" required autocomplete="off">
            </div>
            <div class="form-group col-md-6">
              <label for="apellido">Apellido</label>
              <input type="text" name="apellido" id="updapellido" class="form-control" required autocomplete="off">
            </div>
            <div class="form-group col-md-6">
              <label for="nombreUsuario">Nombre Usuario</label>
              <input type="text" name="nombreUsuario" readonly id="updnombreUsuario" class="form-control" required autocomplete="off">
              <div class="repetido"></div>
            </div>

            <div class="form-group col-md-6">
              <label for="direccion">Direccion</label>
              <input type="text" name="direccion" id="upddireccion" class="form-control" required autocomplete="off">
            </div>

            <div class="form-group col-md-6">
              <label for="telefono">Telefono</label>
              <input type="text" name="telefono" id="updtelefono" class="form-control" required autocomplete="off">
            </div>

            <div class="form-group col-md-6">
              <label for="correo">Correo</label>
              <input type="email" name="correo" readonly id="updcorreo" class="form-control" required autocomplete="off">
              <div class="repetidoCorreo"></div>
            </div>

            <div class="form-group col-md-6">
              <label for="pass">Rol</label>
              <select name="newrol" class="form-control">
                <option value="2">Registrador</option>
                <option value="3">Invitado</option>
              </select>
            </div>

            <div class="form-group col-md-6 my-auto">
              <input type="submit" value="Actualizar" class="btn btn-primary btn-block" required>
            </div>
          </form>

        </div>
      </div>
    </div>
  </div>

  <!-- show Modal trabajador-->
  <div class="modal fade" id="ServiciosShowModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Editar Servicio</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="form editarServicio">
            <div class="form-group">
              <input type="hidden" id="idSer">
              <label for="updServicio">Servicio</label>
              <input type="text" id="updServicio" class="form-control">
            </div>

            <div class="form-group">
              <label for="descripcion">Descripcion</label>
              <textarea name="updDescripcionSer" id="updDescripcionSer" class="form-control serDesc"></textarea>
            </div>
            <div class="form-group">
              <input type="submit" value="Actualizar" class="btn btn-block btn-primary">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- show Modal Proveedor-->
  <div class="modal fade" id="ProveedorShowModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Editar Proveedor</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="form editarProveedor">
            <input type="hidden" id="base" value="<?= BASE_URL ?>">
            <input type="hidden" id="idProv">
            <div class="form-group">
              <label for="nombre">Nombre</label>
              <input type="text" id="nombrePro" class="form-control" placeholder="Nombre" required>
            </div>

            <div class="form-group">
              <label for="direccionPro">Dirección</label>
              <input type="text" id="direccionPro" class="form-control" placeholder="Direccion" required>
            </div>

            <div class="form-group">
              <label for="telefono">Telefono</label>
              <input type="text" id="telefonoPro" class="form-control" placeholder="Telefono" required>
            </div>

            <div class="form-group">
              <input type="submit" value="Guardar" class="btn btn-block btn-primary">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

    <!-- show Modal categoria-->
    <div class="modal fade" id="CategoriaShowModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Editar Categoria</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <form class="form editarCategoria">
            <div class="form-group">
              <input type="hidden" id="idCat">
              <label for="nombre">Nombre</label>
              <input type="text" id="updCategoriaNom" class="form-control">
            </div>

            <div class="form-group">
              <label for="descripcion">Descripcion</label>
              <textarea name="updCategoriaDesc" id="updCategoriaDesc" class="form-control serDesc"></textarea>
            </div>
            <div class="form-group">
              <input type="submit" value="Actualizar" class="btn btn-block btn-primary">
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>


<?php endif; ?>


<!-- Bootstrap core JavaScript-->
<script src="<?= PLANTILLA ?>vendor/jquery/jquery.min.js"></script>
<script src="<?= PLANTILLA ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Core plugin JavaScript-->
<script src="<?= PLANTILLA ?>vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Custom scripts for all pages-->
<script src="<?= PLANTILLA ?>js/sb-admin-2.min.js"></script>

<!-- Page level plugins -->
<script src="<?= PLANTILLA ?>vendor/datatables/jquery.dataTables.min.js"></script>
<script src="<?= PLANTILLA ?>vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.bootstrap4.min.js"></script>

<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script type="text/javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
<script type="text/javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/vfs_fonts.js"></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>

<!-- Page level custom scripts -->
<script src="<?= PLANTILLA ?>js/demo/datatables-demo.js"></script>
<script src="<?= PLANTILLA ?>js/sweetalert2.js"></script>
<script src="<?= PLANTILLA ?>js/app.js" type="module"></script>

<script src="<?= PLANTILLA ?>js/complexify/jquery.complexify.banlist.js"></script>
<script src="<?= PLANTILLA ?>js/complexify/jquery.complexify.js"></script>

<script src="<?= PLANTILLA ?>js/validaPass.js"></script>
<script src="<?= PLANTILLA ?>js/jquery.validate.min.js"></script>

<script src="<?= PLANTILLA ?>js/inputMask/jquery.maskedinput.js"></script>
<script src="<?= PLANTILLA ?>js/mascaras.js"></script>

<script src="<?= PLANTILLA ?>js/chosen.jquery.min.js"></script>
<script src="<?= PLANTILLA ?>js/isotope.min.js"></script>

<script src="<?= PLANTILLA ?>js/complementos.js"></script>


<script src="<?= PLANTILLA ?>vendor/chart.js/Chart.min.js"></script>
<script src="<?= PLANTILLA ?>js/demo/chart-bar-demo.js"></script>
<script src="<?= PLANTILLA ?>js/demo/chart-pie-demo.js"></script>






</body>

</html>