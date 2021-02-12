<?php
    class registroController extends Controller{
        private $modelReg;

        function __construct()
        {
            parent::__construct();
            // $this->modelReg = $this->loadModel("registro");
        }

        public function index(){
            $this->_view->renderizar("index");
        }
    }