<?php
include_once 'Config/Conexion.php';

    class Semaforo extends DB{
        
        /**
        * consulta de la clave primaria del semaforo
        *
        * @access public
        * @param array $item arreglo que contiene la longitud y latitud del semaforo
        * @return $query envia el resultado de la consulta
        */
        function SelectData($item){
            $query = $this->connect()->prepare('SELECT * FROM semaforos WHERE longitud= :longitud AND latitud= :latitud');
            $query->execute(['longitud' => $item['longitud'], 'latitud' => $item['latitud']]);
            return $query;
        }

        /**
        * registro del semaforo
        *
        * @access public
        * @param array $item arreglo que contiene los datos y claves viculadas al semaforo para su registro
        * @return $query retorna el resultado de la sentencia
        */
        function Insert($item){
            $query = $this->connect()->prepare('INSERT INTO semaforos (nombre, estado_semaforo, tiempo_inicio, longitud, latitud, id_horario, id_luces) VALUES (:nombre, :estado_semaforo, :tiempo_inicio, :longitud, :latitud, :id_horario, :id_luces)');
            $query->execute(['nombre' => $item['nombre'], 'estado_semaforo' => $item['estado_semaforo'], 'tiempo_inicio' => $item['tiempo_inicio'],  'longitud' => $item['longitud'], 'latitud' => $item['latitud'], 'id_horario' => $item['id_horario'], 'id_luces' => $item['id_luces']]);
            return $query;
        }

        /**
        * actualizacion de los datos del semaforo
        *
        * @access public
        * @param array,int $item arreglo que contiene los datos y claves viculadas al semaforo para su actualizacion, 
        *                   $id clave primaria del semaforo
        * @return $query retorna el resultado de la sentencia
        */
        function Update($item,$id){
            $query = $this->connect()->prepare('UPDATE semaforos SET nombre= :nombre, estado_semaforo= :estado_semaforo, tiempo_inicio= :tiempo_inicio, longitud= :longitud, latitud= :latitud, id_horario= :id_horario, id_luces= :id_luces WHERE id= :id');
            $query->execute(['id' => $id, 'nombre' => $item['nombre'], 'estado_semaforo' => $item['estado_semaforo'], 'tiempo_inicio' => $item['tiempo_inicio'], 'longitud' => $item['longitud'], 'latitud' => $item['latitud'], 'id_horario' => $item['id_horario'], 'id_luces' => $item['id_luces']]);
            return $query;
        }

        /**
        * eliminacion del registro del semaforo
        *
        * @access public
        * @param int $id clave primaria del registro del semaforo
        * @return $query retorna el resultado de la sentencia
        */
        function Delete($id){
            $query = $this->connect()->prepare('DELETE FROM semaforos WHERE id= :id');
            $query->execute(['id' => $id]);
            return $query;
        }
    }
?>