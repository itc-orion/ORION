<?php

include_once 'Config/Conexion.php';

class All extends DB{

    function Show(){
        try{
            $query = $this->connect()->query('SELECT * FROM semaforos_all');
            return $query;
        }catch(PDOException $e){
            header('Content-Type: application/json');
            echo json_encode(array('Mensaje' => "Error connection" . $e->getMessage()));
            http_response_code(405);
        }
    }

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