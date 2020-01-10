<?php
include_once 'Config/Conexion.php';

    class Area extends DB{

        /**
        * consulta de la clave primaria del rango a traves de los datos
        *
        * @access public
        * @param int $id es la clave del semaforo relacinado
        * @return $query envia el resultado de la consulta
        */
        function SelectData($id){
            $query = $this->connect()->prepare('SELECT * FROM areas_geografica WHERE id_semaforo= :id');
            $query->execute(['id' => $id]);
            return $query;
        }

        /**
        * registro del rango del semaforo
        *
        * @access public
        * @param int,array $id clave del semaforo relacinado y $area en formato json el area geografica del semaforo
        * @return $query retorna el resultado de la sentencia
        */
        function Insert($id, $area){
            $query = $this->connect()->prepare('INSERT INTO areas_geografica (id_semaforo, archivo_json) VALUES (:id, :area)');
            $query->execute(['id' => $id, 'area' => $area]);
            return $query;
        }

        /**
        * registro del rango del semaforo
        *
        * @access public
        * @param int,array $id clave del semaforo relacinado y $area en formato json el area geografica del semaforo
        * @return $query retorna el resultado de la sentencia
        */
        function Update($id, $area){
            $query = $this->connect()->prepare('UPDATE areas_geografica SET id_semaforo= :id, archivo_json= :area WHERE id_semaforo= :id');
            $query->execute(['id' => $id, 'area' => $area]);
            return $query;
        }

        /**
        * eliminacion del rango  del registro del semaforo
        *
        * @access public
        * @param int $id clave del registro del area geografica del semaforo
        * @return $query retorna el resultado de la sentencia
        */
        function Delete($id){
            $query = $this->connect()->prepare('DELETE FROM areas_geografica WHERE id_semaforo= :id');
            $query->execute(['id' => $id]);
            return $query;
        }
    }
?>