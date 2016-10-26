<?php
    include_once 'app/model/model.php';

    class ProductoDAO extends Model {
        
        public function getProductos() {
            $this->connect();
            $result = $this->query("SELECT p.id, p.nombre, d.suma FROM producto p, 
                                    (SELECT SUM( t.total ) AS suma, t.idproducto FROM detalleventa t GROUP BY t.idproducto)d 
                                        WHERE d.idproducto = p.id ORDER BY d.suma DESC");
            $this->terminate();
            $arreglo = array();
            while($row = mysqli_fetch_array($result)) {
                $DTO = new ProductoDTO($row['id'], $row['nombre'], null, null, null, $row['suma']);
                array_push($arreglo, $DTO);
            }
            return $arreglo;
        }


        public function getProductoPorId($id){
            $this->connect();
            $result = $this->query("SELECT p.existencias, p.nombre, p.tipo, p.precioventa FROM producto p WHERE p.id=".$id);
            $this->terminate();
            $row = mysqli_fetch_array($result);
            $DTO = new ProductoDTO(null, $row['nombre'], $row['tipo'], $row['precioventa'], $row['existencias'], null);
            return $DTO;
        }

        public function getTotalProductos() {
            $this->connect();
            $result = $this->query("SELECT id, nombre, existencias, precioventa, tipo FROM producto");
            $this->terminate();
            $arreglo = array();
            while($row = mysqli_fetch_array($result)) {
                $DTO = new ProductoDTO($row['id'], $row['nombre'], $row['tipo'], $row['precioventa'], $row['existencias'], null);
                array_push($arreglo, $DTO);
            }
            return $arreglo;
        }


    }


?>