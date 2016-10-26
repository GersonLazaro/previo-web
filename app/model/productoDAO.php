<?php
    include_once 'app/model/model.php';

    class ProductoDAO extends Model {
        private $serial;

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

        public function getSerial(){
            $this->connect();
            $result = $this->query("SELECT numerofactura FROM venta ORDER BY numerofactura DESC LIMIT 1");
            $this->terminate();
            if($row = mysqli_fetch_array($result)){
                $serial = $row['numerofactura']+1;
            }
        }

        public function setVenta($valortotal, $valordescuentos, $valoriva, $idcliente){
            $this->connect();
            $this->query("INSERT INTO venta (numerofactura, valortotal, valordescuentos, valoriva, idcliente) 
                                 values (".$this->serial.",".$valortotal.",".$valordescuentos.",".$valoriva.",".$idcliente.")");
            $this->terminate();
        }

        public function setDetalleventa($idproducto, $cantidad, $valoriva, $valordescuento, $total){
            $this->connect();
            $this->query("INSERT INTO detalleventa (idproducto, idfactura, cantidad, valoriva, valordescuento, total) 
                             values (".$idproducto.",".$serial.",".$cantidad.",".$valoriva.",".$valordescuento.",".$total.")");
            $nuevaCantidad = $this->query("SELECT p.existencias FROM producto p WHERE p.idproducto=".$idproducto);
            $this->query("UPDATE producto SET existencias=".$nuevaCantidad);
            $this->terminate();
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