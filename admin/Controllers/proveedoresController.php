<?php
    class proveedoresController extends Controller{
        private $provedor;

        function __construct(){
            parent::__construct();
            $this->provedor = $this->loadModel("proveedores");
        }
        
        public function index(){
            
            $this->_view->sucursalProv = $this->generarSucursales();
            $this->_view->datos = $this->generarRegistros();
            $this->_view->renderizar("index");
        }

        #generar sucursal
        public function generarSucursales(){
            $fila = "";
            $datos = $this->provedor->getSucursal();
            foreach($datos AS $d){
                $fila .= '<option value="'.$d['sucursal_ID'].'">'.$d['sucursal_nombre'].'</option>';
            }
            return $fila;
        }

        #generar la tabla de proveedores
        public function generarRegistros(){
            $id = Accesos::getDatos('identificadorSuc');
            $filas = $this->provedor->getProveedores($id);
            $body = '';

            foreach ($filas as $f) {
                $data = json_encode($f);
                $body .= '
                <tr>
                    <td>'.$f['provee_ID'].'</td>
                    <td>'.$f['provee_nombre'].'</td>
                    <td>'.$f['provee_direccion'].'</td>
                    <td>'.$f['provee_telefono'].'</td>
                    
                    <td>
                        <button class="btn btn-info editProv"  data-p=\''.$data.'\' data-target="#ProveedorShowModal" data-toggle="modal"><i class="fa fa-pencil-alt"></i></button>
                        </td>
                    <td>
                        <button type="button" data-i=\''.$data.'\' data-r="'.BASE_URL.'" class="ElimProv btn btn-danger"><span class="fa fa-trash"></span></button>
                    </td>
                </tr>
                ';
            }

            return $body;
        }

        public function add(){
            $datos = array(
                "nombre" => $this->getTexto('nombreProv'),
                "direccion" => $this->getTexto('direccionProv'),
                "telefono" => $this->getTexto('telefonoProv'),
                "sucursal" => $this->getTexto('sucursalProv')
            );
            
            $this->provedor->addProv($datos);
            echo $this->generarRegistros();
        }

        public function update(){
            $datos = array(
                "id" => $this->getTexto('id'),
                "nombre" => $this->getTexto('nombre'),
                "direccion" => $this->getTexto('direccion'),
                "telefono" => $this->getTexto('telefono'),
            );

            $this->provedor->actualizar($datos);
            echo $this->generarRegistros();
        }

        public function eliminar(){
            $id = $this->getTexto("id");
            if($this->provedor->ElimProv($id)){
                echo $this->generarRegistros();
            }else{
                echo "1";
            }
        }
    }