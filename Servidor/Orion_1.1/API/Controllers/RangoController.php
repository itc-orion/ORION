<?php

include_once 'Models/Rango.php';

class RangoController{

    function All(){
        $rango = new Rango();
        $array['Rangos'] = array();

        $res= $rango->Show();

        if($res->rowCount()){
            while($row = $res->fetch(PDO::FETCH_ASSOC)){
                $item = array(
                    'id' => (int)$row['id'],
                    'longitud' => (float)$row['longitud'],
                    'latitud' => (float)$row['latitud']
                );

                array_push($array['Rangos'],$item);
            }

            $this->PrintJSON($array);

        }else{
            $this->Error('No hay elementos registrados');
        }
    }

    function Sel($id){
        $rango = new Rango();
        $array['Rango'] = array();

        $res= $rango->Select($id);

        if($res->rowCount() == 1){
            $row = $res->fetch();
                $item = array(
                    'id' => (int)$row['id'],
                    'longitud' => (float)$row['longitud'],
                    'latitud' => (float)$row['latitud']
                );

                array_push($array['Rango'],$item);

            $this->PrintJSON($array);

        }else{
            $this->Error('No hay elementos registrados');
        }
    }

    function Ins($body){
        $item = json_decode($body, true);
        $rango = new Rango();

        $res= $rango->Insert($item);
        
        if(!$res){
            $this->Exito("Error al Crear rango");
        }else{
            $this->Error("Rango creado correctamente");
        }
    }

    function Up($body,$id){
        $item = json_decode($body, true);
        $rango = new Rango();

        $res= $rango->Update($item,$id);
        
        if(!$res){
            $this->Exito("Error al actualizar rango");
        }else{
            $this->Error("Rango actulizado correctamente");
        }
    }

    function Del($id){
        $rango = new Rango();

        $res= $rango->Delete($id);
        
        if(!$res){
            $this->Exito("Error al eliminar rango");
        }else{
            $this->Error("Rango eliminado correctamente");
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