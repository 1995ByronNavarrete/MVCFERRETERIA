<?php
    class homeModel extends Model{
        function __construct()
        {
            parent::__construct();
        }

        public function getAc(){
            return $this->_db->query("SELECT * FROM sucursal WHERE activo = 1")->fetch();
        }

        public function getProductCat($id){
            $product = $this->_db->prepare("SELECT p.*,c.cat_product_nombre,pr.provee_nombre,u.unidad_medida_abreviatura AS uni
            FROM productos AS p INNER JOIN proveedores AS pr ON p.proveedores_provee_ID = pr.provee_ID INNER JOIN sucursal AS s
                    ON s.sucursal_ID = pr.sucursal_sucursal_ID INNER JOIN categorias_productos AS c ON p.categorias_productos_cat_product_ID = c.cat_product_ID
                    INNER JOIN unidad_medida AS u ON u.unidad_medida_id = p.unidad_medida_unidad_medida_id
            WHERE s.activo = 1 && p.categorias_productos_cat_product_ID = :id
            ");

            $product->execute(['id' => $id]);
            return $product->fetchAll();
        }

        public function getCategorias($id){
            $cat = $this->_db->prepare("SELECT c.cat_product_nombre,COUNT(p.categorias_productos_cat_product_ID) AS cantidad, p.categorias_productos_cat_product_ID
            FROM productos AS p INNER JOIN categorias_productos AS c ON p.categorias_productos_cat_product_ID = c.cat_product_ID
                  INNER JOIN proveedores AS pr ON p.proveedores_provee_ID = pr.provee_ID
                  INNER JOIN sucursal AS s ON pr.sucursal_sucursal_ID = s.sucursal_ID
            WHERE	s.sucursal_ID = :id
            GROUP BY p.categorias_productos_cat_product_ID
            ");
            $cat->execute(['id' => $id]);
            return $cat->fetchAll();
        }

        public function getSucursal(){
            return $this->_db->query("SELECT * FROM sucursal")->fetchAll();
        }

        public function get($limit = false){
            if(!$limit){
                return $this->_db->query("SELECT p.*,c.cat_product_nombre,pr.provee_nombre,u.unidad_medida_abreviatura AS uni
                    FROM productos AS p INNER JOIN proveedores AS pr ON p.proveedores_provee_ID = pr.provee_ID INNER JOIN sucursal AS s
                            ON s.sucursal_ID = pr.sucursal_sucursal_ID INNER JOIN categorias_productos AS c ON p.categorias_productos_cat_product_ID = c.cat_product_ID
                            INNER JOIN unidad_medida AS u ON u.unidad_medida_id = p.unidad_medida_unidad_medida_id
                    WHERE s.activo = 1
                ")->fetchAll();
            }else{
                $product = $this->_db->prepare("SELECT p.*,c.cat_product_nombre,pr.provee_nombre,u.unidad_medida_abreviatura AS uni
                    FROM productos AS p INNER JOIN proveedores AS pr ON p.proveedores_provee_ID = pr.provee_ID INNER JOIN sucursal AS s
                            ON s.sucursal_ID = pr.sucursal_sucursal_ID INNER JOIN categorias_productos AS c ON p.categorias_productos_cat_product_ID = c.cat_product_ID
                            INNER JOIN unidad_medida AS u ON u.unidad_medida_id = p.unidad_medida_unidad_medida_id
                    WHERE s.activo = 1 ORDER BY p.product_ID DESC LIMIT 6 
                ");

                $product->execute();
                return $product->fetchAll();
            }
        }

        public function getSucursalA(){
            return $this->_db->query("SELECT * FROM sucursal")->fetchAll();
        }

        public function getSucuralUnica(){
            return $this->_db->query("SELECT * FROM sucursal WHERE activo = 1")->fetch();
        }

        public function cambio($id){
            $this->_db->query("UPDATE sucursal AS s SET s.activo = 0 WHERE s.activo = 1");
            $this->_db->prepare("UPDATE sucursal AS s SET s.activo = 1 WHERE s.sucursal_ID = :id")->execute(['id' => $id]);
        }
    }