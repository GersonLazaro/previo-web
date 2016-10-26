<?php

    class ProductoDTO {
        public $id;
        public $nombre;
        public $tipo;
        public $precioVenta;
        public $existencias;
        public $totalVentas;

        public function __construct($id, $nombre, $tipo, $precioVenta, $existencias, $totalVentas ) {
            $this->id = $id;
            $this->nombre = $nombre;
            $this->tipo = $tipo;
            $this->precioVenta = $precioVenta;
            $this->existencias = $existencias;
            $this->totalVentas = $totalVentas;
        }
    }

?>