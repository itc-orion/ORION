<?php

include_once 'Config/Conexion.php';

class TiempoAmarillo extends DB{

    function Show(){
        $query = $this->connect()->query('SELECT * FROM tiempos_amarillo');
        return $query;
    }

    function SelectData($tiempo_amarillo){
        $query = $this->connect()->prepare('SELECT * FROM tiempos_amarillo WHERE tiempo_amarillo= :tiempo_amarillo');
        $query->execute(['tiempo_amarillo' => $tiempo_amarillo]);
        return $query;
    }

    function Select($id){
        $query = $this->connect()->prepare('SELECT * FROM tiempos_amarillo WHERE id= :id');
        $query->execute(['id' => $id]);
        return $query;
    }

    function Insert($item){
        $query = $this->connect()->prepare('INSERT INTO tiempos_amarillo (tiempo_amarillo) VALUES (:tiempo_amarillo)');
        $query->execute(['tiempo_amarillo' => $item['tiempo_amarillo']]);
        return $query;
    }

    function Update($item,$id){
        $query = $this->connect()->prepare('UPDATE tiempos_amarillo SET tiempo_amarillo= :tiempo_amarillo WHERE id= :id');
        $query->execute(['id' => $id, 'tiempo_amarillo' => $item['tiempo_amarillo']]);
        return $query;
    }

    function Delete($id){
        $query = $this->connect()->prepare('DELETE FROM tiempos_amarillo WHERE id= :id');
        $query->execute(['id' => $id]);
        return $query;
    }
}

?>