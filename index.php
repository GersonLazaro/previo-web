<?php
    /**
    * Previo II - Programación web
    * @author - Gerson Lázaro <gerson@hackerearth.com>
    * @author - Elizabeth Ramirez <eramirezvillamizar@gmail.com>
    * 1150972 - 1151256
    */

    include_once 'app/router/router.php';

    include_once 'app/controller/controller.php';
    include_once 'app/controller/ventas.controller.php';

    include_once 'app/model/model.php';
    include_once 'app/model/productoDAO.php';
    include_once 'app/model/ventaDTO.php';
    include_once 'app/model/ventaDAO.php';
    include_once 'app/model/productoDTO.php';
    include_once 'app/model/clienteDAO.php';
    include_once 'app/model/clienteDTO.php';

    session_start();
    //Se inicia un enrutador y se enruta la petición al controlador respectivo
    $router = new Router();
    $router->handleRequest();
?>