<?php
    include_once 'app/model/model.php';

    class VentaDAO extends Model {
        private $serial;
       
        public function setDetalleventa($idproducto, $cantidad, $valoriva, $valordescuento, $total){
            $this->connect();
            $this->query("INSERT INTO detalleventa (idproducto, idfactura, cantidad, valoriva, valordescuento, total) 
                             values ('".$idproducto."',".$this->serial.",'".$cantidad."','".$valoriva."','".$valordescuento."','".$total."')");
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

        public function setVenta($valortotal, $valordescuentos, $valoriva, $idcliente){
            $this->connect();
            $this->query("INSERT INTO venta (valortotal, valordescuentos, valoriva, idcliente) 
                                 values ('".$valortotal."','".$valordescuentos."','".$valoriva."','".$idcliente."')");
            $consulta="SELECT * FROM venta order by numerofactura desc LIMIT 1";
            $row=mysqli_fetch_array($this->query($consulta));
            $this->serial = $row['numerofactura'];
            $this->terminate();
        }



    }


?>