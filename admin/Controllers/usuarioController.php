<?php
    class usuarioController extends Controller{
        private $mUsu;

        function __construct()
        {
            parent::__construct();
            $this->mUsu = $this->loadModel("usuario");
        }

        // PLANTILLA PARA LOS USUARIOS
        public function getUser()
        {
            $plantilla = '';
            $registros = $this->mUsu->getTrabajadores(Accesos::getDatos('identificadorSuc'));
            foreach($registros AS $fila){
                $datos = json_encode($fila);

                $plantilla.='
                    <tr>
                        <td>'.$fila->admin_ID.'</td>
                        <td>'.$fila->admin_nombre.'</td>
                        <td>'.$fila->admin_apellido.'</td>
                        <td><button class="btn btn-info showTra"  data-target="#showTrabajadorModal" data-ruta="'. PLANTILLA .'" data-informacion=\''.$datos.'\' data-toggle="modal"><i class="fa fa-eye"></i></button></td>
                        <td><button class="btn btn-primary updateTra"  data-target="#updateTrabajadorModal" data-ruta="'. PLANTILLA .'" data-trabajador=\''.$datos.'\' data-toggle="modal"><i class="fa fa-edit"></i></button></td>
                        <td><button class="btn btn-danger deleteTra"  data-eliminar="'. $fila->admin_ID .'"><i class="fa fa-trash"></i></button></td>
                    </tr>
                ';
            }

            return $plantilla;
        }

        public function generarRol(){
            $fila = "";
            $datos = $this->mUsu->getRol();
            foreach($datos AS $d){
                $fila .= '<option value="'.$d['rol_ID'].'">'.$d['rol_nombre'].'</option>';
            }
            return $fila;
        }

        // PAGINA PRINCIPAL DE TRABAJADORES
        public function index()
        {
            
            $this->_view->roles = $this->generarRol();
            $this->_view->contenido = $this->getUser();
            $this->_view->renderizar('index');
        }

        // BUSCAR COINCIDENCIA DE USERNAME
        public function buscar()
        {
            $usuario = sizeof($this->mUsu->getUsuario($this->getTexto('nombre')));
            echo $usuario;
        }

        // BUSCAR COINCIDENCIAS DE CORREOS
        public function buscarCorreo()
        {
            $correo = sizeof($this->mUsu->getCorreo($this->getTexto('correo')));
            echo $correo;
        }

        // AGREGAR USUARIO
        public function addUser()
        {
            $userData = array(
                "nomTra" => $this->getTexto("nombre"),
                "apeTra" => $this->getTexto("apellido"),
                "nUsTra" => $this->getTexto("nombreUsuario"),
                "corTra" => $this->getTexto("correo"),
                "conTra" => password_hash($this->getTexto("pass"),PASSWORD_DEFAULT,['cost' => 10]),
                "rolTra" => $this->getTexto("rol"),
                "dirTra" => $this->getTexto("direccion"),
                "telTra" => $this->getTexto("telefono")
            );

            $this->mUsu->agregarUsuario($userData);

            $datos = $this->mUsu->getNewTra();
            $this->mUsu->addSucursalTra($datos[0]['admin_ID'],Accesos::getDatos('identificadorSuc'));

            echo $this->getUser();
        }

        public function update(){
            $rol = ($this->getTexto('newrol') != $this->getTexto('rol')) ? $this->getTexto('newrol') : $this->getTexto('rol'); 

            $userData = array(
                "idTra" => $this->getTexto("id"),
                "nomTra" => $this->getTexto("nombre"),
                "apeTra" => $this->getTexto("apellido"),
                "nUsTra" => $this->getTexto("nombreUsuario"),
                "corTra" => $this->getTexto("correo"),
                "dirTra" => $this->getTexto("direccion"),
                "telTra" => $this->getTexto("telefono"),
                "rolTra" => $rol
            );

            echo $this->mUsu->upd($userData);
            echo $this->getUser();
        }

        public function eliminar(){
            $this->mUsu->elimTraSuc($this->getTexto('eliminar'));
            $this->mUsu->elimTra($this->getTexto('eliminar'));
            echo $this->getUser();
        }

    }