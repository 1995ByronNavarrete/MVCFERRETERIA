<?php
    class homeModel extends Model{
        function __construct()
        {
            parent::__construct();
        }

        public function getStatus($id){
            $result =  $this->_db->prepare('CALL procedimiento_datos_generales(:id)');
            $result->execute(['id' => $id]);
            return $result->fetch();
        }
    }