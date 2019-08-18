<?php

include_once 'Models/TiempoVerde.php';

class TiempoVerdeController{

    function All(){
        $tiempo_verde = new TiempoVerde();
        $array = array();
        $array['TiemposVerde'] = array();

        $res= $tiempo_verde->Show();

        if($res->rowCount()){
            while($row = $res->fetch(PDO::FETCH_ASSOC)){
                $item = array(
                    'id' => (int)$row['id'],
                    'tiempo_verde' => (int)$row['tiempo_verde']
                );

                array_push($array['TiemposVerde'],$row);
            }

            $this->PrintJSON($array);

        }else{
            $this->Error('No hay elementos registrados');
        }
    }

    function Sel($id){

        $tiempo_verde = new TiempoVerde();
        $array = array();
        $array['TiempoVerde'] = array();

        $res= $tiempo_verde->Select($id);

        if($res->rowCount() == 1){
            $row = $res->fetch();
                $item = array(
                    'id' => (int)$row['id'],
                    'tiempo_verde' => (int)$row['tiempo_verde']
                );

                array_push($array['TiempoVerde'],$row);

            $this->PrintJSON($array);

        }else{
            $this->Error('No hay elementos registrados');
        }
    }

    function Ins($body){
        $item = json_decode($body, true);
        $tiempo_verde = new TiempoVerde();

        $res= $tiempo_verde->Insert($item);
        $this->exito('Nuevo horario agregado');
    }

    function Up($body,$id){
        $item = json_decode($body, true);
        $tiempo_verde = new TiempoVerde();

        $res= $tiempo_verde->Update($item,$id);
        $this->exito('Los datos del horario se actualizaron');
    }

    function Del($id){
        $array = json_decode($body, true);
        $id = $array[0]['id'];
        $tiempo_verde = new TiempoVerde();

        $res= $tiempo_verde->Delete($id);
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