<?php
    class categoriaModel extends Model{
        function __construct()
        {
            parent::__construct();
        }

        public function addCat($datos){
            $this->_db->prepare("INSERT INTO categorias_productos (cat_product_nombre, cat_product_descripcion) VALUES(:nom,:des)")->execute(array(
                "nom" => $datos['nombre'],
                "des" => $datos['descripcion']
            ));
        }

        public function getCat($nom){
            
            $cat = $this->_db->prepare('
                SELECT c.*,COUNT(p.categorias_productos_cat_product_ID) AS cantidad
                FROM categorias_productos AS c LEFT JOIN productos AS p ON c.cat_product_ID = p.categorias_productos_cat_product_ID
                        INNER JOIN proveedores AS pr ON p.proveedores_provee_ID = pr.provee_ID INNER JOIN sucursal AS s ON 
                        pr.sucursal_sucursal_ID = s.sucursal_ID
                WHERE s.sucursal_nombre = :nom
                GROUP BY c.cat_product_ID
            ');

            $cat->execute(['nom' => $nom]);
            return $cat->fetchAll();
        }

        public function getProductos($nom){

            $fila = $this->_db->prepare('
                SELECT p.*,c.*,pr.*,s.*
                FROM categorias_productos AS c LEFT JOIN productos AS p ON c.cat_product_ID = p.categorias_productos_cat_product_ID
                INNER JOIN proveedores AS pr ON p.proveedores_provee_ID = pr.provee_ID INNER JOIN sucursal AS s ON 
                pr.sucursal_sucursal_ID = s.sucursal_ID
                WHERE s.sucursal_nombre = :nom
            ');

            $fila->execute(['nom' => $nom]);
            return $fila->fetchAll();
        }

        public function actualizarCat($d){
            $this->_db->prepare("UPDATE categorias_productos SET cat_product_nombre=:nom, cat_product_descripcion=:des WHERE cat_product_ID = :id")->execute(array(
                "id" => $d['id'],
                "nom" => $d['nombre'],
                "des" => $d['descripcion']
            ));
            
        }

        public function getAllCat(){
            return $this->_db->query("SELECT * FROM categorias_productos")->fetchAll();
        }
    }