<?php

    class ProductoPorVentaDTO {
        public $idProducto;
        public $nombreProducto;
        public $cantidad;
        public $precioUnidad;
        public $subtotal;
        public $valorDescuento;
        public $valorIva;
        public $total;


        public function __construct($id, $cantidad) {
            $productoDAO = new ProductoDAO();
            $productoDTO = $productoDAO->getProductoPorId($id);


            $this->idProducto = $id;
            $this->nombreProducto = $productoDTO->nombre;
            $this->cantidad = $cantidad;
            $this->precioUnidad = $productoDTO->precioVenta;
            $this->subtotal = $productoDTO->precioVenta * $cantidad;
            $iva = 0; $desc = 0;
            if($productoDTO->tipo == 'Electrodomesticos') {
                $iva = 0.10;
                $desc = 0.05;
            } else if($productoDTO->tipo == 'Medicamentos') {
                $iva = 0.04;
                $desc = 0.10;
            } else if($productoDTO->tipo == 'Frutas y Verduras') {
                $iva = 0;
                $desc = 0.10;
            } else if($productoDTO->tipo == 'Vestir') {
                $iva = 0.08;
                $desc = 0;
            } else if($productoDTO->tipo == 'Bebidas Alcoholicas y cigarrillos') {
                $iva = 0.20;
                $desc = 0;
            }

            $this->valorDescuento = $this->subtotal * $desc;
            $this->valorIva = ($this->subtotal - $this->valorDescuento) * $iva;
            $this->total = $this->subtotal - $this->valorDescuento + $this->valorIva;
        }
    }
?>