<?php
include_once 'Models/Usuario.php';



    class UsuarioController{

        /**
        * consulta de un semaforo espesifico
        *
        * @access public
        * @param array $body contiene la longitud y latitud del semaforo a consultar en formato json
        * @return json envio de los datos del semaforo en formato json
        */
        function Sel($body){
            $item = json_decode($body, true);
            $usuario = new Usuario();

            $res= $usuario->Select($item);
            if($res->rowCount() == 1){
                $this->Exito();
            }else{
                $this->Error();
            }
        }

        /**
        * envia un TRUE de un proceso con un resultado correcto
        *
        * @access public
        * @return string envia un TRUE al tener un proceso sin errores
        */
        function Exito(){
            header('Content-Type: application/json');
            echo ('true');
            http_response_code(200);
        }

        /**
        * envia FALSE como resutado de un proceso con errores
        *
        * @access public
        * @return string envia un FALSE al tener un proceso con errores
        */
        function Error(){
            header('Content-Type: application/json');
            echo ('false');
            http_response_code(200);
        }
    }
?>