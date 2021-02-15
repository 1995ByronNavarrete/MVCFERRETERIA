<?php
    class loginController extends Controller{
        private $loginModel;

        function __construct()
        {
            parent::__construct();
            $this->loginModel = $this->loadModel("login");
        }

        public function index(){ 
            if($_SERVER['REQUEST_METHOD'] == "POST"){
                $cliente = $this->loginModel->getCliente($_POST);

                if($this->getTexto('loginClienteUser') == $cliente['cliente_username'] && password_verify($this->getTexto('loginClientePass'),$cliente['cliente_password'])){
                    Accesos::setDatos('acceso',true);
                    Accesos::setDatos('cliente',$cliente);
                    $this->redireccionar('home');
                }else{
                    $this->_view->errLog = "
                        <div class='alert alert-danger alert-dismissable'>
                            <button type='button' class='close' data-dismiss='alert'>
                                &times;
                            </button>
                            <strong>Error!</strong> Correo y/o Password Incorrecto
                        </div>";
                }
            }

            if(Accesos::getDatos('acceso')) $this->redireccionar("home");
            $this->_view->renderizar('index');
         }


         public function salir(){
            Accesos::salir();
            $this->redireccionar('home');
        }
    }
