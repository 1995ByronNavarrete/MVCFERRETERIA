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
            $user = $this->_db->prepare("SELECT a.*,r.*
            FROM admin AS a INNER JOIN admin_sucursal AS ad ON a.admin_ID = ad.fk_admin
                    INNER JOIN sucursal AS s ON s.sucursal_ID = ad.fk_sucursal
                    INNER JOIN roles AS r ON a.roles_rol_ID = r.rol_ID
            WHERE	s.sucursal_ID = :suc AND admin_usuario = :user");

            $user->execute([
                "suc" => $suc,
                "user" => $use
            ]);

            return $user->fetch();
        }
    }