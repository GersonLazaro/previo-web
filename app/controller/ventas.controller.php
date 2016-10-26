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

            $opciones = '';
            $productoDAO = new ProductoDAO();
            $productos = $productoDAO->getTotalProductos();
            for($i = 0; $i < count($productos); $i++) {
                $opciones .= '<option value='.$productos[$i]->id.'>'.$productos[$i]->nombre.'</option>';
            }
            $this->viewRegistro = $this->renderView($this->viewRegistro, '{{PRODUCTOS}}', $opciones);
            $this->view = $this->renderView($this->view, '{{CONTENT}}', $this->viewRegistro);
            $this->showView($this->view);
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