<?php
include_once 'Config/Conexion.php';

    class TiempoLuces extends DB{

        /**
        * consulta de la clave primaria del tiempo del color de las luces del semaforo
        *
        * @access public
        * @param array $item arreglo que contiene el tiempo del color de las luces del semaforo
        * @return $query envia el resultado de la consulta
        */
        function SelectData($item){
            $query = $this->connect()->prepare('SELECT * FROM tiempos_luces_semaforo WHERE tiempo_verde= :tiempo_verde AND tiempo_amarillo= :tiempo_amarillo AND tiempo_rojo= :tiempo_rojo');
            $query->execute(['tiempo_verde' => $item['tiempo_verde'], 'tiempo_amarillo' => $item['tiempo_amarillo'], 'tiempo_rojo' => $item['tiempo_rojo']]);
            return $query;
        }

        /**
        * registro el tiempo de las luces del semaforo
        *
        * @access public
        * @param array $item arreglo que contiene el tiempo del color de las luces del semaforo
        * @return $query retorna el resultado de la sentencia
        */
        function Insert($item){
            $query = $this->connect()->prepare('INSERT INTO tiempos_luces_semaforo (tiempo_verde, tiempo_amarillo, tiempo_rojo) VALUES (:tiempo_verde, :tiempo_amarillo, :tiempo_rojo)');
            $query->execute(['tiempo_verde' => $item['tiempo_verde'], 'tiempo_amarillo' => $item['tiempo_amarillo'], 'tiempo_rojo' => $item['tiempo_rojo']]);
            return $query;
        }
    }
?>