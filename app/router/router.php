<?php
    /**
    * Previo II - Programación web
    * @author - Gerson Lázaro <gerson@hackerearth.com>
    * @author - Elizabeth Ramirez <eramirezvillamizar@gmail.com>
    * 1150972 - 1151256
    * Clase encargada de tomar la petición realizada en el cliente y redirigirla al controlador
    * adecuado para su procesamiento y respuesta.
    */

    class Router {

        //Instancias de los controladores
        private $ventas;
        
        /**
        * Inicialización de los controladores
        */
        public function __construct() {
            $this->ventas = new VentasController();
        }

        /**
        * Toma la petición y procesa la solicitud realizada antes de enrutarla
        */
        public function handleRequest() {
            $mode = '';
            if(isset($_GET['mode'])) {
                $mode = $_GET['mode'];
            } else if (isset($_POST['mode']) ) {
                $mode = $_POST['mode'];
            } else {
                $mode = 'index';
            }

            $this->routeRequest($mode);
        }

        /**
        * Enruta la solicitud al controlador requerido
        */
        public function routeRequest($mode) {
            if($mode == 'index') {
                $this->ventas->showIndex();
            } else if($mode == 'registrarVenta') {
                $this->ventas->registrarVenta();
            } else if($mode == 'listarVentas') {
                $this->ventas->listarVentas();
            }
        }
    }

?>