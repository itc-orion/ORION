<?php

include_once 'Models/Horario.php';

class HorarioController{

    function All(){
        $horario = new Horario();
        $array = array();
        $array['Horarios'] = array();

        $res= $horario->Show();

        if($res->rowCount()){
            while($row = $res->fetch(PDO::FETCH_ASSOC)){
                $item = array(
                    'id' => (int)$row['id'],
                    'inicio_suspencion' => $row['inicio_suspencion'],
                    'fin_suspencion' => $row['fin_suspencion']
                );

                array_push($array['Horarios'],$row);
            }

            $this->PrintJSON($array);

        }else{
            $this->Error('No hay elementos registrados');
        }
    }

    function Sel($id){
        $horario = new Horario();
        $array = array();
        $array['Horario'] = array();

        $res= $horario->Select($id);

        if($res->rowCount() == 1){
            $row = $res->fetch();
                $item = array(
                    'id' => (int)$row['id'],
                    'inicio_suspencion' => $row['inicio_suspencion'],
                    'fin_suspencion' => $row['fin_suspencion']
                );

                array_push($array['Horario'],$item);

            $this->PrintJSON($array);

        }else{
            $this->Error('No hay elementos registrados');
        }
    }

    function Ins($body){
        $item = json_decode($body, true);
        $horario = new Horario();

        $res= $horario->Insert($item);
        $this->exito('Nuevo horario agregado');
    }

    function Up($body,$id){
        $item = json_decode($body, true);
        $horario = new Horario();

        $res= $horario->Update($item,$id);
        $this->exito('Los datos del horario se actualizaron');
    }

    function Del($id){
        $horario = new Horario();

        $res= $horario->Delete($id);
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