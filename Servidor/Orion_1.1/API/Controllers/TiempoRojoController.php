<?php

include_once 'Models/TiempoRojo.php';

class TiempoRojoController{

    function All(){
        $tiempo_rojo = new TiempoRojo();
        $array['TiemposRojo'] = array();

        $res= $tiempo_rojo->Show();

        if($res->rowCount()){
            while($row = $res->fetch(PDO::FETCH_ASSOC)){
                $item = array(
                    'id' => (int)$row['id'],
                    'tiempo_rojo' => (int)$row['tiempo_rojo']
                );

                array_push($array['TiemposRojo'],$item);
            }

            $this->PrintJSON($array);

        }else{
            $this->Error('No hay elementos registrados');
        }
    }

    function Sel($id){
        $tiempo_rojo = new TiempoRojo();
        $array['TiempoRojo'] = array();

        $res= $tiempo_rojo->Select($id);

        if($res->rowCount() == 1){
            $row = $res->fetch();
                $item = array(
                    'id' => (int)$row['id'],
                    'tiempo_rojo' => (int)$row['tiempo_rojo']
                );

                array_push($array['TiempoRojo'],$item);

            $this->PrintJSON($array);

        }else{
            $this->Error('No hay elementos registrados');
        }
    }

    function Ins($body){
        $item = json_decode($body, true);
        $tiempo_rojo = new TiempoRojo();

        $res= $tiempo_rojo->Insert($item);
        
        if(!$res){
            $this->Exito("Error al Crear tiempo de rojo");
        }else{
            $this->Error("Tiempo de rojo creado correctamente");
        }
    }

    function Up($body,$id){
        $item = json_decode($body, true);
        $tiempo_rojo = new TiempoRojo();

        $res= $tiempo_rojo->Update($item,$id);
        if(!$res){
            $this->Exito("Error al actualizar tiempo de rojo");
        }else{
            $this->Error("Tiempo de rojo actulizado correctamente");
        }
    }

    function Del($id){
        $tiempo_rojo = new TiempoRojo();

        $res= $tiempo_rojo->Delete($id);
        
        if(!$res){
            $this->Exito("Error al eliminar tiempo de rojo");
        }else{
            $this->Error("Tiempo de rojo eliminado correctamente");
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