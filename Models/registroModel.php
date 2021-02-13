<?php
    class registroModel extends Model{
        function __construct()
        {
            parent::__construct();
        }

        public function getSucursal(){
            return $this->_db->query("SELECT sucursal_id FROM sucursal WHERE activo = 1")->fetch();
        }

        public function addCliente($d, $suc){
            $hash = password_hash($d['createPassword'],PASSWORD_DEFAULT,['cost' => 10]);
            $cleinte = $this->_db->prepare("INSERT INTO cliente(cliente_cedula,cliente_nombres,cliente_apellidos,cliente_username,cliente_telefono,cliente_direccion,cliente_correo,cliente_password,fk_sucursal_cliente) VALUES(:ced,:nom,:ape,:usN,:tel,:dir,:cor,:pas,:fsc)")->execute(array(
                "ced" => $d['createCedula'],
                "nom" => $d['createNombres'],
                "ape" => $d['createApellidos'],
                "usN" => $d['createUsuario'],
                "tel" => $d['createTelefono'],
                "dir" => $d['createDireccion'],
                "cor" => $d['createCorreo'],
                "pas" => $hash,
                "fsc" => $suc
            ));
        }

        public function buscarReg($buscar,$tipo){
            $sql = '';
            if($tipo == 'correo') $sql = "SELECT c.* FROM cliente AS c WHERE c.cliente_correo = :b ";
            else if($tipo == 'cedula') $sql = "SELECT c.* FROM cliente AS c WHERE c.cliente_cedula = :b ";
            else if($tipo == 'telefono') $sql = "SELECT c.* FROM cliente AS c WHERE c.cliente_telefono = :b ";
            else $sql = "SELECT c.* FROM cliente AS c WHERE c.cliente_username = :b ";

            $encontrado = $this->_db->prepare($sql);
            $encontrado->execute([":b" => $buscar]);
            
            return $encontrado->fetch();
        }
    }