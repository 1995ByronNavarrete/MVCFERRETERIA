<?php
    class productosModel extends Model{
        public function __construct(){
            parent::__construct();
        }

        public function getProductos($name){
            $fila = $this->_db->prepare("SELECT p.*,c.cat_product_nombre,pr.provee_nombre,u.unidad_medida_abreviatura AS uni
                FROM productos AS p INNER JOIN proveedores AS pr ON p.proveedores_provee_ID = pr.provee_ID INNER JOIN sucursal AS s
                        ON s.sucursal_ID = pr.sucursal_sucursal_ID INNER JOIN categorias_productos AS c ON p.categorias_productos_cat_product_ID = c.cat_product_ID
                        INNER JOIN unidad_medida AS u ON u.unidad_medida_id = p.unidad_medida_unidad_medida_id
                WHERE s.sucursal_nombre = :nom
            ");

            $fila->execute(['nom' => $name]);
            return $fila->fetchAll();
        }

        public function addProducto($producto){
            $this->_db->prepare("INSERT INTO productos(product_nombre,product_cantidad,product_precio,product_descripcion,product_foto,categorias_productos_cat_product_ID,unidad_medida_unidad_medida_id,proveedores_provee_ID) VALUES(:nom,:can,:pre,:des,:img,:cat,:uni,:prov)")->execute(array(
                "nom" => $producto['nombre'],
                "can" => $producto['cantidad'],
                "pre" => $producto['precio'],
                "des" => $producto['descripcion'],
                "img" => $producto['foto'],
                "cat" => $producto['opcion'],
                "uni" => $producto['unidad'],
                "prov" =>$producto['proveedor']
            ));
        }

        public function updProducto($producto){
            $this->_db->prepare("UPDATE productos set product_nombre = :nom, product_descripcion = :des ,product_precio = :pre, product_foto = :img WHERE product_ID = :id")->execute(array(
                "nom" => $producto['nombre'],
                "pre" => $producto['precio'],
                "des" => $producto['descripcion'],
                "img" => $producto['foto'],
                "id" => $producto['id']
            ));
        }

        public function elim($id){
            $this->_db->prepare("DELETE FROM productos WHERE product_ID = :id")->execute(array("id" => $id));
        }

        public function getProv($id = null){
            if(!$id)
                return $this->_db->query("SELECT * FROM proveedores")->fetchAll();
            else{
                $prov = $this->_db->prepare("SELECT * FROM proveedores WHERE sucursal_sucursal_ID = :id");
                $prov->execute(['id' => $id]);
                return $prov->fetchAll();
            }
        }

        public function getCat(){
            $fila = $this->_db->query("SELECT * FROM categorias_productos")->fetchAll();
            return $fila;
        }

        public function getunidad(){
            $fila = $this->_db->query("SELECT * FROM unidad_medida")->fetchAll();
            return $fila;
        }
        
    }
    ?>

