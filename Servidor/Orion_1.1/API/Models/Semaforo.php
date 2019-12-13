<?php
include_once 'Config/Conexion.php';

    class Semaforo extends DB{
        
        /**
        * consulta de la clave primaria del semaforo
        *
        * @access public
        * @param int $id clave primaria del rengo vinculado al semaforo
        * @return $query envia el resultado de la consulta
        */
        function SelectData($id){
            $query = $this->connect()->prepare('SELECT * FROM semaforos WHERE id_rango= :id');
            $query->execute(['id' => $id]);
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
            $query = $this->connect()->prepare('INSERT INTO semaforos (nombre, status, tiempo_inicio, id_horario, id_rango, id_tverde, id_tamarillo, id_trojo) VALUES (:nombre, :status, :tiempo_inicio, :id_horario, :id_rango, :id_tverde, :id_tamarillo, :id_trojo)');
            $query->execute(['nombre' => $item['nombre'], 'status' => $item['status'], 'tiempo_inicio' => $item['tiempo_inicio'], 'id_horario' => $item['id_horario'], 'id_rango' => $item['id_rango'], 'id_tverde' => $item['id_tverde'], 'id_tamarillo' => $item['id_tamarillo'], 'id_trojo' => $item['id_trojo']]);
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
            $query = $this->connect()->prepare('UPDATE semaforos SET nombre= :nombre, status= :status, tiempo_inicio= :tiempo_inicio, id_horario= :id_horario, id_tverde= :id_tverde, id_tamarillo= :id_tamarillo, id_trojo= :id_trojo WHERE id= :id');
            $query->execute(['id' => $id, 'nombre' => $item['nombre'], 'status' => $item['status'], 'tiempo_inicio' => $item['tiempo_inicio'], 'id_horario' => $item['id_horario'], 'id_tverde' => $item['id_tverde'], 'id_tamarillo' => $item['id_tamarillo'], 'id_trojo' => $item['id_trojo']]);
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