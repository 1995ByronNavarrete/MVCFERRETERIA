<?php
    class productoController extends Controller{
        private $modelProduct;

        function __construct(){
            parent::__construct();
            $this->modelProduct = $this->loadModel("producto");
        }

        public function generarProductos(){
            $template = "";
            $datos = $this->modelProduct->get();
            echo json_encode($datos);
        }

        public function generarDetalle($id){
            $detalle = $this->modelProduct->getOneProduct($id);
            $template = '';
            $template .= '
            <div class="col-sm-5">
                <div class="img_producto">
                    <img src="'.PLANTILLAFOTO.'productos/'.$detalle['product_foto'].'" alt="" />
                </div>
                </div>
                <div class="col-sm-7">
                    <div class="informacion_producto">
                        
                        <h3>Nombre: '.$detalle['product_nombre'].'</h3>
                        <h4>IDENTIFICADOR: '.$detalle['product_ID'].'</h4>
                        
                        <span>
                            <span>C$ '.$detalle['product_precio'].'</span>';
                if(Accesos::getDatos('acceso')){
                    $template .= '
                            <button type="button" class="btn btn-fefault proforma add"  marcador="'.$detalle['product_ID'].'">
                                <i class="fa fa-shopping-cart"></i>
                                Añadir
                            </button>';
                }else{
                    $template .= '
                            <button type="button" class="btn btn-fefault loginEntrar proforma">
                                <i class="fa fa-shopping-cart"></i>
                                Añadir
                            </button>';
                }
                
                $template .= '  
                        </span>               
                        <p><b>Marca:</b> Truper</p>
                        <p><b>Categoria:</b> '.$detalle['cat_product_nombre'].'</p>
                        <p><b>Descripcion:</b> '.$detalle['product_descripcion'].'</p>
                        
                    </div>
                </div>
            </div>
            ';

            return $template;
        }

        public function categorias(){
            $template = '
                <div class="col-sm-3">
                    <div class="left-sidebar">
                        <div class="brands_products">
                            <h2>Categorias</h2>
                            <div class="brands-name">
                                <ul class="nav nav-pills nav-stacked">
                                    <li><a href="#"> <span class="pull-right">(50)</span>Acne</a></li>
                                    <li><a href="#"> <span class="pull-right">(56)</span>Grüne Erde</a></li>
                                    <li><a href="#"> <span class="pull-right">(27)</span>Albiro</a></li>
                                    <li><a href="#"> <span class="pull-right">(32)</span>Ronhill</a></li>
                                    <li><a href="#"> <span class="pull-right">(5)</span>Oddmolly</a></li>
                                    <li><a href="#"> <span class="pull-right">(9)</span>Boudestijn</a></li>
                                    <li><a href="#"> <span class="pull-right">(4)</span>Rösch creative culture</a></li>
                                </ul>
                            </div>
                        </div>
                    
                        <div class="brands_products">
                            <h2>Marcas</h2>
                            <div class="brands-name">
                                <ul class="nav nav-pills nav-stacked">
                                    <li><a href="#"> <span class="pull-right">(50)</span>Acne</a></li>
                                    <li><a href="#"> <span class="pull-right">(56)</span>Grüne Erde</a></li>
                                    <li><a href="#"> <span class="pull-right">(27)</span>Albiro</a></li>
                                    <li><a href="#"> <span class="pull-right">(32)</span>Ronhill</a></li>
                                    <li><a href="#"> <span class="pull-right">(5)</span>Oddmolly</a></li>
                                    <li><a href="#"> <span class="pull-right">(9)</span>Boudestijn</a></li>
                                    <li><a href="#"> <span class="pull-right">(4)</span>Rösch creative culture</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            '; 

            return $template;
        }

        public function index() {
            $this->_view->renderizar('index');
        }

        public function showProducto($id){
            $this->_view->detalle = $this->generarDetalle($id);
            $this->_view->recomendacion = $this->recomendados();
            $this->_view->categorias = $this->categorias();
            $this->_view->renderizar('showProducto');   
        }

        public function recomendados(){
            $template = '';
            $recom = $this->modelProduct->get(true);
            foreach($recom AS $rec){
                $template .= '
                <div class="col-sm-3">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <img src="'.PLANTILLAFOTO.'productos/'.$rec['product_foto'].'" alt="" />
                                <h2>C$ '.$rec['product_precio'].'</h2>'; 
                                
                            if(Accesos::getDatos('acceso'))                               
                                $template .='<button type="button" class="btn btn-default add-a-proforma add"  marcador="'.$rec['product_ID'].'"><i class="fa fa-shopping-cart"></i>Añadir a proforma</button>';
                            else
                            $template .='<button type="button" class="btn btn-default add-a-proforma loginEntrar"  marcador="'.$rec['product_ID'].'"><i class="fa fa-shopping-cart"></i>Añadir a proforma</button>';
                            
                            $template .='
                            </div>
                            <div class="choose">
                                <ul class="nav nav-pills nav-justified">
                                    <li><a href="'.BASE_URL.'producto/showProducto/'.$rec['product_ID'].'"><i class="fa fa-plus-square"></i>Ver detalle de productos</a></li> 
                                </ul>                                    
                            </div>
                        </div>
                    </div>
                </div>
                ';
            }

            return $template;
        }

        public function save(){
            $this->modelProduct->saveAll($_POST);
        }
    }