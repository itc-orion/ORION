<?php
include_once 'Config/Conexion.php';

    class Horario extends DB{

        /**
        * consulta de la clave primaria del horario a traves de los datos 
        *
        * @access public
        * @param string $inicio_suspencion,  $fin_suspencion hora de inicio y fin de suspencion del semaforo.
        *               con formato 00:00:00
        * @return $query envia el resultado de la consulta
        */
        function SelectData($inicio_suspencion, $fin_suspencion){
            $query = $this->connect()->prepare('SELECT * FROM horarios WHERE inicio_suspencion= :inicio_suspencion AND fin_suspencion= :fin_suspencion');
            $query->execute(['inicio_suspencion' => $inicio_suspencion, 'fin_suspencion' => $fin_suspencion]);
            return $query;
        }

        /**
        * registro del horario de suspencion del semaforo
        *
        * @access public
        * @param array $horario arreglo que contiene la hora de inicio y fin de suspencion del semaforo
        *              con formato 00:00:00
        * @return $query retorna el resultado de la sentencia
        */
        function Insert($horario){
            $query = $this->connect()->prepare('INSERT INTO horarios (inicio_suspencion, fin_suspencion) VALUES (:inicio_suspencion, :fin_suspencion)');
            $query->execute(['inicio_suspencion' => $horario['inicio_suspencion'], 'fin_suspencion' => $horario['fin_suspencion']]);
            return $query;
        }
    }
?>