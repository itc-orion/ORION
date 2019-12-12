<?php

include_once 'Conexion.php';

class All extends DB{

    function Select($id){
        $query = $this->connect()->prepare('SELECT * FROM semaforos_all WHERE id= :id');
        $query->execute(['id' => $id]);
        return $query;
    }

    function SelectSocket($id){
        $query = $this->connect()->prepare('SELECT tiempo_inicio, tiempo_verde, tiempo_amarillo, tiempo_rojo FROM semaforos_all WHERE id= :id');
        $query->execute(['id' => $id]);
        return $query;
    }
}

?>