<?php
    class serviciosController extends Controller{
        private $serviciosModel;

        function __construct()
        {
            parent::__construct();
            $this->serviciosModel = $this->loadModel('servicios');
        }

        public function generarServicios(){
            $tabla = '';
            $servicios = $this->serviciosModel->getServicios(Accesos::getDatos('identificadorSuc'));

            foreach($servicios AS $servicio){
                $servicioData = json_encode($servicio);
                $tabla .= '
                    <tr>
                        <td>'.$servicio['ser_id'].'</td>
                        <td>'.$servicio['ser_nombre'].'</td>
                        <td>'.$servicio['ser_descripcion'].'</td>
                        <td><button class="btn btn-primary editServicio" data-target="#ServiciosShowModal" data-servicio=\''.$servicioData.'\' data-toggle="modal"><span class="fa fa-edit"></span></button></td>
                        <td><button class="btn btn-danger elimServicio" data-id='.$servicio['ser_id'].'><span class="fa fa-trash"></span></button></td>
                    </tr>
                ';
            }
            
            return $tabla;
        }   

        public function index(){

            $this->_view->allServices = $this->generarServicios();
            $this->_view->renderizar('index');
        }

        public function addService(){
            $this->serviciosModel->addSer(
                array(
                    "servicio" => $this->getTexto('servicio'),
                    "descripcion" => $this->getTexto('descripcion'),
                    "foto" => ($this->getTexto('serfoto')) ? $this->getTexto('serfoto') : 'sin foto',
                    "sucursal" => $this->getTexto('sucursal')
                )
            );

            $datos = $this->serviciosModel->getNewSer();
            $this->serviciosModel->addServSucursal($datos[0]['ser_id'],Accesos::getDatos('identificadorSuc'));

            echo $this->generarServicios();
        }

        public function updServicio(){
                $this->serviciosModel->upd(array(
                "id" => $this->getTexto('id'),
                "servicio" =>$this->getTexto('servicio'),
                "descripcion" => $this->getTexto('descripcion')
            ));

            echo $this->generarServicios();
        }

        public function delete(){
            $this->serviciosModel->delSerSuc($this->getTexto('id'));
            $this->serviciosModel->del($this->getTexto('id'));
            echo $this->generarServicios();
        }

        public function cambiarImagen(){
            var_dump($_FILES);
        }
    }