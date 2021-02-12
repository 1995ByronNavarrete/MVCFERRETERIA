<?php

class errorController extends Controller{
    function __construct(){
        parent::__construct();
    }

    public function index(){
        
    }

    public function error($error){
        if($error == 503) $this->_view->mensaje = '<div class="d-flex justify-content-center align-items-center flex-column" style="height:50vh"><h1 class="text text-danger text-center">No tiene suficientes privilegios</h1><p><a href="'.BASE_URL.'index" class="btn btn-danger">Volver</a></p></div>';
        else if($error == 504) $this->_view->mensaje = '<div><h3 class="text text-danger">Debe Ingresar al sistema</h3></div>';
        else $this->_view->mensaje = '<div><h3 class="text text-danger">Error Desconocido</h3></div>';

        $this->_view->renderizar("index");
    }
}