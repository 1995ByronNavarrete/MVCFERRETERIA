<?php
    class loginController extends Controller{

        private $log;
        
        function __construct(){
            parent::__construct();
            $this->log = $this->loadModel('login');
        }

        public function generarSucursal(){
            $fila = "";
            $datos = $this->log->getSucursal();
            foreach($datos AS $d){
                $fila .= '<option value="'.$d['sucursal_ID'].'">'.$d['sucursal_nombre'].'</option>';
            }
            return $fila;
        }

        public function index(){
            if($this->getTexto("ingresar") == "1"){
                $sucursal = $this->log->getSucursal($this->getTexto('sucursal'));
                $usuario = $this->log->getUsuario($this->getTexto("usuario"),$sucursal['sucursal_ID']);
                
                if(!$usuario) $this->_view->mensaje = "<h5 class='text-danger mt-3'>No pertece a la sucursal ".$sucursal['sucursal_nombre']."</h5>";
                else if($this->getTexto('usuario') == $usuario['admin_usuario'] && password_verify($this->getTexto("password"),$usuario['admin_pass'])){
                    //validados
                    Accesos::setDatos('validado',true);
                    Accesos::setDatos('rol', $usuario['rol_nombre']);
                    Accesos::setDatos('usuario',$usuario['admin_nombre']. " " . $usuario['admin_apellido']);
                    Accesos::setDatos('nameSucursal',$sucursal['sucursal_nombre']);
                    Accesos::setDatos('identificadorSuc',$sucursal['sucursal_ID']);
                    Accesos::setDatos('allSuc',$sucursal);
                    Accesos::setDatos('allUs',$usuario);
                    $this->redireccionar('home');

                }else{
                    $this->_view->mensaje = "<h5 class='text-danger mt-3'>Usuario y/o Clave incorrecta</h5>";
                }
                
            }
            
            $this->_view->sucursal = $this->generarSucursal();
            $this->_view->renderizar("index");
        }

        public function salir(){
            Accesos::salir();
            $this->redireccionar('index');
        }
    }