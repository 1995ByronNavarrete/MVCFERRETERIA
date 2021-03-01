<?php
    class homeController extends Controller{

        private $homeModel;

        public function __construct(){
            parent::__construct();
            $this->homeModel = $this->loadModel('home');
        }

        public function index(){
            if(Accesos::getDatos('validado')) $this->_view->renderizar("index");
            $this->redireccionar('login');
        }

        public function estadistica(){
            $datos = $this->homeModel->getStatus(Accesos::getDatos("identificadorSuc"));
            echo json_encode($datos);
        }
    }