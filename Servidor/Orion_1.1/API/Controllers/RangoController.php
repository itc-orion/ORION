<?php

include_once 'Models/Rango.php';

class RangoController{

    function All(){
        $rango = new Rango();
        $array = array();
        $array['Rangos'] = array();

        $res= $rango->Show();

        if($res->rowCount()){
            while($row = $res->fetch(PDO::FETCH_ASSOC)){
                $item = array(
                    'id' => (int)$row['id'],
                    'longitud' => (int)$row['longitud'],
                    'latitud' => (int)$row['latitud']
                );

                array_push($array['Rangos'],$row);
            }

            $this->PrintJSON($array);

        }else{
            $this->Error('No hay elementos registrados');
        }
    }

    function Sel($id){

        $rango = new Rango();
        $array = array();
        $array['Rango'] = array();

        $res= $rango->Select($id);

        if($res->rowCount() == 1){
            $row = $res->fetch();
                $item = array(
                    'id' => (int)$row['id'],
                    'longitud' => (int)$row['longitud'],
                    'latitud' => (int)$row['latitud']
                );

                array_push($array['Rango'],$row);

            $this->PrintJSON($array);

        }else{
            $this->Error('No hay elementos registrados');
        }
    }

    function Ins($body){
        $item = json_decode($body, true);
        $rango = new Rango();

        $res= $rango->Insert($item);
        $this->exito('Nuevo horario agregado');
    }

    function Up($body,$id){
        $item = json_decode($body, true);
        $rango = new Rango();

        $res= $rango->Update($item,$di);
        $this->exito('Los datos del horario se actualizaron');
    }

    function Del($id){
        $rango = new Rango();

        $res= $rango->Delete($id);
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