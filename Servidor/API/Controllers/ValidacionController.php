<?php
include_once 'Controllers/AllController.php';

    class ValidacionController{
        
        /**
        * Validacion de los datospara el registro o actualizacion de un semaforo
        *
        * analiza el formato y estructura de cada dato del semaforo ingresado exeptuando
        * la geo-malla y redirige esos datos para su posterio proceso
        *
        * @access public
        * @param array $body contiene todos los datos del semaforo que son ingresados al servidor
        * @return void 
        */
        function Val($body){
            $all = new AllController();
            $array['Errores_Validacion'] = array();
            $valido = true;
            $item = json_decode($body, true);
            $item_semaforo = $item['semaforo'];
            $item_area = json_encode($item['area']);

            //Valida nombre
            if(!is_string($item_semaforo['nombre'])){
                $mensaje = array('nombre' => 'debe de ser un tipo de dato string');
                array_push($array['Errores_Validacion'], $mensaje);
                $valido = false;
            }

            //Valida status
            if(!is_bool($item_semaforo['estado_semaforo'])){
                $mensaje = array('estado_semaforo' => 'debe de ser un tipo de dato boolean');
                array_push($array['Errores_Validacion'], $mensaje);
                $valido = false;
            }

            //Valida longitud
            if(!is_float($item_semaforo['longitud'])){
                $mensaje = array('longitud' => 'deben ser un tipo de dato de float');
                array_push($array['Errores_Validacion'], $mensaje);
                $valido = false;
            }

            //Valida latitud
            if(!is_float($item_semaforo['latitud'])){
                $mensaje = array('latitud' => 'deben ser un tipo de dato de float');
                array_push($array['Errores_Validacion'], $mensaje);
                $valido = false;
            }

            //Valida timepo_inicio
            if(!is_int($item_semaforo['tiempo_inicio'])){
                $mensaje = array('timepo_inicio' => 'deben ser un tipo de dato de Integer');
                array_push($array['Errores_Validacion'], $mensaje);
                $valido = false;
            }

            //Valida inicio_suspencion
            if(!is_string($item_semaforo['inicio_suspension_semaforo']) || !preg_match_all("/^\d{2}:\d{2}:\d{2}$/",$item_semaforo['inicio_suspension_semaforo'])){
                $mensaje = array('inicio_suspension_semaforo' => 'deben ser un tipo de dato de string y una estructura 00:00:00');
                array_push($array['Errores_Validacion'], $mensaje);
                $valido = false;
            }

            //Valida fin_suspencion
            if(!is_string($item_semaforo['inicio_proceso_semaforo']) || !preg_match_all("/^\d{2}:\d{2}:\d{2}$/",$item_semaforo['inicio_proceso_semaforo'])){
                $mensaje = array('inicio_proceso_semaforo' => 'deben ser un tipo de dato de string y una estructura 00:00:00');
                array_push($array['Errores_Validacion'], $mensaje);
                $valido = false;
            }

            //Valida timepo_verde
            if(!is_int($item_semaforo['tiempo_verde'])){
                $mensaje = array('timepo_verde' => 'deben ser un tipo de dato de Integer');
                array_push($array['Errores_Validacion'], $mensaje);
                $valido = false;
            }

            //Valida timepo_amarillo
            if(!is_int($item_semaforo['tiempo_amarillo'])){
                $mensaje = array('timepo_amarillo' => 'deben ser un tipo de dato de Integer');
                array_push($array['Errores_Validacion'], $mensaje);
                $valido = false;
            }

            //Valida timepo_rojo
            if(!is_int($item_semaforo['tiempo_rojo'])){
                $mensaje = array('timepo_rojo' => 'deben ser un tipo de dato de Integer');
                array_push($array['Errores_Validacion'], $mensaje);
                $valido = false;
            }

            if($valido == false){
                $this->Error($array);
            }else{
                $all->Ins($body);
            }
        }

        /**
        * envia los posibles errores en la validacion de los datos del semaforo
        *
        * @access public
        * @param array $array contiene un arreglo que tiene diferentes mensajes dependiendo de todos los datos del semaforo
        *              no esten acorde a los que requiere el servidor
        * @return json envio un mensaje del error en formato json
        */
        function Error($array){
            header('Content-Type: application/json');
            echo json_encode($array,JSON_UNESCAPED_UNICODE);
            http_response_code(200);
        }
    }
?>