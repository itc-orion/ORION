<?php
    class ErrorController{

        /**
        * envia un mensaje en caso de error al momento de ingresar al sevidor
        *
        * es utilizado en el index para identificar diversos tipos de errores 
        * como la existencia de una url o metodo
        *
        * @access public
        * @param string $mensaje es una cadena que informa donde esta el problema
        * @return json envio un mensaje del error en formato json
        */
        public function Mensaje($mensaje){
            header('Content-Type: application/json');
            echo json_encode(array('Mensaje' => $mensaje));
            http_response_code(405);
        }
        
    }
?>