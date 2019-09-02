<?php

include_once 'Config/Conexion.php';

class TiempoRojo extends DB{

    function Show(){
        $query = $this->connect()->query('SELECT * FROM tiempos_rojo');
        return $query;
    }

    function SelectData($tiempo_rojo){
        $query = $this->connect()->prepare('SELECT * FROM tiempos_rojo WHERE tiempo_rojo= :tiempo_rojo');
        $query->execute(['tiempo_rojo' => $tiempo_rojo]);
        return $query;
    }

    function Select($id){
        $query = $this->connect()->prepare('SELECT * FROM tiempos_rojo WHERE id= :id');
        $query->execute(['id' => $id]);
        return $query;
    }

    function Insert($item){
        $query = $this->connect()->prepare('INSERT INTO tiempos_rojo (tiempo_rojo) VALUES (:tiempo_rojo)');
        $query->execute(['tiempo_rojo' => $item['tiempo_rojo']]);
        return $query;
    }

    function Update($item,$id){
        $query = $this->connect()->prepare('UPDATE tiempos_rojo SET tiempo_rojo= :tiempo_rojo WHERE id= :id');
        $query->execute(['id' => $id, 'tiempo_rojo' => $item['tiempo_rojo']]);
        return $query;
    }

    function Delete($id){
        $query = $this->connect()->prepare('DELETE FROM tiempos_rojo WHERE id= :id');
        $query->execute(['id' => $id]);
        return $query;
    }
}

?>