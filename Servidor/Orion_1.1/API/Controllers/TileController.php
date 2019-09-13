<?php

include_once 'Config/ConexionTile.php';

    class TileController extends Tile{

        function All(){
            echo $this->Show();
        }

        function Sel($id){
            echo $this->Select($id);
        }

        function Ins($id,$item){
            $res = $this->Insert($id,$item);
            if(!$res){
                $this->Exito("Error al Crear registro");
            }else{
                $this->Error("Registro creado correctamente");
            }
        }

        function Up($id,$item){
            $res = $this->Update($id,$item);
            if(!$res){
                $this->Exito("Error al actualizar registro");
            }else{
                $this->Error("Registro actualizado correctamente");
            }
        }

        function Del($id){
            $res = $this->Delete($id);
            if(!$res){
                $this->Exito("Error al eliminar registro");
            }else{
                $this->Error("Registro eliminado correctamente");
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