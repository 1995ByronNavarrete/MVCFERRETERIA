<?php

class categoriaController extends Controller{
    private $catMod;

    function __construct(){
        parent::__construct();
        $this->catMod = $this->loadModel("categoria");
    }

    public function generarListadoCategoria(){
        $lista = '';
        $categorias = $this->catMod->getCat(Accesos::getDatos('nameSucursal'));

        foreach($categorias AS $categoria){
            $lista .= '
                <li class="border-bottom p-1"><a href="#" class="text-decoration-none filtrar" data-filter=".'.$categoria['cat_product_nombre'].'">'.$categoria['cat_product_nombre']. " (".$categoria['cantidad'].")" .'</a></li>
            ';
        }

        return $lista;
    }

    public function generarTargetas(){
        $produc = '';
        $productos = $this->catMod->getProductos(Accesos::getDatos('nameSucursal'));

        foreach($productos AS $prod){
            $produc .= '
                <div class="border m-4 rounded col-md-3 p-2 '.$prod['cat_product_nombre'].' bg-white">
                    <img src="'. PLANTILLA . 'img/productos/'.$prod['product_foto'].'" class="img-fluid border rounded">
                    <div class="contenido">
                        <h6><b>Nombre: </b>'.$prod['product_nombre'].'</h6>
                        <h6><b>Descripcion: </b>'. substr($prod['product_descripcion'],0,8) . "..." .'</h6>
                        <h6><b>Precio: </b> C$ '.$prod['product_precio'].'</h6>
                        <button class="btn btn-info"><span class="fa fa-eye"></span> ver</button>
                    </div>
                </div>
            ';
        }

        return $produc;
    }

    public function index(){
        $this->_view->lista = $this->generarListadoCategoria();
        $this->_view->productos = $this->generarTargetas();
        $this->_view->renderizar('index');
    }

    public function addCategoria(){
        Accesos::acceso('admin');
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            $datos = array(
                "nombre" => $this->getTexto("catNombre"),
                "descripcion" => $this->getTexto("catDescripcion")
            );
            
            $this->catMod->addCat($datos);
            $this->redireccionar('categoria/showAll');
        }else $this->_view->renderizar('addCategoria');
    }

    public function showAll(){
        $this->_view->contenido = $this->generarCategorias();
        $this->_view->renderizar('showAll');
    }

    public function generarCategorias(){
        $fila = $this->catMod->getAllCat();
        $table = '';

        foreach($fila AS $f){

            $datos = json_encode($f);
            $table .= '
            <tr>
                <td>'.$f['cat_product_ID'].'</td>
                <td>'.$f['cat_product_nombre'].'</td>
                <td>'.$f['cat_product_descripcion'].'</td>
                <td><button class="btn btn-info edtCat"  data-p=\''.$datos.'\' data-target="#CategoriaShowModal" data-toggle="modal"><i class="fa fa-pencil-alt"></i></button></td>
                <td><button class="btn btn-danger delCat"  data-del=\''.$datos.'\' data-d=\''.BASE_URL.'\'><i class="fa fa-trash-alt"></i></button></td>
            </tr>
            ';
        }

        return $table;
    }

    public function actualizar(){
        $this->catMod->actualizarCat($_POST);

        echo $this->generarCategorias();
    }

    public function delete(){
        $this->catMod->del($this->getTexto('id'));
        echo $this->generarCategorias();
    }
}