<?php

include_once 'Models/Semaforo.php';

class SemaforoController{

    function All(){
        $semaforo = new Semaforo();
        $array = array();
        $array['Semaforos']= array();

        $res= $semaforo->Show();

        if($res->rowCount()){
            while($row = $res->fetch(PDO::FETCH_ASSOC)){
                $item = array(
                    'id' => (int)$row['id'],
                    'nombre' => $row['nombre'],
                    'status' => (boolean)$row['status'],
                    'tiempo_inicio' => (int)$row['tiempo_inicio'],
                    'id_horario' => (int)$row['id_horario'],
                    'id_rango' => (int)$row['id_rango'],
                    'id_tverde' => (int)$row['id_tverde'],
                    'id_tamarillo' => (int)$row['id_tamarillo'],
                    'id_trojo' => (int)$row['id_trojo']
                );

                array_push($array['Semaforos'],$item);
            }

            $this->PrintJSON($array);

        }else{
            $this->Error('No hay elementos registrados');
        }
    }

    function Sel($id){

        $semaforo = new Semaforo();
        $array = array();
        $array['Semaforo'] = array();

        $res= $semaforo->Select($id);

        if($res->rowCount() == 1){
            $row = $res->fetch();
                $item = array(
                    'id' => (int)$row['id'],
                    'nombre' => $row['nombre'],
                    'status' => (boolean)$row['status'],
                    'tiempo_inicio' => (int)$row['tiempo_inicio'],
                    'id_horario' => (int)$row['id_horario'],
                    'id_rango' => (int)$row['id_rango'],
                    'id_tverde' => (int)$row['id_tverde'],
                    'id_tamarillo' => (int)$row['id_tamarillo'],
                    'id_trojo' => (int)$row['id_trojo']
                );

                array_push($array['Semaforo'],$item);

            $this->PrintJSON($array);

        }else{
            $this->Error('No hay elementos registrados');
        }
    }

    function Ins($body){
        $item = json_decode($body, true);
        $semaforo = new Semaforo();

        $res= $semaforo->Insert($item);
        
        if(!$res){
            $this->Exito("Error al Crear semaforo");
        }else{
            $this->Error("Semaforo creado correctamente");
        }
    }

    function Up($body,$id){
        $item = json_decode($body, true);
        $semaforo = new Semaforo();

        $res= $semaforo->Update($item,$id);
        
        if(!$res){
            $this->Exito("Error al actualizar semaforo");
        }else{
            $this->Error("Semaforo actulizado correctamente");
        }
    }

    function Del($id){
        $semaforo = new Semaforo();

        $res= $semaforo->Delete($id);
        
        if(!$res){
            $this->Exito("Error al eliminar semaforo");
        }else{
            $this->Error("Semaforo eliminado correctamente");
        }
    }

    function Exito($mensaje){
        header('Content-Type: application/json');
        echo json_encode(array('Mensaje' => $mensaje));
    }

    function PrintJSON($array){
        header('Content-Type: application/json');
        echo json_encode($array);
    }

    function Error($mensaje){
        header('Content-Type: application/json');
        echo json_encode(array('Mensaje' => $mensaje));
    }
}

?>