<?php
    class clienteController extends Controller{
        private $clientes;

        function __construct()
        {
            parent::__construct();
            $this->clientes = $this->loadModel("cliente");
        }

        public function index(){
            $this->_view->clientes = $this->generarClientes();
            $this->_view->renderizar("index");
        }

        public function generarClientes(){
            $clientes = $this->clientes->get();
            $row = "";
            foreach($clientes as $r){
                $row.= "
                    <tr>
                        <td>".$r['cliente_cedula']."</td>
                        <td>".$r['cliente_nombres']."</td>
                        <td>".$r['cliente_apellidos']."</td>
                        <td>".$r['cliente_telefono']."</td>
                        <td>".$r['cliente_direccion']."</td>
                        <td>".$r['cliente_correo']."</td>
                    </tr>
                ";
            }
            return $row;
        }

    }