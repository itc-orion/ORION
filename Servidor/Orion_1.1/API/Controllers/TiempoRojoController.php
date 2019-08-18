<?php

include_once 'Models/TiempoRojo.php';

class TiempoRojoController{

    function All(){
        $tiempo_rojo = new TiempoRojo();
        $array = array();
        $array['TiemposRojo'] = array();

        $res= $tiempo_rojo->Show();

        if($res->rowCount()){
            while($row = $res->fetch(PDO::FETCH_ASSOC)){
                $item = array(
                    'id' => (int)$row['id'],
                    'tiempo_rojo' => (int)$row['tiempo_rojo']
                );

                array_push($array['TiemposRojo'],$row);
            }

            $this->PrintJSON($array);

        }else{
            $this->Error('No hay elementos registrados');
        }
    }

    function Sel($id){

        $tiempo_rojo = new TiempoRojo();
        $array = array();
        $array['TiempoRojo'] = array();

        $res= $tiempo_rojo->Select($id);

        if($res->rowCount() == 1){
            $row = $res->fetch();
                $item = array(
                    'id' => (int)$row['id'],
                    'tiempo_rojo' => (int)$row['tiempo_rojo']
                );

                array_push($array['TiempoRojo'],$row);

            $this->PrintJSON($array);

        }else{
            $this->Error('No hay elementos registrados');
        }
    }

    function Ins($body){
        $item = json_decode($body, true);
        $tiempo_rojo = new TiempoRojo();

        $res= $tiempo_rojo->Insert($item);
        $this->exito('Nuevo horario agregado');
    }

    function Up($body,$id){
        $item = json_decode($body, true);
        $tiempo_rojo = new TiempoRojo();

        $res= $tiempo_rojo->Update($item,$id);
        $this->exito('Los datos del horario se actualizaron');
    }

    function Del($id){
        $tiempo_rojo = new TiempoRojo();

        $res= $tiempo_rojo->Delete($id);
        $this->exito('horario Eliminado');
    }

    function Exito($mensaje){
        echo json_encode(array('Mensaje' => $mensaje));
    }

    function PrintJSON($array){
        echo json_encode($array);
    }

    function Error($mensaje){
        echo json_encode(array('Mensaje' => $mensaje));
    }
}

?>