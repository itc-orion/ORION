<?php

include_once 'Models/Horario.php';

class HorarioController{

    function All(){
        $horario = new Horario();
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
        
        if(!$res){
            $this->Exito("Error al Crear horario");
        }else{
            $this->Error("Horario creado correctamente");
        }
    }

    function Up($body,$id){
        $item = json_decode($body, true);
        $horario = new Horario();

        $res= $horario->Update($item,$id);
        
        if(!$res){
            $this->Exito("Error al actualizar horario");
        }else{
            $this->Error("Horario actulizado correctamente");
        }
    }

    function Del($id){
        $horario = new Horario();

        $res= $horario->Delete($id);
        
        if(!$res){
            $this->Exito("Error al eliminar horario");
        }else{
            $this->Error("Horario eliminado correctamente");
        }
    }

    function Exito($mensaje){
        header('Content-Type: application/json');
        echo json_encode(array('Mensaje' => $mensaje));
        http_response_code(200);
    }

    function PrintJSON($array){
        header('Content-Type: application/json');
        echo json_encode($array,JSON_UNESCAPED_UNICODE);
        http_response_code(200);
    }

    function Error($mensaje){
        header('Content-Type: application/json');
        echo json_encode(array('Mensaje' => $mensaje));
        http_response_code(405);
    }
}

?>