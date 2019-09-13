<?php

include_once 'Models/TiempoVerde.php';

class TiempoVerdeController{

    function All(){
        $tiempo_verde = new TiempoVerde();
        $array['TiemposVerde'] = array();

        $res= $tiempo_verde->Show();

        if($res->rowCount()){
            while($row = $res->fetch(PDO::FETCH_ASSOC)){
                $item = array(
                    'id' => (int)$row['id'],
                    'tiempo_verde' => (int)$row['tiempo_verde']
                );

                array_push($array['TiemposVerde'],$item);
            }

            $this->PrintJSON($array);

        }else{
            $this->Error('No hay elementos registrados');
        }
    }

    function Sel($id){
        $tiempo_verde = new TiempoVerde();
        $array['TiempoVerde'] = array();

        $res= $tiempo_verde->Select($id);

        if($res->rowCount() == 1){
            $row = $res->fetch();
                $item = array(
                    'id' => (int)$row['id'],
                    'tiempo_verde' => (int)$row['tiempo_verde']
                );

                array_push($array['TiempoVerde'],$item);

            $this->PrintJSON($array);

        }else{
            $this->Error('No hay elementos registrados');
        }
    }

    function Ins($body){
        $item = json_decode($body, true);
        $tiempo_verde = new TiempoVerde();

        $res= $tiempo_verde->Insert($item);
        
        if(!$res){
            $this->Exito("Error al Crear tiempo de verde");
        }else{
            $this->Error("Tiempo de verde creado correctamente");
        }
    }

    function Up($body,$id){
        $item = json_decode($body, true);
        $tiempo_verde = new TiempoVerde();

        $res= $tiempo_verde->Update($item,$id);
        if(!$res){
            $this->Exito("Error al actualizar tiempo de verde");
        }else{
            $this->Error("Tiempo de verde actulizado correctamente");
        }
    }

    function Del($id){
        $tiempo_verde = new TiempoVerde();

        $res= $tiempo_verde->Delete($id);
        
        if(!$res){
            $this->Exito("Error al eliminar tiempo de verde");
        }else{
            $this->Error("Tiempo de verde eliminado correctamente");
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