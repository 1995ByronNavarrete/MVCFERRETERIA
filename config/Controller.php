<?php

abstract class Controller
{
    protected $_view;

    public function __construct()
    {
        $this->_view = new View(new Rutas());
    }

    abstract public function index();

    protected function loadModel($modelo)
    {
        $modelo=$modelo.'Model';
        $rutaModelo=ROOT.'Models'.DS.$modelo.'.php';
        if(is_readable($rutaModelo))
        {
            require_once $rutaModelo;
            $modelo=new $modelo;
            return $modelo;
        }
        else
        {
            throw new Exception('Error en el modelo');
        }
    }

    protected function getTexto($clave)
    {
        if(isset($_POST[$clave]) && !empty($_POST[$clave]))
        {
            $_POST[$clave]=htmlspecialchars($_POST[$clave],ENT_QUOTES);
            return $_POST[$clave];
        }
        else
            return '';
    }

    protected function redireccionar($direccion){
        header("Location:".BASE_URL.$direccion);
    }

    protected function subirImagen($file, $ruta){

        if(isset($file) || !empty($file['name'])){
            if($file['type'] == "image/jpeg" || $file['type'] == "image/jpg" ||  $file['type'] == "image/png"
                || $file['type'] == "image/gif"){
                    $tipo = substr($file['type'],6);
                    $nomFoto = mt_rand(0,900) . substr($file['name'],0,2) . "_" . mt_rand(0,900) . "." . $tipo;

                    list($Ancho,$Alto) = getimagesize($file['tmp_name']);
                    
                    switch($tipo){
                        case 'jpeg' : $origen = imagecreatefromjpeg($file['tmp_name']); break;
                        case 'jpg' : $origen = imagecreatefromjpeg($file['tmp_name']); break;
                        case 'png' : $origen = imagecreatefrompng($file['tmp_name']); break;
                        case 'gif' : $origen = imagecreatefromgif($file['tmp_name']); break;
                    }

                    $destino = imagecreatetruecolor(1024,768);
                    imagecopyresized($destino,$origen,0,0,0,0,1024,768,$Ancho,$Alto);

                    switch($tipo){
                        case 'jpeg': imagejpeg($destino, $file['tmp_name']); break;
                        case 'jpg' : imagejpeg($destino, $file['tmp_name']); break;
                        case 'png' : imagepng($destino, $file['tmp_name']); break;
                        case 'gif' : imagegif($destino, $file['tmp_name']); break;
                    }

                    move_uploaded_file(
                        $file['tmp_name'],
                        $ruta . $nomFoto
                    );
                    
                    return array("upload" => true, "nombre" => $nomFoto);
            }else  return array("upload" => false, "nombre" => "");
        }else return array("upload" => false, "nombre" => "", "msj" => "Error debe subir una imagen con un formato valido (JPEG/JPG/PNG/GIF)");

    }

    protected function deleteImg($ruta, $nombre){
        unlink($ruta . $nombre);
    }
}