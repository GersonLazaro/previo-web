<?php
    include_once 'app/model/model.php';

    class ProductoDAO extends Model {
        
        public function getClientes(){
            $this->connect();
            $result = $this->query("SELECT id, nombre, apellido FROM cliente");
            $this->terminate();
            $arreglo = array();
            while($row = mysqli_fetch_array($result)) {
                $DTO = new ClienteDTO($row['id'], $row['nombre'], $row['apellido']);
                array_push($arreglo, $DTO);
            }
        }

    }

?>