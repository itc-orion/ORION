<?php
    include_once 'Controllers/AllController.php';

    class ValidacionController{

        function Ins($body){
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
            if(!is_bool($item_semaforo['status'])){
                $mensaje = array('status' => 'debe de ser un tipo de dato boolean');
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
            if(!is_string($item_semaforo['inicio_suspencion']) || !preg_match_all("/^\d{2}:\d{2}:\d{2}$/",$item_semaforo['inicio_suspencion'])){
                $mensaje = array('inicio_suspencion' => 'deben ser un tipo de dato de string y una estructura 00:00:00');
                array_push($array['Errores_Validacion'], $mensaje);
                $valido = false;
            }

            //Valida fin_suspencion
            if(!is_string($item_semaforo['fin_suspencion']) || !preg_match_all("/^\d{2}:\d{2}:\d{2}$/",$item_semaforo['fin_suspencion'])){
                $mensaje = array('fin_suspencion' => 'deben ser un tipo de dato de string y una estructura 00:00:00');
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

        function Up($body){
            $all = new AllController();
            $array['Errores_Validacion'] = array();
            $valido = true;
            $item = json_decode($body, true);
            $item_semaforo = $item['semaforo'];
            
            //Valida nombre
            if(!is_string($item_semaforo['nombre'])){
                $mensaje = array('nombre' => 'debe de ser un tipo de dato string');
                array_push($array['Errores_Validacion'], $mensaje);
                $valido = false;
            }

            //Valida status
            if(!is_bool($item_semaforo['status'])){
                $mensaje = array('status' => 'debe de ser un tipo de dato boolean');
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
            if(!is_string($item_semaforo['inicio_suspencion']) || !preg_match_all("/^\d{2}:\d{2}:\d{2}$/",$item_semaforo['inicio_suspencion'])){
                $mensaje = array('inicio_suspencion' => 'deben ser un tipo de dato de string y una estructura 00:00:00');
                array_push($array['Errores_Validacion'], $mensaje);
                $valido = false;
            }

            //Valida fin_suspencion
            if(!is_string($item_semaforo['fin_suspencion']) || !preg_match_all("/^\d{2}:\d{2}:\d{2}$/",$item_semaforo['fin_suspencion'])){
                $mensaje = array('fin_suspencion' => 'deben ser un tipo de dato de string y una estructura 00:00:00');
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
                $all->Up($body);
            }
        }

        function PrintJSON($mensaje){
            header('Content-Type: application/json');
            echo json_encode(array('Mensaje' => $mensaje));
            http_response_code(200);
        }

        function Error($array){
            header('Content-Type: application/json');
            echo json_encode($array,JSON_UNESCAPED_UNICODE);
            http_response_code(405);
        }
    }
?>