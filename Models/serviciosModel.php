<?php
    class serviciosModel extends Model{
        function __construct()
        {
            parent::__construct();
        }

        public function getAll($id){
            $ser = $this->_db->prepare("SELECT s.*
            FROM servicio AS s INNER JOIN servicio_sucursal AS ss ON s.ser_id = ss.servicio_fk
                    INNER JOIN sucursal AS su ON ss.sucursal_fk = su.sucursal_ID
            WHERE su.sucursal_ID = :id");

            $ser->execute(['id' => $id]);
            return $ser->fetchAll();
        }

        public function getSucursalId(){
            $id =  $this->_db->prepare("SELECT sucursal_ID FROM sucursal WHERE activo = :act");
            $id->execute(["act" => 1]);
            return $id->fetch();
        }
    }