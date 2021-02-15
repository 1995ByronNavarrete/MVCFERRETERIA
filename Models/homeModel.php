<?php
    class homeModel extends Model{
        function __construct()
        {
            parent::__construct();
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
                    WHERE s.activo = 1 LIMIT 4 
                ");

                $product->execute(['lim' => $limit]);
                return $product->fetchAll();
            }
        }

        public function getSucursalA(){
            return $this->_db->query("SELECT * FROM sucursal")->fetchAll();
        }

        public function getSucuralUnica(){
            return $this->_db->query("SELECT * FROM sucursal WHERE activo = 1")->fetch();
        }
    }