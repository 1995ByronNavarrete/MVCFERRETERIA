<?php
    class serviciosController extends Controller{
        private $servicio;

        function __construct(){
            parent::__construct();
            $this->servicio = $this->loadModel("servicios");
        }

        public function index(){
            $this->_view->servicios = $this->GenerarServicio();
            $this->_view->renderizar("index");
        }

        public function GenerarServicio(){
            $idSucursal = $this->servicio->getSucursalId();
            $ser = $this->servicio->getAll($idSucursal['sucursal_ID']);
            $servicios = "";

            foreach($ser as $s){
                $servicios .= '
                <div class="servicio col-md-3">
                        <img src="'.PLANTILLAFOTO.'servicios/'.$s['ser_img'].'" alt="">
                        <h4>'.$s['ser_nombre'].'</h4>
                        <p>'.$s['ser_descripcion'].'</p>
                </div>
                ';
            }

            return $servicios;
        }
    }