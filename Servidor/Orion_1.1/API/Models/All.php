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
            $query = $this->connect()->query('SELECT * FROM semaforos_all');
            return $query;
        }

        /**
        * consulta de un semaforo espesifico
        *
        * realiza una consulta a una vista que cuanta con los datos del semaforo ya estructurados
        *
        * @access public
        * @param int $id la clave primaria del registro del semaforo
        * @return $query envia el resultado de la consulta espesifica
        */
        function Select($id){
            $query = $this->connect()->prepare('SELECT * FROM semaforos_all WHERE id= :id');
            $query->execute(['id' => $id]);
            return $query;
        }
    }
?>