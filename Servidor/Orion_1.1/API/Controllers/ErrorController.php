<?php

class ErrorController{

    public function Mensaje($mensaje){
        header('Content-Type: application/json');
        echo json_encode(array('Mensaje' => $mensaje));
    }
    
}