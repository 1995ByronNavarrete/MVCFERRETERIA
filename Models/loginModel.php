<?php
    class loginModel extends Model{
        function __construct(){
            parent::__construct();
        }

        public function getCliente($cli){
            $cliente = $this->_db->prepare("SELECT * FROM cliente WHERE cliente_username = :user");
            $cliente->execute(['user' => $cli['loginClienteUser']]);
            return $cliente->fetch();
        }
    }