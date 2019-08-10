<?php

include_once 'Config/Conexion.php';

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

    function Insert($item){
        $query = $this->connect()->prepare('INSERT INTO semaforos (nombre, status, tiempo_inicio, id_horario, id_rango, id_tverde, id_tamarillo, id_trojo) VALUES (:nombre, :status, :tiempo_inicio, :id_horario, :id_rango, :id_tverde, :id_tamarillo, :id_trojo)');
        $query->execute(['nombre' => $item[0]['nombre'], 'status' => $item[0]['status'], 'tiempo_inicio' => $item[0]['tiempo_inicio'], 'id_horario' => $item[0]['id_horario'], 'id_rango' => $item[0]['id_rango'], 'id_tverde' => $item[0]['id_tverde'], 'id_tamarillo' => $item[0]['id_tamarillo'], 'id_trojo' => $item[0]['id_trojo']]);
        return $query;
    }

    function Update($item,$id){
        $query = $this->connect()->prepare('UPDATE semaforos SET nombre= :nombre, status= :status, tiempo_inicio= :tiempo_inicio, id_horario= :id_horario, id_rango= :id_rango, id_tverde= :id_tverde, id_tamarillo= :id_tamarillo, id_trojo= :id_trojo WHERE id= :id');
        $query->execute(['id' => $id, 'nombre' => $item[0]['nombre'], 'status' => $item[0]['status'], 'tiempo_inicio' => $item[0]['tiempo_inicio'], 'id_horario' => $item[0]['id_horario'], 'id_rango' => $item[0]['id_rango'], 'id_tverde' => $item[0]['id_tverde'], 'id_tamarillo' => $item[0]['id_tamarillo'], 'id_trojo' => $item[0]['id_trojo']]);
        return $query;
    }

    function Delete($id){
        $query = $this->connect()->prepare('DELETE FROM semaforos WHERE id= :id');
        $query->execute(['id' => $id]);
        return $query;
    }
}

?>