<?php
    class homeModel extends Model{
        function __construct()
        {
            parent::__construct();
        }

        public function getStatus($id){
            $result =  $this->_db->prepare('CALL estados_generales()');
            $result->execute();
            return $result->fetch(PDO::FETCH_ASSOC);
        }
    }