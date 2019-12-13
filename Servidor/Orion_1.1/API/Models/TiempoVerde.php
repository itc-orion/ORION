<?php
include_once 'Config/Conexion.php';

    class TiempoVerde extends DB{

        /**
        * consulta de la clave primaria del tiempo del color verde en el semaforo
        *
        * @access public
        * @param int $tiempo_verde valor del tiepo que dura el color verde del semaforo
        * @return $query envia el resultado de la consulta
        */
        function SelectData($tiempo_verde){
            $query = $this->connect()->prepare('SELECT * FROM tiempos_verde WHERE tiempo_verde= :tiempo_verde');
            $query->execute(['tiempo_verde' => $tiempo_verde]);
            return $query;
        }

        /**
        * registro del color verde del semaforo
        *
        * @access public
        * @param array $item arreglo que contiene el tiempo del color verde del semaforo
        * @return $query retorna el resultado de la sentencia
        */
        function Insert($item){
            $query = $this->connect()->prepare('INSERT INTO Tiempos_verde (tiempo_verde) VALUES (:tiempo_verde)');
            $query->execute(['tiempo_verde' => $item['tiempo_verde']]);
            return $query;
        }
    }
?>