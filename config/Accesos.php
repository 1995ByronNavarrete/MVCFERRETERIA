<?php
    class Accesos{
        public static function getDatos($clave){
            if(isset($_SESSION[$clave])) return $_SESSION[$clave];
            else return false;
        }

        public static function setDatos($clave, $valor){
            $_SESSION[$clave] = $valor;
        }

        public static function iniciar(){ session_start(); }

        public static function acceso($rol){
            if(Accesos::getDatos('acceso')){
                if(Accesos::nivel(Accesos::getDatos('rol')) >= Accesos::nivel($rol)){
                    return true;
                }else{
                    header("Location:".BASE_URL.'error/error/503');
                }
            }else{
                header("Location:".BASE_URL.'error/error/504');
            }
        }

        public static function nivel($rol){
            $roles['admin'] = 3;
            $roles['registrador'] = 2;
            $roles['invitado'] = 1;

            if($roles[$rol]) return $roles[$rol];
            else return 0;
        }

        public static function salir(){
            session_destroy();
        }
    }