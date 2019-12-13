<?php
include_once 'Config/Conexion.php';

    class TiempoRojo extends DB{

        /**
        * consulta de la clave primaria del tiempo del color rojo en el semaforo
        *
        * @access public
        * @param int $tiempo_rojo valor del tiepo que dura el color rojo del semaforo
        * @return $query envia el resultado de la consulta
        */
        function SelectData($tiempo_rojo){
            $query = $this->connect()->prepare('SELECT * FROM tiempos_rojo WHERE tiempo_rojo= :tiempo_rojo');
            $query->execute(['tiempo_rojo' => $tiempo_rojo]);
            return $query;
        }

        /**
        * registro del color rojo del semaforo
        *
        * @access public
        * @param array $item arreglo que contiene el tiempo del color rojo del semaforo
        * @return $query retorna el resultado de la sentencia
        */
        function Insert($item){
            $query = $this->connect()->prepare('INSERT INTO tiempos_rojo (tiempo_rojo) VALUES (:tiempo_rojo)');
            $query->execute(['tiempo_rojo' => $item['tiempo_rojo']]);
            return $query;
        }
    }
?>