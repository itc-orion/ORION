<?php

include_once 'Conexion.php';

class Semaforo extends DB{

    function Show(){
        $query = $this->connect()->query('SELECT * FROM semaforos');
        return $query;
    }

    function Select($id){
        $query = $this->connect()->prepare('SELECT * FROM semaforos WHERE id= :id');
        $query->execute(['id' => $id]);
        return $query;
    }

    function SelectData($id){
        $query = $this->connect()->prepare('SELECT * FROM semaforos WHERE id_rango= :id');
        $query->execute(['id' => $id]);
        return $query;
    }
}

?>