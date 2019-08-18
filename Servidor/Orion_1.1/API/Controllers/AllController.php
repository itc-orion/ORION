<?php

include_once 'Models/All.php';

class AllController{

    function All(){
        $semaforo_all = new All();
        $array = array();
        $array['SemaforosAll'] = array();

        $res= $semaforo_all->Show();
        if($res->rowCount()){
            while($row = $res->fetch(PDO::FETCH_ASSOC)){
                $item = array(
                    'id' => (int)$row['id'],
                    'nombre' => $row['nombre'],
                    'status' => $row['status'],
                    'longitud' => (int)$row['longitud'],
                    'latitud' => (int)$row['latitud'],
                    'tiempo_inicio' => (int)$row['tiempo_inicio'],
                    'inicio_suspencion' => $row['inicio_suspencion'],
                    'fin_suspencion' => $row['fin_suspencion'],
                    'tiempo_verde' => (int)$row['tiempo_verde'],
                    'tiempo_amarillo' => (int)$row['tiempo_amarillo'],
                    'tiempo_rojo' => (int)$row['tiempo_rojo']
                );

                array_push($array['SemaforosAll'],$row);
            }

            $this->PrintJSON($array);

        }else{
            $this->Error('No hay elementos registrados');
        }
    }

    function Sel($id){

        $semaforo = new All();
        $array = array();
        $array['SemaforoAll'] = array();

        $res= $semaforo->Select($id);

        if($res->rowCount() == 1){
            $row = $res->fetch();
                $item = array(
                    'id' => (int)$row['id'],
                    'nombre' => $row['nombre'],
                    'status' => $row['status'],
                    'longitud' => (int)$row['longitud'],
                    'latitud' => (int)$row['latitud'],
                    'tiempo_inicio' => (int)$row['tiempo_inicio'],
                    'inicio_suspencion' => $row['inicio_suspencion'],
                    'fin_suspencion' => $row['fin_suspencion'],
                    'tiempo_verde' => (int)$row['tiempo_verde'],
                    'tiempo_amarillo' => (int)$row['tiempo_amarillo'],
                    'tiempo_rojo' => (int)$row['tiempo_rojo']
                );

                array_push($array['SemaforoAll'],$item);

            $this->PrintJSON($array);

        }else{
            $this->Error('No hay elementos registrados');
        }
    }

    function Ins($body){
        $item = json_decode($body, true);
        $semaforo = new Semaforo();

        $res= $semaforo->Insert($item);
        $this->exito('Nuevo horario agregado');
    }

    function Up($body,$id){
        $item = json_decode($body, true);
        $semaforo = new Semaforo();

        $res= $semaforo->Update($item,$id);
        $this->exito('Los datos del horario se actualizaron');
    }

    function Del($id){
        $semaforo = new Semaforo();

        $res= $semaforo->Delete($id);
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