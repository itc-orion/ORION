<?php
include_once 'Config/Conexion.php';

    class All extends DB{

        /**
        * consulta de todos los registros de semaforos existentes
        *
        * realiza una consulta a una vista que cuanta con los datos del semaforo ya estructurados
        *
        * @access public
        * @return $query envia el resultado de la consulta general
        */
        function Show(){
            $query = $this->connect()->query('SELECT * FROM semaforos_full');
            return $query;
        }

        /**
        * consulta de un semaforo espesifico
        *
        * realiza una consulta a una vista que cuanta con los datos del semaforo ya estructurados
        *
        * @access public
        * @param array $item arreglo que contiene la longitud y latitud del semaforo
        * @return $query envia el resultado de la consulta espesifica
        */
        function Select($item){
            $query = $this->connect()->prepare('SELECT * FROM semaforos_full WHERE longitud= :longitud AND latitud= :latitud');
            $query->execute(['longitud' => $item['longitud'], 'latitud' => $item['latitud']]);
            return $query;
        }
    }
?>