<?php

include_once 'Models/TiempoAmarillo.php';

class TiempoAmarilloController{

    function All(){
        $tiempo_amarillo = new TiempoAmarillo();
        $array['TiemposAmarillo'] = array();

        $res= $tiempo_amarillo->Show();

        if($res->rowCount()){
            while($row = $res->fetch(PDO::FETCH_ASSOC)){
                $item = array(
                    'id' => (int)$row['id'],
                    'tiempo_amarillo' => (int)$row['tiempo_amarillo']
                );

                array_push($array['TiemposAmarillo'],$item);
            }

            $this->PrintJSON($array);

        }else{
            $this->Error('No hay elementos registrados');
        }
    }

    function Sel($id){
        $tiempo_amarillo = new TiempoAmarillo();
        $array['TiempoAmarillo'] = array();

        $res= $tiempo_amarillo->Select($id);

        if($res->rowCount() == 1){
            $row = $res->fetch();
                $item = array(
                    'id' => (int)$row['id'],
                    'tiempo_amarillo' => (int)$row['tiempo_amarillo']
                );

                array_push($array['TiempoAmarillo'],$item);

            $this->PrintJSON($array);

        }else{
            $this->Error('No hay elementos registrados');
        }
    }

    function Ins($body){
        $item = json_decode($body, true);
        $tiempo_amarillo = new TiempoAmarillo();

        $res= $tiempo_amarillo->Insert($item);
        
        if(!$res){
            $this->Exito("Error al Crear tiempo de amarillo");
        }else{
            $this->Error("Tiempo de amarillo creado correctamente");
        }
    }

    function Up($body,$id){
        $item = json_decode($body, true);
        $tiempo_amarillo = new TiempoAmarillo();

        $res= $tiempo_amarillo->Update($item,$id);
        
        if(!$res){
            $this->Exito("Error al actualizar tiempo de amarillo");
        }else{
            $this->Error("Tiempo de amarillo actulizado correctamente");
        }
    }

    function Del($id){
        $tiempo_amarillo = new TiempoAmarillo();

        $res= $tiempo_amarillo->Delete($id);
        
        if(!$res){
            $this->Exito("Error al eliminar tiempo de amarillo");
        }else{
            $this->Error("Tiempo de amarillo eliminado correctamente");
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