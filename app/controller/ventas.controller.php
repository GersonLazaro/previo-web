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
                $this->view = $this->renderView($this->view, '{{CLIENTES}}', $this->getClientes());
            } else {
                $this->view = $this->renderView($this->view, '{{TABLE}}', '');
            }
            
            $this->showView($this->view);
        }

        public function agregarProductoVenta($id, $cantidad) {
            if(!isset($_SESSION['productos'])) {
                $_SESSION['productos'] = array();
            }
            $producto = new VentaDTO($id, $cantidad);

            array_push($_SESSION['productos'], $producto);
        }

        public function getProductosVenta() {
            $productos = '';
            $totalIva = 0;
            $totalDesc = 0;
            $subtotal = 0;
            $cantidad = 0;
            $total = 0;
            for($i = 0; $i < count($_SESSION['productos']); $i++) {
                $total += $_SESSION['productos'][$i]->total;
                $totalIva += $_SESSION['productos'][$i]->valorIva;
                $totalDesc += $_SESSION['productos'][$i]->valorDescuento;
                $cantidad += $_SESSION['productos'][$i]->cantidad;
                $subtotal += $_SESSION['productos'][$i]->subtotal;
                $productos .= '<tr><td>'.$_SESSION['productos'][$i]->idProducto.'</td><td>'.$_SESSION['productos'][$i]->nombreProducto.'</td><td>'.$_SESSION['productos'][$i]->cantidad.'</td><td>'.$_SESSION['productos'][$i]->precioUnidad.'</td><td>'.$_SESSION['productos'][$i]->subtotal.'</td><td>'.$_SESSION['productos'][$i]->valorDescuento.'</td><td>'.$_SESSION['productos'][$i]->valorIva.'</td><td>'.$_SESSION['productos'][$i]->total.'</td></tr>';
            }
            $productos .= '<tr class="negrilla"><td>Total</td><td></td><td>'.$cantidad.'</td><td></td><td>'.$subtotal.'</td><td>'.$totalDesc.'</td><td>'.$totalIva.'</td><td>'.$total.'</td></tr>';

            return $productos;
        }

        public function getClientes() {
            
            $clienteDAO = new ClienteDAO();
            $clientesDTO = $clienteDAO->getClientes();
            $clientes = '<option value=""></option>';
            for($i = 0; $i < count($clientesDTO); $i++) {
                $clientes .= '<option value="'.$clientesDTO[$i]->id.'">'.$clientesDTO[$i]->nombre." ".$clientesDTO[$i]->apellido.'</option>';
            }
            return $clientes;
        }


        public function guardarVenta($idCliente) {
            $ventaDAO = new VentaDAO();
            $totalIva = 0;
            $totalDesc = 0;
            $total = 0;
            for($i = 0; $i < count($_SESSION['productos']); $i++) {
                $total += $_SESSION['productos'][$i]->total;
                $totalIva += $_SESSION['productos'][$i]->valorIva;
                $totalDesc += $_SESSION['productos'][$i]->valorDescuento;
            }
            $ventaDAO->setVenta($total, $totalIva, $totalDesc, $idCliente);
            $ventaDAO->setVentaPorProducto($_SESSION['productos']);
            session_destroy();
            $this->showView("<script>alert('Venta registrada exitosamente')</script>");
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