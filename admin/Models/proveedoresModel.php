<?php
    class proveedoresModel extends Model{
        public function __construct(){
            parent::__construct();
        }
        
        public function getProveedores($id = null){
            if(!$id) 
                return $prov = $this->_db->query("SELECT p.* FROM proveedores AS p")->fetchAll();
            else{
                $prov = $this->_db->prepare('SELECT p.* FROM proveedores AS p WHERE sucursal_sucursal_ID = :id');
                $prov->execute(['id' => $id]);
                return $prov->fetchAll();
            }

           
        }

        public function getSucursal($id = null){
            if(!$id) 
                return $this->_db->query('SELECT * FROM sucursal')->fetchAll();
            else{
                $sucursal = $this->_db->prepare('SELECT * FROM sucursal WHERE sucursal_ID = :id');
                $sucursal->execute(['id' => $id]);
                return $sucursal->fetch();
            }

        }
        
        public function addProv(array $d){
            $this->_db->prepare("INSERT INTO proveedores(provee_nombre,provee_direccion,provee_telefono,sucursal_sucursal_ID) VALUES(:nom,:dir,:tel,:idS)")->execute(array(
                "nom" => $d["nombre"],
                "dir" => $d["direccion"],
                "tel" => $d["telefono"],
                "idS" => $d["sucursal"]
            ));
        }

        public function actualizar(array $datos){
            $this->_db->prepare('UPDATE proveedores SET provee_nombre = :nom, provee_direccion = :dir, provee_telefono = :tel WHERE provee_ID = :id')->execute(array(
                "id" => $datos['id'],
                "nom" => $datos['nombre'],
                "dir" => $datos['direccion'],
                "tel" => $datos['telefono'],
            ));
        }

        public function ElimProv($id){
            return $this->_db->prepare("DELETE FROM proveedores WHERE provee_ID = :id")->execute(array(
                "id" => $id
            ));
        }
    }