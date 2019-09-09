<?php

include_once 'Models/All.php';
include_once 'Models/Semaforo.php';
include_once 'Models/Horario.php';
include_once 'Models/Rango.php';
include_once 'Models/TiempoVerde.php';
include_once 'Models/TiempoAmarillo.php';
include_once 'Models/TiempoRojo.php';

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
                    'status' => (boolean)$row['status'],
                    'longitud' => (float)$row['longitud'],
                    'latitud' => (float)$row['latitud'],
                    'tiempo_inicio' => (int)$row['tiempo_inicio'],
                    'inicio_suspencion' => $row['inicio_suspencion'],
                    'fin_suspencion' => $row['fin_suspencion'],
                    'tiempo_verde' => (int)$row['tiempo_verde'],
                    'tiempo_amarillo' => (int)$row['tiempo_amarillo'],
                    'tiempo_rojo' => (int)$row['tiempo_rojo']
                );

                array_push($array['SemaforosAll'],$item);
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
                    'status' => (boolean)$row['status'],
                    'longitud' => (float)$row['longitud'],
                    'latitud' => (float)$row['latitud'],
                    'tiempo_inicio' => (int)$row['tiempo_inicio'],
                    'inicio_suspencion' => (string)$row['inicio_suspencion'],
                    'fin_suspencion' => (string)$row['fin_suspencion'],
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

        $id_horario = $this->SelHorario($item['inicio_suspencion'], $item['fin_suspencion']);
        $id_rango = $this->SelRango($item['longitud'], $item['latitud']);
        $id_tiempo_verde = $this->SelTiempoVerde($item['tiempo_verde']);
        $id_tiempo_amarillo = $this->SelTiempoAmarillo($item['tiempo_amarillo']);
        $id_tiempo_rojo = $this->SelTiempoRojo($item['tiempo_rojo']);

        $item_all = array(
            'nombre' => $item['nombre'],
            'status' => $item['status'],
            'tiempo_inicio' => $item['tiempo_inicio'],
            'id_horario' => $id_horario,
            'id_rango' => $id_rango,
            'id_tverde' => $id_tiempo_verde,
            'id_tamarillo' => $id_tiempo_amarillo,
            'id_trojo' => $id_tiempo_rojo
        );

        $res= $semaforo->Insert($item_all);

        if(!$res){
            $this->Exito("Error al Crear registro");
        }else{
            $this->Error("Registro creado correctamente");
        }
    }

    function Up($body,$id){
        $item = json_decode($body, true);
        $semaforo = new Semaforo();

        $id_horario = $this->SelHorario($item['inicio_suspencion'], $item['fin_suspencion']);
        $id_tiempo_verde = $this->SelTiempoVerde($item['tiempo_verde']);
        $id_tiempo_amarillo = $this->SelTiempoAmarillo($item['tiempo_amarillo']);
        $id_tiempo_rojo = $this->SelTiempoRojo($item['tiempo_rojo']);

        $item_all = array(
            'nombre' => $item['nombre'],
            'status' => $item['status'],
            'tiempo_inicio' => $item['tiempo_inicio'],
            'id_horario' => $id_horario,
            'id_tverde' => $id_tiempo_verde,
            'id_tamarillo' => $id_tiempo_amarillo,
            'id_trojo' => $id_tiempo_rojo
        );

        $res= $semaforo->Update($item_all,$id);
        
        if(!$res){
            $this->Exito("Error al actualizar registro");
        }else{
            $this->Error("Registro actulizado correctamente");
        }
    }

    function Del($id){
        $semaforo = new Semaforo();

        $res= $semaforo->Delete($id);
        
        if(!$res){
            $this->Exito("Error al eliminar registro");
        }else{
            $this->Error("Registro eliminado correctamente");
        }
    }

    function Exito($mensaje){
        header('Content-Type: application/json');
        echo json_encode(array('Mensaje' => $mensaje));
    }

    function PrintJSON($array){
        header('Content-Type: application/json');
        echo json_encode($array,JSON_UNESCAPED_UNICODE);
    }

    function Error($mensaje){
        header('Content-Type: application/json');
        echo json_encode(array('Mensaje' => $mensaje));
    }

    function SelHorario($inicio, $fin){
        $horario = new Horario();

        $res = $horario->SelectData($inicio, $fin);
        if($res->rowCount()){
            $row = $res->fetch();
            $id = (int)$row['id'];

            return $id;
        }else{
            $item = array('inicio_suspencion' => $inicio,'fin_suspencion' => $fin);
            $horario->Insert($item);
            $res = $horario->SelectData($inicio, $fin);
            $row = $res->fetch();
            $id = (int)$row['id'];

            return $id;
        }
    }

    function SelRango($longitud, $latitud){
        $rango = new Rango();

        $res = $rango->SelectData($longitud, $latitud);
        if($res->rowCount()){
            $row = $res->fetch();
            $id = (int)$row['id'];

            return $id;
        }else{
            $item = array('longitud' => $longitud,'latitud' => $latitud);
            $rango->Insert($item);
            $res = $rango->SelectData($longitud, $latitud);
            $row = $res->fetch();
            $id = (int)$row['id'];

            return $id;
        }
    }

    function SelTiempoVerde($tiempo){
        $tiempo_verde = new TiempoVerde();

        $res= $tiempo_verde->SelectData($tiempo);
        if($res->rowCount()){
            $row = $res->fetch();
            $id = (int)$row['id'];

            return $id;
        }else{
            $item = array('tiempo_verde' => $tiempo);
            $tiempo_verde->Insert($item);
            $res= $tiempo_verde->SelectData($tiempo);
            $row = $res->fetch();
            $id = (int)$row['id'];

            return $id;
        }
    }

    function SelTiempoAmarillo($tiempo){
        $tiempo_amarillo = new TiempoAmarillo();

        $res= $tiempo_amarillo->SelectData($tiempo);
        if($res->rowCount()){
            $row = $res->fetch();
            $id = (int)$row['id'];

            return $id;
        }else{
            $item = array('tiempo_amarillo' => $tiempo);
            $tiempo_amarillo->Insert($item);
            $res= $tiempo_amarillo->SelectData($tiempo);
            $row = $res->fetch();
            $id = (int)$row['id'];

            return $id;
        }
    }

    function SelTiempoRojo($tiempo){
        $tiempo_rojo = new TiempoRojo();

        $res= $tiempo_rojo->SelectData($tiempo);
        if($res->rowCount()){
            $row = $res->fetch();
            $id = (int)$row['id'];

            return $id;
        }else{
            $item = array('tiempo_rojo' => $tiempo);
            $tiempo_rojo->Insert($item);
            $res= $tiempo_rojo->SelectData($tiempo);
            $row = $res->fetch();
            $id = (int)$row['id'];

            return $id;
        }
    }
}

?>