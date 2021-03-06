<?php
    class usuarioModel extends Model{
        public function __construct(){
            parent::__construct();
        }
        
        public function getUsuario($nom)
        {
            $reg = $this->_db->prepare("SELECT * FROM admin WHERE admin_usuario = :nom");
            $reg->execute(['nom' => $nom]);
            return $reg->fetchAll();
        }

        public function getCorreo($cor)
        {
            $reg = $this->_db->prepare("SELECT * FROM admin WHERE admin_correo = :cor");
            $reg->execute(['cor' => $cor]);
            return $reg->fetchAll();
        }

        public function getRol(){
            $fila = $this->_db->query("SELECT * FROM roles WHERE rol_ID <> 1")->fetchAll();
            return $fila;
        }

        public function agregarUsuario(array $datos, $sucursal)
        {
            $this->_db->prepare("INSERT INTO admin(admin_nombre, admin_apellido, admin_usuario, admin_direccion, admin_telefono, admin_correo, admin_pass, roles_rol_ID,sucursal_sucursal_ID) VALUES (:nom,:ape,:nUs,:dir,:tel,:cor,:pas,:rol,:ssI)")->execute([
                "nom" => $datos['nomTra'],
                "ape" => $datos['apeTra'],
                "nUs" => $datos['nUsTra'],
                "cor" => $datos['corTra'],
                "pas" => $datos['conTra'],
                "rol" => $datos['rolTra'],
                "dir" => $datos['dirTra'],
                "tel" => $datos['telTra'],
                "ssI" => $sucursal  
            ]);
        }

        public function upd(array $datos){
            $this->_db->prepare('UPDATE admin SET admin_nombre=:nom, admin_apellido=:ape, admin_usuario=:nUs, admin_correo=:cor, roles_rol_ID=:rol, admin_direccion=:dir, admin_telefono=:tel WHERE admin_ID = :id')->execute([
                "id"  => $datos['idTra'],
                "nom" => $datos['nomTra'],
                "ape" => $datos['apeTra'],
                "nUs" => $datos['nUsTra'],
                "cor" => $datos['corTra'],
                "rol" => $datos['rolTra'],
                "dir" => $datos['dirTra'],
                "tel" => $datos['telTra']
            ]);
            
            return $datos;
        }

        public function getTrabajadores($id_sucursal)
        {
            $tra =  $this->_db->prepare("SELECT a.*,s.*,r.*
            FROM admin AS a INNER JOIN sucursal AS s ON a.sucursal_sucursal_ID = s.sucursal_ID
                    INNER JOIN roles AS r ON a.roles_rol_ID = r.rol_ID
            WHERE a.sucursal_sucursal_ID = :id AND r.rol_ID <> 1");
            $tra->execute(['id' => $id_sucursal]);
            return $tra->fetchAll(PDO::FETCH_OBJ);
        }


        public function elimTra($elim){
            $this->_db->prepare("DELETE FROM admin WHERE admin_ID = :id")->execute(['id' => $elim]);
        }

        public function getNewTra(){
            return $this->_db->query('SELECT admin_ID FROM admin ORDER BY admin_ID DESC LIMIT 1')->fetchAll();
        }
      
    }