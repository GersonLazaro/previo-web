<?php

    /**
    * Previo II - Programación web
    * @author - Gerson Lázaro <gerson@hackerearth.com>
    * @author - Elizabeth Ramirez <eramirezvillamizar@gmail.com>
    * 1150972 - 1151256
    */

    include_once 'app/controller/controller.php';

    class VentasController extends Controller {

        private $view;
        private $viewRegistro;

        public function showIndex() {
            $this->view = $this->getTemplate('main.html');
            $this->view = $this->renderView($this->view, '{{CONTENT}}', $this->getTemplate('home.html'));
            $this->showView($this->view);
        }

        public function listarVentas() {
            $productoDAO = new ProductoDAO();
            $productos = $productoDAO->getProductos();
            $productosView = '';
            for($i = 0; $i < count($productos); $i++) {
                $productosView .= '<tr><td>'.$productos[$i]->id.'</td><td>'.$productos[$i]->nombre.'</td><td>'.$productos[$i]->totalVentas.'</td></tr>';
            }
            $this->view = $this->getTemplate('main.html');
            $this->viewVenta = $this->getTemplate('listarVentas.html');
            $this->view = $this->renderView($this->view, '{{CONTENT}}', $this->viewVenta);
            $this->view = $this->renderView($this->view, '{{CONTENT}}', $productosView);
            //echo $this->viewVenta;
            $this->showView($this->view);
        }

        public function registrarVenta() {
            $this->view = $this->getTemplate('main.html');
            $this->viewRegistro = $this->getTemplate('registrarVenta.html');

            $opciones = '<option value=""></option>';
            $productoDAO = new ProductoDAO();
            $productos = $productoDAO->getTotalProductos();
            for($i = 0; $i < count($productos); $i++) {
                if($productos[$i]->existencias > 0) {
                    $opciones .= '<option value='.$productos[$i]->id.'>'.$productos[$i]->nombre.'</option>';
                }
            }
            $this->viewRegistro = $this->renderView($this->viewRegistro, '{{PRODUCTOS}}', $opciones);
            $this->view = $this->renderView($this->view, '{{CONTENT}}', $this->viewRegistro);
            if(isset($_SESSION['productos']) && count($_SESSION['productos']) > 0) {
                $this->view = $this->renderView($this->view, '{{TABLE}}', $this->getTemplate('productosVenta.html'));
                $this->view = $this->renderView($this->view, '{{CONTENT_TABLE}}', $this->getProductosVenta());
            } else {
                $this->view = $this->renderView($this->view, '{{TABLE}}', '');
            }
            
            $this->showView($this->view);
        }

        public function agregarProductoVenta($id, $cantidad) {
            if(!isset($_SESSION['productos'])) {
                $_SESSION['productos'] = array();
            }
            $producto = new ProductoPorVentaDTO($id, $cantidad);

            array_push($_SESSION['productos'], $producto);
        }

        public function getProductosVenta() {
            $productos = '';
            for($i = 0; $i < count($_SESSION['productos']); $i++) {
                $productos .= '<tr><td>'.$_SESSION['productos'][$i]->idProducto.'</td><td>'.$_SESSION['productos'][$i]->nombreProducto.'</td><td>'.$_SESSION['productos'][$i]->cantidad.'</td><td>'.$_SESSION['productos'][$i]->precioUnidad.'</td><td>'.$_SESSION['productos'][$i]->subtotal.'</td><td>'.$_SESSION['productos'][$i]->valorDescuento.'</td><td>'.$_SESSION['productos'][$i]->valorIva.'</td><td>'.$_SESSION['productos'][$i]->total.'</td></tr>';
            }
            return $productos;
        }

        public function guardarVenta() {
        }


        /**
        * AJAX
        */
        public function obtenerInventario($id) {
            $productoDAO = new ProductoDAO();
            $producto = $productoDAO->getProductoPorId($id);
            echo json_encode($producto);
        }


    }






?>