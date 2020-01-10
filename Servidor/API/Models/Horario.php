<?php
include_once 'Config/Conexion.php';

    class Horario extends DB{

        /**
        * consulta de la clave primaria del horario de suspencion del semaforo a traves de los datos 
        *
        * @access public
        * @param array $horario arreglo que contiene la hora de inicio de suspencio y inicio del proceso del semaforo
        *               con formato 00:00:00
        * @return $query envia el resultado de la consulta
        */
        function SelectData($horario){
            $query = $this->connect()->prepare('SELECT * FROM horarios_suspension WHERE inicio_suspension_semaforo= :inicio_suspension_semaforo AND inicio_proceso_semaforo= :inicio_proceso_semaforo');
            $query->execute(['inicio_suspension_semaforo' => $horario['inicio_suspension_semaforo'], 'inicio_proceso_semaforo' => $horario['inicio_proceso_semaforo']]);
            return $query;
        }

        /**
        * registro del horario de suspencion del semaforo
        *
        * @access public
        * @param array $horario arreglo que contiene la hora de inicio de suspencio y inicio del proceso del semaforo
        *              con formato 00:00:00
        * @return $query retorna el resultado de la sentencia
        */
        function Insert($horario){
            $query = $this->connect()->prepare('INSERT INTO horarios_suspension (inicio_suspension_semaforo, inicio_proceso_semaforo) VALUES (:inicio_suspension_semaforo, :inicio_proceso_semaforo)');
            $query->execute(['inicio_suspension_semaforo' => $horario['inicio_suspension_semaforo'], 'inicio_proceso_semaforo' => $horario['inicio_proceso_semaforo']]);
            return $query;
        }
    }
?>