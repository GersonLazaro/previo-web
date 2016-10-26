<?php
    include_once 'app/model/model.php';

    class ProductoPorVentaDAO extends Model {
        private $serial;

        public function setNumeroFactura($serial){
            $this->serial = $serial;
        }

       
        public function setDetalleventa($idproducto, $cantidad, $valoriva, $valordescuento, $total){
            $this->connect();
            $this->query("INSERT INTO detalleventa (idproducto, idfactura, cantidad, valoriva, valordescuento, total) 
                             values (".$idproducto.",".$this->serial.",".$cantidad.",".$valoriva.",".$valordescuento.",".$total.")");
            $nuevaCantidad = $this->query("SELECT p.existencias FROM producto p WHERE p.idproducto=".$idproducto);
            $this->query("UPDATE producto SET existencias=".$nuevaCantidad);
            $this->terminate();
        }

        public function setVentaPorProducto($arrayDTO){
            for($i=0;$i<count($arrayDTO);$i++) {
                $DTO=$array[$i];
                $this->setDetalleventa($DTO['idProducto'], $DTO['cantidad'], $DTO['valorIva'], $DTO['valorDescuento'], $DTO['total']);
            }
        }


    }


?>