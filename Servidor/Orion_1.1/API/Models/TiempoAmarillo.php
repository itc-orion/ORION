<?php
include_once 'Config/Conexion.php';

    class TiempoAmarillo extends DB{

        /**
        * consulta de la clave primaria del tiempo del color amarillo en el semaforo
        *
        * @access public
        * @param int $tiempo_amarillo valor del tiepo que dura el color amarillo del semaforo
        * @return $query envia el resultado de la consulta
        */
        function SelectData($tiempo_amarillo){
            $query = $this->connect()->prepare('SELECT * FROM tiempos_amarillo WHERE tiempo_amarillo= :tiempo_amarillo');
            $query->execute(['tiempo_amarillo' => $tiempo_amarillo]);
            return $query;
        }

        /**
        * registro del color amarillo del semaforo
        *
        * @access public
        * @param array $item arreglo que contiene el tiempo del color amarillo del semaforo
        * @return $query retorna el resultado de la sentencia
        */
        function Insert($item){
            $query = $this->connect()->prepare('INSERT INTO tiempos_amarillo (tiempo_amarillo) VALUES (:tiempo_amarillo)');
            $query->execute(['tiempo_amarillo' => $item['tiempo_amarillo']]);
            return $query;
        }
    }
?>