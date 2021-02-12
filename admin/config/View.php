<?php

class View{
  private $_controlador;

  public function __construct(Rutas $peticion)
  {
      $this->_controlador = $peticion->getControlador();
  }

  public function renderizar($vista)
  {
    
    $rutaView=ROOT.'Views'.DS.$this->_controlador.DS.$vista.'.phtml';

      if(is_readable($rutaView)){
          include_once ROOT.'Views'.DS.'plantilla'.DS.'header.php';
          // include_once ROOT.'Views'.DS.'plantilla'.DS.'nav.php';
          // include otras rutas
          include_once $rutaView;
          
          include_once ROOT.'Views'.DS.'plantilla'.DS.'footer.php';
      }
      else{
          echo $rutaView;
          throw new Exception('Error de vista: '.$rutaView);
      }


    }

  }