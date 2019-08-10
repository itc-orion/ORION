<?php

include_once 'Config/Conexion.php';

class TiempoVerde extends DB{

    function Show(){
        $query = $this->connect()->query('SELECT * FROM Tiempos_verde');
        return $query;
    }

    function Select($id){
        $query = $this->connect()->prepare('SELECT * FROM Tiempos_verde WHERE id= :id');
        $query->execute(['id' => $id]);
        return $query;
    }

    function Insert($item){
        $query = $this->connect()->prepare('INSERT INTO Tiempos_verde (tiempo_verde) VALUES (:tiempo_verde)');
        $query->execute(['tiempo_verde' => $item[0]['tiempo_verde']]);
        return $query;
    }

    function Update($item,$id){
        $query = $this->connect()->prepare('UPDATE Tiempos_verde SET tiempo_verde= :tiempo_verde WHERE id= :id');
        $query->execute(['id' => $id, 'tiempo_verde' => $item[0]['tiempo_verde']]);
        return $query;
    }

    function Delete($id){
        $query = $this->connect()->prepare('DELETE FROM Tiempos_verde WHERE id= :id');
        $query->execute(['id' => $id]);
        return $query;
    }
}

?>