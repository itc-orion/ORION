<?php

class ErrorController{

    public function Mensaje($mensaje){
        echo json_encode(array('Mensaje' => $mensaje));
    }
    
}