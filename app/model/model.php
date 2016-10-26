<?php
    /**
    * Previo II - Programación web
    * @author - Gerson Lázaro <gerson@hackerearth.com> Elizabeth Ramírez <eramirezvillamizar@gmail.com>
    * 1150972-1151256
    *
    * Clase abstracta generica utilitaria con las funciones comunes para la conexión a base de datos.
    * Cada DAO extiende de esta clase. 
    */

    abstract class model {
        
        private $connection;
        private $databaseHost = 'sandbox2.ufps.edu.co';
        private $databaseUsername = 'proyectoweb';
        private $databasePassword = 'proyectoweb';
        private $databaseName = 'inventario';

        /**
        * Realiza una conexión a la base de datos
        */
        public function connect() {
            $this->connection = mysqli_connect($this->databaseHost, $this->databaseUsername, $this->databasePassword, $this->databaseName) or die(("Error " . mysqli_error($connect)));
        }

        /**
        * Envia una consulta a la base de datos (Puede ser una consulta de cualquier tipo: SELECT, UPDATE, INSERT, DELETE)
        * @param $sql - Consulta a realizar
        * @return resultado de la consulta
        */
        public function query($sql){
            return mysqli_query($this->connection,$sql);
        }

        /**
        * Cierra la conexión con la base de datos
        */
        public function terminate(){
            mysqli_close($this->connection);
        }

    }