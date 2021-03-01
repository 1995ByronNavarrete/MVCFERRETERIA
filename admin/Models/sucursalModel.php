<?php
    class sucursalModel extends Model{
        function __construct()
        {
            parent::__construct();
        }

        public function getAll(){
            return $this->_db->query("SELECT * FROM sucursal")->fetchAll();
        }

        public function delete($id){
            $elim = $this->_db->prepare("DELETE FROM sucursal WHERE sucursal_ID = :id");
            $elim->execute(["id" => $id]);
        }

        public function add($d){
            $new = $this->_db->prepare("INSERT INTO sucursal(sucursal_nombre,sucursal_telefono,sucursal_correo,sucursal_direccion) VALUES(:nom,:tel,:cor,:dir)");
            $new->execute(array(
                "nom" => $d['nombreSuc'],
                "tel" => $d['telefonoSuc'],
                "cor" => $d['correoSuc'],
                "dir" => $d['direccionSuc']
            ));
        }

        public function update($d){
            $actualizar = $this->_db->prepare("UPDATE sucursal SET sucursal_nombre=:nom,sucursal_telefono=:tel,sucursal_correo=:cor,sucursal_direccion=:dir WHERE sucursal_ID = :id");
            $actualizar->execute(array(
                "id" =>  $d['idSucE'],
                "nom" => $d['nombreSucE'],
                "tel" => $d['telefonoSucE'],
                "cor" => $d['correoSucE'],
                "dir" => $d['direccionSucE']
            ));
        }
    }