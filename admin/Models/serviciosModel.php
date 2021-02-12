<?php
    class serviciosModel extends Model{
        function __construct()
        {
            parent::__construct();
        }

        public function getServicios($id_sucursal){
            $ser =  $this->_db->prepare('SELECT s.*,su.*
            FROM servicio AS s INNER JOIN servicio_sucursal AS ss ON s.ser_id = ss.servicio_fk
                 INNER JOIN sucursal AS su ON su.sucursal_ID = ss.sucursal_fk
            WHERE su.sucursal_ID = :id');
            $ser->execute(['id' => $id_sucursal]);
            return $ser->fetchAll();
        }

        public function addSer($ser){
            $this->_db->prepare('INSERT INTO servicio(ser_nombre,ser_descripcion,ser_img) VALUES(:servi,:descrip,:img)')->execute(
                array(
                    "servi" => $ser['servicio'],
                    "descrip" => $ser['descripcion'],
                    "img" => $ser['foto']
                )
            );
        }

        public function upd($datos){
            $this->_db->prepare('UPDATE servicio SET ser_nombre = :ser, ser_descripcion = :descr WHERE ser_id = :id')->execute(array(
                "id" => $datos['id'],
                "ser" => $datos['servicio'],
                "descr" => $datos['descripcion']
            ));
        }

        public function del($id){
            $this->_db->prepare('DELETE FROM servicio WHERE ser_id=:id')->execute(array("id" => $id));
        }

        public function delSerSuc($id){
            $this->_db->prepare('DELETE FROM servicio_sucursal WHERE servicio_fk = :id')->execute(array("id" => $id));
        }

        public function getNewSer(){
            return $this->_db->query('SELECT ser_id FROM servicio ORDER BY ser_id DESC LIMIT 1')->fetchAll();
        }

        public function addServSucursal($id, $sucursal){
            $this->_db->prepare("INSERT INTO servicio_sucursal(servicio_fk,sucursal_fk) VALUES(:sa,:ss)")->execute([
                "sa" => $id,
                "ss" => $sucursal
            ]);
        }
    }