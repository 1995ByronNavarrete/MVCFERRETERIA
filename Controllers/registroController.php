<?php
    class registroController extends Controller{
        private $modelReg;

        function __construct()
        {
            parent::__construct();
            $this->modelReg = $this->loadModel("registro");
        }

        public function index(){
            if($_SERVER['REQUEST_METHOD'] == "POST"){
                $actualSucursal = $this->modelReg->getSucursal();

                $this->_view->datos = $this->modelReg->addCliente($_POST,$actualSucursal[0]);
                $this->redireccionar("login");
            }

            if(Accesos::getDatos('acceso')) $this->redireccionar("home");
            $this->_view->renderizar("index");
        }

        public function buscar(){
            $dato = '';

            switch($this->getTexto('tipo')){
                case 'correo' :
                     $dato = $this->modelReg->buscarReg($this->getTexto('valor'),$this->getTexto('tipo'));
                break;

                case 'cedula' :
                    $dato = $this->modelReg->buscarReg($this->getTexto('valor'),$this->getTexto('tipo'));
               break;

               case 'nombre_usuario' :
                    $dato = $this->modelReg->buscarReg($this->getTexto('valor'),$this->getTexto('tipo'));
                break;
                
               case 'telefono' :
                    $dato = $this->modelReg->buscarReg($this->getTexto('valor'),$this->getTexto('tipo'));
                break;

            }

            echo json_encode($dato);
        }
    }