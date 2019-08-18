<?php

include_once 'Models/TiempoAmarillo.php';

class TiempoAmarilloController{

    function All(){
        $tiempo_amarillo = new TiempoAmarillo();
        $array = array();
        $array['TiemposAmarillo'] = array();

        $res= $tiempo_amarillo->Show();

        if($res->rowCount()){
            while($row = $res->fetch(PDO::FETCH_ASSOC)){
                $item = array(
                    'id' => (int)$row['id'],
                    'tiempo_amarillo' => (int)$row['tiempo_amarillo']
                );

                array_push($array['TiemposAmarillo'],$row);
            }

            $this->PrintJSON($array);

        }else{
            $this->Error('No hay elementos registrados');
        }
    }

    function Sel($id){
        $tiempo_amarillo = new TiempoAmarillo();
        $array = array();
        $array['TiempoAmarillo'] = array();

        $res= $tiempo_amarillo->Select($id);

        if($res->rowCount() == 1){
            $row = $res->fetch();
                $item = array(
                    'id' => (int)$row['id'],
                    'tiempo_amarillo' => (int)$row['tiempo_amarillo']
                );

                array_push($array['TiempoAmarillo'],$row);

            $this->PrintJSON($array);

        }else{
            $this->Error('No hay elementos registrados');
        }
    }

    function Ins($body){
        $item = json_decode($body, true);
        $tiempo_amarillo = new TiempoAmarillo();

        $res= $tiempo_amarillo->Insert($item);
        $this->exito('Nuevo horario agregado');
    }

    function Up($body,$id){
        $item = json_decode($body, true);
        $tiempo_amarillo = new TiempoAmarillo();

        $res= $tiempo_amarillo->Update($item,$id);
        $this->exito('Los datos del horario se actualizaron');
    }

    function Del($id){
        $tiempo_amarillo = new TiempoAmarillo();

        $res= $tiempo_amarillo->Delete($id);
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