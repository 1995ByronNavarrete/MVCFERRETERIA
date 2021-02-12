<?php
    class productosController extends Controller{
        private $productos;

        public function __construct(){
            parent::__construct();
            $this->productos = $this->loadModel("productos");
        }

        public function generarUnidadMedida(){
            $fila = "";
            $datos = $this->productos->getunidad();
            foreach($datos AS $d){
                $fila .= '<option value="'.$d['unidad_medida_id'].'">'.$d['unidad_medida_nombre'].'</option>';
            }
            return $fila;
        }

        public function generarProveedor(){
            $fila = "";
            $datos = $this->productos->getProv(Accesos::getDatos('identificadorSuc'));
            foreach($datos AS $d){
                $fila .= '<option value="'.$d['provee_ID'].'">'.$d['provee_nombre'].'</option>';
            }
            return $fila;
        }

        public function generarCategoria(){
            $fila = "";
            $datos = $this->productos->getCat();
            foreach($datos AS $d){
                $fila .= '<option value="'.$d['cat_product_ID'].'">'.$d['cat_product_nombre'].'</option>';
            }
            return $fila;
        }

        public function generarTabla(){
            $fila = $this->productos->getProductos(Accesos::getDatos('nameSucursal'));
            $table = '';

            foreach($fila AS $f){

                $datos = json_encode($f);
                $table .= '
                <tr>
                    <td>'.$f['product_ID'].'</td>
                    <td>'.$f['product_nombre'].'</td>
                    <td>'.$f['product_descripcion'].'</td>
                    <td>'. COR .$f['product_precio'].'</td>
                    <td>'.$f['provee_nombre'].'</td>
                    <td>'.$f['product_cantidad']. ' ' . $f['uni'] .'</td>
                    <td><img src="'.PLANTILLA . "img/productos/". $f['product_foto'] . '" alt="'.$f['prduct_nombre'].'" class="img-fluid w-75"></td>
                    <td><button class="btn btn-info editBoton"  data-p=\''.$datos.'\' data-target="#modalEditar" data-toggle="modal"><i class="fa fa-pencil-alt"></i></button></td>
                    <td><button class="btn btn-danger delBoton"  data-i=\''.$datos.'\' data-d=\''.BASE_URL.'\'><i class="fa fa-trash-alt"></i></button></td>
                </tr>
                ';
            }

            return $table;
        }

        public function index(){
            
            Accesos::acceso('invitado');

            $this->_view->titulo = '
                <h6 class="m-0 font-weight-bold text-primary"><span class="fas fa-table"></span> Información General de los productos</h6>
            ';

            $tabla = $this->generarTabla();

            $this->_view->contenido = $tabla;
            $this->_view->renderizar("index");
        }

        public function edit(){
         
            if(!empty($_FILES['archivo']['name'])){
                $upl = $this->subirImagen($_FILES['archivo'],"Views/plantilla/img/productos/");
                
                if($upl['upload']){
                    $producto = array(
                        "nombre" => $this->getTexto("nombre"),
                        "descripcion" => $this->getTexto("descripcion"),
                        "precio" => $this->getTexto("precio"),
                        "proveedor" => $this->getTexto("proveedor"),
                        "foto" => $upl['nombre'],
                        "id" => $this->getTexto("id")
                    );
                    if($this->getTexto("nomImgAnt") != "default.png"){
                        $this->deleteImg("Views/plantilla/img/productos/",$this->getTexto("nomImgAnt"));
                    }
                    
                    $this->productos->updProducto($producto);
                    echo $this->generarTabla();
                }
            }else{
                $producto = array(
                    "nombre" => $this->getTexto("nombre"),
                    "descripcion" => $this->getTexto("descripcion"),
                    "precio" => $this->getTexto("precio"),
                    "proveedor" => $this->getTexto("proveedor"),
                    "foto" => $this->getTexto("nomImgAnt"),
                    "id" => $this->getTexto("id")
                );

                $this->productos->updProducto($producto);
                echo $this->generarTabla();
            }
           
        }

        public function add(){
            Accesos::acceso("admin");

            if($this->getTexto("add") == "1"){
                $upl = $this->subirImagen($_FILES['archivo'],"Views/plantilla/img/productos/");

                if($upl['upload']){
                    $producto = array(
                        "nombre" => $this->getTexto("nombre"),
                        "descripcion" => $this->getTexto("descripcion"),
                        "precio" => $this->getTexto("precio"),
                        "proveedor" => $this->getTexto("proveedor"),
                        "opcion" => $this->getTexto('opcion'),
                        "cantidad" => $this->getTexto('cantidad'),
                        "unidad" => $this->getTexto('uni'),
                        "foto" => $upl['nombre']
                    );
    
                    $this->productos->addProducto($producto);
                    $this->redireccionar("productos");
                }else{
                    $producto = array(
                        "nombre" => $this->getTexto("nombre"),
                        "descripcion" => $this->getTexto("descripcion"),
                        "precio" => $this->getTexto("precio"),
                        "proveedor" => $this->getTexto("proveedor"),
                        "opcion" => $this->getTexto('opcion'),
                        "cantidad" => $this->getTexto('cantidad'),
                        "unidad" => $this->getTexto('uni'),
                        "foto" => "default.png"
                    );

                    $this->productos->addProducto($producto);
                    $this->redireccionar("productos");
                }
            }

            $this->_view->cat = $this->generarCategoria();
            $this->_view->prov = $this->generarProveedor();
            $this->_view->unid = $this->generarUnidadMedida();
            $this->_view->renderizar("add");
        }

        public function eliminar(){
            $id = $this->getTexto("id");
            $nomImg = $this->getTexto("nomImg");
            
            if($nomImg != "default.png"){
                $this->deleteImg("Views/plantilla/img/productos/",$nomImg);
            }

            $this->productos->elim($id);
            echo $this->generarTabla();
        }

    }