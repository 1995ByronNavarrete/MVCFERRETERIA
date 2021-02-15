<?php
    class homeController extends Controller{

        private $homeModel;

        public function __construct(){
            parent::__construct();
            $this->homeModel = $this->loadModel('home');
        }

        public function index(){
            $this->_view->productos = $this->generarProductos();
            $this->_view->sucursales = $this->generarSucursales();
            $this->_view->renderizar("index");
        }

        public function getSucursalActual(){
            $sucursales = $this->homeModel->getSucursalA();
            echo json_encode($sucursales);
        }

        public function generarProductos(){
            $template = '';
            $datos = $this->homeModel->get(true);

            foreach($datos AS $d){
                $template .='
                <div class="col-sm-3">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="'. PLANTILLAFOTO .'productos/'.$d['product_foto'].'" alt="" />
                                <h2>C$ '.$d['product_precio'].'</h2>
                                <p>'.$d['product_descripcion'].'</p>';
                
                if(Accesos::getDatos('acceso'))
                    $template.= '<button type="button" class="btn btn-default add-a-proforma add" marcador="'.$d['product_ID'].'"><i class="fa fa-shopping-cart"></i>Añadir a proforma</a>';
                else
                    $template.= '<button type="button" class="btn btn-default add-a-proforma loginEntrar"><i class="fa fa-shopping-cart"></i>Añadir a proforma</a>';
                

                $template .='</div>
                        </div>
                        <div class="detalle_product">
                            <ul class="nav nav-pills nav-justified">
                                <li><a href="'. BASE_URL .'producto/showProducto/'.$d['product_ID'].'"><i class="fa fa-plus-square"></i>Ver detalle de productos</a></li>
                            </ul>
                        </div>
                    </div>
                </div>';
            }

            return $template;
        }

        public function generarSucursales(){
           $tem = '';
           $opcSucursal = $this->homeModel->getSucursal();
            
           foreach($opcSucursal AS $suc){
               $tem .= '<option value="'.$suc['sucursal_ID'].'">'.$suc['sucursal_nombre'].'</option>';
           }

           return $tem;
        }

        public function getSuc(){
            echo json_encode($this->homeModel->getSucuralUnica());
        }
    }