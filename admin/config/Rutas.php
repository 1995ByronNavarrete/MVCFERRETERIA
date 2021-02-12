<?php

class Rutas
{
    private $_controlador;
    private $_metodo;
    private $_argumentos;
    
    public function __construct()
    {
        if(isset($_GET['url'])){
            $url=filter_input(INPUT_GET,'url',FILTER_SANITIZE_URL);// ELIMINA CARACTERES ESPECIALES
            
             $url=explode('/',$url);  // ARREGLO A PARTIR DE /
             
            $this->_controlador=strtolower(array_shift($url));  //  QUITA UN ELEMENTO DE ARREGLO
            $this->_metodo=strtolower(array_shift($url));   //  QUITA UN ELEMENTO DE ARREGLO
            $this->_argumentos=$url;  // EL RESTO SON ARGUMENTOS
        }

        if(!$this->_controlador){
            $this->_controlador=DEFAULT_CONTROLLER;
        }
        if(!$this->_metodo)
        {
            $this->_metodo='index';
        }
        if(!isset($this->_argumentos)){
            $this->_argumentos= array();
        }
    }

    public function run(){

        $rutaControlador=ROOT.'Controllers'.DS.$this->_controlador.'Controller.php';
        $controller=$this->_controlador.'Controller';
        $metodo=$this->_metodo;
        $args=$this->_argumentos;
        if(is_readable($rutaControlador)){
            require_once $rutaControlador;
            $controller= new $controller;
            if(is_callable(array($controller,$metodo))){
                $metodo=$this->_metodo;
            }
            else{
                $metodo='index';
            }
            if(isset($args)){
                call_user_func_array(array($controller,$metodo),$args); //  LAMA A LA FUNCION DEL CONTROLADOR CON ARGUMENTOS

            }
            else{
                call_user_func_array(array($controller,$metodo));  //  LAMA A LA FUNCION DEL CONTROLADOR SIN ARGUMENTOS
            }
        }
        else{

           throw new Exception("No encontrado".$rutaControlador);
        }
    }

    public function getControlador()
    {
        return $this->_controlador;
    }
    
    public function getMetodo()
    {
        return $this->_metodo;
    }

    public function getArgs()
    {
        return $this->_argumentos;
    }


}