<?php

include_once 'Config/Conexion.php';

class Horario extends DB{

    function Show(){
        $query = $this->connect()->query('SELECT * FROM horarios');
        return $query;
    }

    function Select($id){
        $query = $this->connect()->prepare('SELECT * FROM horarios WHERE id= :id');
        $query->execute(['id' => $id]);
        return $query;
    }

    function Insert($horario){
        $query = $this->connect()->prepare('INSERT INTO horarios (inicio_suspencion, fin_suspencion) VALUES (:inicio_suspencion, :fin_suspencion)');
        $query->execute(['inicio_suspencion' => $horario[0]['inicio_suspencion'], 'fin_suspencion' => $horario[0]['fin_suspencion']]);
        return $query;
    }

    function Update($horario,$id){
        $query = $this->connect()->prepare('UPDATE horarios SET inicio_suspencion= :inicio, fin_suspencion= :fin_suspencion WHERE id= :id');
        $query->execute(['id' => $id, 'inicio_suspencion' => $horario[0]['inicio_suspencion'], 'fin_suspencion' => $horario[0]['fin_suspencion']]);
        return $query;
    }

    function Delete($id){
        $query = $this->connect()->prepare('DELETE FROM horarios WHERE id= :id');
        $query->execute(['id' => $id]);
        return $query;
    }
}

?>