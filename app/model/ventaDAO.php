<?php
    include_once 'app/model/model.php';

    class VentaDAO extends Model {
        private $serial;
       
        public function setDetalleventa($idproducto, $cantidad, $valoriva, $valordescuento, $total){
            $this->connect();
            $this->query("INSERT INTO detalleventa (idproducto, idfactura, cantidad, valoriva, valordescuento, total) 
                             values ('".$idproducto."','".$this->serial."','".$cantidad."','".$valoriva."','".$valordescuento."','".$total."')");
            $result= $this->query("SELECT p.existencias FROM producto p WHERE p.id=".$idproducto);
            $nuevaCantidad = mysqli_fetch_array($result)['existencias']- $cantidad;
            $this->query("UPDATE producto SET existencias=".$nuevaCantidad);
            $this->terminate();
        }

        public function setVentaPorProducto($arrayDTO){
            for($i=0;$i<count($arrayDTO);$i++) {
                $DTO=$arrayDTO[$i];
                $this->setDetalleventa($DTO->idProducto, $DTO->cantidad, $DTO->valorIva, $DTO->valorDescuento, $DTO->total);
            }
        }

        public function getSerial(){
            $this->connect();
            $result = $this->query("SELECT numerofactura FROM venta ORDER BY numerofactura DESC LIMIT 1");
            $this->terminate();
            if($row = mysqli_fetch_array($result)){
                $this->serial = $row['numerofactura']+1;
            }
        }

        public function setVenta($valortotal, $valordescuentos, $valoriva, $idcliente){
            $this->getSerial();
            $this->connect();
            $this->query("INSERT INTO venta (numerofactura, valortotal, valordescuentos, valoriva, idcliente) 
                                 values ('".$this->serial."','".$valortotal."','".$valordescuentos."','".$valoriva."','".$idcliente."')");
            $this->terminate();
        }



    }


?>