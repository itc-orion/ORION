<?php

include_once 'Config/Conexion.php';

class Rango extends DB{

    function Show(){
        $query = $this->connect()->query('SELECT * FROM rangos');
        return $query;
    }

    function SelectData($longitud, $latitud){
        $query = $this->connect()->prepare('SELECT * FROM rangos WHERE longitud= :longitud AND latitud= :latitud');
        $query->execute(['longitud' => $longitud, 'latitud' => $latitud]);
        return $query;
    }

    function Select($id){
        $query = $this->connect()->prepare('SELECT * FROM rangos WHERE id= :id');
        $query->execute(['id' => $id]);
        return $query;
    }

    function Insert($item){
        $query = $this->connect()->prepare('INSERT INTO rangos (longitud, latitud) VALUES (:longitud, :latitud)');
        $query->execute(['longitud' => $item['longitud'], 'latitud' => $item['latitud']]);
        return $query;
    }

    function Update($item,$id){
        $query = $this->connect()->prepare('UPDATE rangos SET longitud= :longitud, latitud= :latitud WHERE id= :id');
        $query->execute(['id' => $id, 'longitud' => $item['longitud'], 'latitud' => $item['latitud']]);
        return $query;
    }

    function Delete($id){
        $query = $this->connect()->prepare('DELETE FROM rangos WHERE id= :id');
        $query->execute(['id' => $id]);
        return $query;
    }
}

?>