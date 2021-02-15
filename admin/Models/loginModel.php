<?php
    class loginModel extends Model{
        function __construct()
        {
            parent::__construct();
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

        public function getUsuario($use, $suc){
            $user = $this->_db->prepare("SELECT a.*,r.*,s.*
            FROM admin AS a INNER JOIN roles AS r ON a.roles_rol_ID = r.rol_ID
                    INNER JOIN sucursal AS s ON a.sucursal_sucursal_ID = s.sucursal_ID 
            WHERE	a.sucursal_sucursal_ID = :suc AND a.admin_usuario = :user");

            $user->execute([
                "suc" => $suc,
                "user" => $use
            ]);

            return $user->fetch();
        }
    }