<?php

include_once 'Models/All.php';
include_once 'Models/Semaforo.php';
include_once 'Models/Horario.php';
include_once 'Models/Rango.php';
include_once 'Models/TiempoVerde.php';
include_once 'Models/TiempoAmarillo.php';
include_once 'Models/TiempoRojo.php';
include_once 'Models/Tile.php';

class AllController{
    
    function All(){
        try{
            $semaforo_all = new All();
            $tile = new Tile();
            $array['Semaforos'] = array();

            $res= $semaforo_all->Show();
            if($res->rowCount()){
                while($row = $res->fetch(PDO::FETCH_ASSOC)){
                    $id_rango = $this->SelRango((float)$row['longitud'], (float)$row['latitud']);
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
                        'tiempo_rojo' => (int)$row['tiempo_rojo'],
                        'area' => $tile->Sel($id_rango)
                    );
                    
                    array_push($array['Semaforos'],$item);
                    
                }

                $this->PrintJSON($array);

            }else{
                $this->Error('No hay elementos registrados');
            }
        }catch(Error $e){
            $this->Error($e->getMessage());
        }
    }

    function Sel($id){
        $semaforo = new All();
        $tile = new Tile();
        $array['Semaforo'] = array();

        $res= $semaforo->Select($id);

        if($res->rowCount() == 1){
            $row = $res->fetch();
            $id_rango = $this->SelRangoVal((float)$row['longitud'], (float)$row['latitud']);
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
                'tiempo_rojo' => (int)$row['tiempo_rojo'],
                'area' => $tile->Sel($id_rango)
            );
            array_push($array['Semaforo'],$item);

            $this->PrintJSON($array);

        }else{
            $this->Error('el elemento no esta registrado');
        }
    }

    function SelRan($body){
        $item = json_decode($body, true);
        $semaforo = new Semaforo();
        $tile = new Tile();
        $item_rango = $item['rango'];
        $array['Semaforo'] = array();

        $id = $this->SelRangoVal($item_rango['longitud'], $item_rango['latitud']);

        
        if($id != 0){
            $res = $semaforo->selectData($id);
            $row = $res->fetch();
            $id_sem = (int)$row['id'];
            $res= $semaforo->Select($id_sem);

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
                    'tiempo_rojo' => (int)$row['tiempo_rojo'],
                    'area' => $tile->Sel($id)
                );
                array_push($array['Semaforo'],$item);

                $this->PrintJSON($array);

            }else{
                $this->Error('el elemento no esta registrado');
            }
        }else{
            $this->Error('el elemento no esta registrado');
        }
    }

    function Ins($body){
        try{
            $item = json_decode($body, true);
            $semaforo = new Semaforo();
            $tile = new Tile();
            $item_semaforo = $item['semaforo'];
            $item_area = json_encode($item['area']);

            $id_horario = $this->SelHorario($item_semaforo['inicio_suspencion'], $item_semaforo['fin_suspencion']);
            $id_rango = $this->SelRango( $item_semaforo['longitud'], $item_semaforo['latitud']);
            $id_tiempo_verde = $this->SelTiempoVerde($item_semaforo['tiempo_verde']);
            $id_tiempo_amarillo = $this->SelTiempoAmarillo($item_semaforo['tiempo_amarillo']);
            $id_tiempo_rojo = $this->SelTiempoRojo($item_semaforo['tiempo_rojo']);

            $item_all = array(
                'nombre' => $item_semaforo['nombre'],
                'status' => $item_semaforo['status'],
                'tiempo_inicio' => $item_semaforo['tiempo_inicio'],
                'id_horario' => $id_horario,
                'id_rango' => $id_rango,
                'id_tverde' => $id_tiempo_verde,
                'id_tamarillo' => $id_tiempo_amarillo,
                'id_trojo' => $id_tiempo_rojo
            );

            $res= $semaforo->Insert($item_all);

            $resa= $tile->Ins($id_rango,$item_area);
            if(!$res){
                $this->Error("Error al Crear registro");
            }else{
                $this->Exito("Registro creado correctamente");
            }
        }catch(Error $e){
            $this->Error($e->getMessage());
        }
    }

    function Up($body,$id){
        $item = json_decode($body, true);
        $semaforo = new Semaforo();
        $tile = new Tile();
        $item_semaforo = $item['semaforo'];
        $item_area = json_encode($item['area']);

        $id_horario = $this->SelHorario($item_semaforo['inicio_suspencion'], $item_semaforo['fin_suspencion']);
        $id_tiempo_verde = $this->SelTiempoVerde($item_semaforo['tiempo_verde']);
        $id_tiempo_amarillo = $this->SelTiempoAmarillo($item_semaforo['tiempo_amarillo']);
        $id_tiempo_rojo = $this->SelTiempoRojo($item_semaforo['tiempo_rojo']);

        $item_up = array(
            'nombre' => $item_semaforo['nombre'],
            'status' => $item_semaforo['status'],
            'tiempo_inicio' => $item_semaforo['tiempo_inicio'],
            'id_horario' => $id_horario,
            'id_tverde' => $id_tiempo_verde,
            'id_tamarillo' => $id_tiempo_amarillo,
            'id_trojo' => $id_tiempo_rojo
        );

        $res= $semaforo->Update($item_up,$id);
        $tile->Up($id_rango,$item_area);
        if(!$res){
            $this->Error("Error al actualizar registro");
        }else{
            $this->Exito("Registro actulizado correctamente");
        }
    }

    function Del($id){
        $semaforo = new Semaforo();
        $tile = new Tile();

        $res= $semaforo->Select($id);

        if($res->rowCount() == 1){
            $row = $res->fetch();
            $id_rango = $this->SelRango((float)$row['longitud'], (float)$row['latitud']);
        }
        $res= $semaforo->Delete($id);
        $tile->Del($id_rango);
        if(!$res){
            $this->Error("Error al eliminar registro");
        }else{
            $this->Exito("Registro eliminado correctamente");
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
    
    function SelRangoVal($longitud, $latitud){
        $rango = new Rango();

        $res = $rango->SelectData($longitud, $latitud);
        if($res->rowCount()){
            $row = $res->fetch();
            $id = (int)$row['id'];

            return $id;
        }else{
            $id = 0;

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