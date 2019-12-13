<?php
include_once 'Config/Conexion.php';

    class Rango extends DB{

        /**
        * consulta de la clave primaria del rango a traves de los datos
        *
        * @access public
        * @param int $longitud, $latitud datos de la geolocalizacion del semaforo
        * @return $query envia el resultado de la consulta
        */
        function SelectData($longitud, $latitud){
            $query = $this->connect()->prepare('SELECT * FROM rangos WHERE longitud= :longitud AND latitud= :latitud');
            $query->execute(['longitud' => $longitud, 'latitud' => $latitud]);
            return $query;
        }

        /**
        * registro del rango del semaforo
        *
        * @access public
        * @param array $item arreglo que contiene la longitud y latitud del semaforo en decimales
        * @return $query retorna el resultado de la sentencia
        */
        function Insert($item){
            $query = $this->connect()->prepare('INSERT INTO rangos (longitud, latitud) VALUES (:longitud, :latitud)');
            $query->execute(['longitud' => $item['longitud'], 'latitud' => $item['latitud']]);
            return $query;
        }

        /**
        * eliminacion del rango  del registro del semaforo
        *
        * @access public
        * @param int $id clave del registro del rengo del semaforo
        * @return $query retorna el resultado de la sentencia
        */
        function Delete($id){
            $query = $this->connect()->prepare('DELETE FROM rangos WHERE id= :id');
            $query->execute(['id' => $id]);
            return $query;
        }
    }
?>