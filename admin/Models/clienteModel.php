<?php
    class clienteModel extends Model{
        function __construct()
        {
            parent::__construct();
        }

        public function get(){
            return $this->_db->query("SELECT c.*
            FROM cliente AS c INNER JOIN sucursal AS s ON c.fk_sucursal_cliente = s.sucursal_ID
            WHERE s.activo = 1")->fetchAll();
        }
    }