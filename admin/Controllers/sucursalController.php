<?php
    class sucursalController extends Controller{
        private $sucursales;

        function __construct()
        {
            parent::__construct();
            $this->sucursales = $this->loadModel("sucursal");
        }

        public function index(){
            $this->_view->suc = $this->generarSucursales();
            $this->_view->renderizar("index");
        }

        public function generarSucursales(){
            $su = $this->sucursales->getAll();
            $suc = "";

            foreach($su AS $s){
                $sucur = json_encode($s);
                $suc .= '
                    <tr>
                        <td>'.$s['sucursal_ID'].'</td>
                        <td>'.$s['sucursal_nombre'].'</td>
                        <td>'.$s['sucursal_direccion'].'</td>
                        <td>'.$s['sucursal_telefono'].'</td>
                        <td>'.$s['sucursal_correo'].'</td>
                        <td class="no-exportar"><button class="btn btn-info editSuc"  data-p=\''.$sucur.'\' data-target="#modalEditarSucursal" data-toggle="modal"><i class="fa fa-pencil-alt"></i></button></td>
                        <td class="no-exportar"><button class="btn btn-danger delSuc"  data-id=\''.$sucur.'\'><i class="fa fa-trash-alt"></i></button></td>
                    </tr>
                ';
            }

            return $suc;
        }

        public function addSucursal(){
            $this->sucursales->add($_POST);
            echo $this->generarSucursales();
        }

        public function updSucursal(){
            $this->sucursales->update($_POST);
            echo $this->generarSucursales();
        }

        public function getSucursales(){
            $sucursales = $this->sucursales->getAll();
            
        }

        public function deleteSucursal(){
            $this->sucursales->delete($this->getTexto("id"));
            echo $this->generarSucursales();
        }
    }