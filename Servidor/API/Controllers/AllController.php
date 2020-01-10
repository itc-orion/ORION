<?php
include_once 'Models/All.php';
include_once 'Models/Semaforo.php';
include_once 'Models/Horario.php';
include_once 'Models/Area.php';
include_once 'Models/TiempoLuces.php';



    class AllController{
        
        /**
        * consulta de los semaforos registrados 
        *
        * @access public
        * @return json envio de los datos de los semaforos en formato json
        */
        function All(){
            try{
                $semaforo_all = new All();
                $array['semaforos'] = array();

                $res= $semaforo_all->Show();
                if($res->rowCount()){
                    while($row = $res->fetch(PDO::FETCH_ASSOC)){
                        $item = array(
                            'id' => (int)$row['id'],
                            'nombre' => $row['nombre'],
                            'estado_semaforo' => (boolean)$row['estado_semaforo'],
                            'longitud' => (float)$row['longitud'],
                            'latitud' => (float)$row['latitud'],
                            'tiempo_inicio' => (int)$row['tiempo_inicio'],
                            'inicio_suspension_semaforo' => $row['inicio_suspension_semaforo'],
                            'inicio_proceso_semaforo' => $row['inicio_proceso_semaforo'],
                            'tiempo_verde' => (int)$row['tiempo_verde'],
                            'tiempo_amarillo' => (int)$row['tiempo_amarillo'],
                            'tiempo_rojo' => (int)$row['tiempo_rojo'],
                            'area' => $row['archivo_json']
                        );
                        
                        array_push($array['semaforos'],$item);
                        
                    }

                    $this->PrintJSON($array);

                }else{
                    $this->Error();
                }
            }catch(Error $e){
                $this->Error();
            }
        }

        /**
        * consulta de un semaforo espesifico
        *
        * @access public
        * @param array $body contiene la longitud y latitud del semaforo a consultar en formato json
        * @return json envio de los datos del semaforo en formato json
        */
        function Sel($body){
            $item = json_decode($body, true);
            $all = new All();
            $item_coordenadas = $item['coordenadas'];
            $array['semaforo'] = array();

            $res= $all->Select($item_coordenadas);

            if($res->rowCount() == 1){
                $row = $res->fetch();
                $item = array(
                    'id' => (int)$row['id'],
                        'nombre' => $row['nombre'],
                        'estado_semaforo' => (boolean)$row['estado_semaforo'],
                        'longitud' => (float)$row['longitud'],
                        'latitud' => (float)$row['latitud'],
                        'tiempo_inicio' => (int)$row['tiempo_inicio'],
                        'inicio_suspension_semaforo' => $row['inicio_suspension_semaforo'],
                        'inicio_proceso_semaforo' => $row['inicio_proceso_semaforo'],
                        'tiempo_verde' => (int)$row['tiempo_verde'],
                        'tiempo_amarillo' => (int)$row['tiempo_amarillo'],
                        'tiempo_rojo' => (int)$row['tiempo_rojo'],
                        'area' => $row['archivo_json']
                );

                array_push($array['semaforo'],$item);

                $this->PrintJSON($array);

            }else{
                $this->Error();
            }
        }

        /**
        * registra los datos y la area geografica del semaforo
        * 
        * verifica la existencia del ssemaforo y en caso de que ya existe
        * se redirigira al metodo de actualizacion de los datos
        *
        * @access public
        * @param array $body arreglo en formato json que contiene los datos del semaforo
        * @return json envia un mensaje en formato json con el resultado de la funcion
        */
        function Ins($body){
            try{
                $item = json_decode($body, true);
                $semaforo = new Semaforo();
                $area = new Area();
                $item_semaforo = $item['semaforo'];
                $item_area = json_encode($item['area']);

                $id = $this->ValidarSemaforo($item_semaforo['longitud'], $item_semaforo['latitud']);
                if($id == 0){
                    $id_horario = $this->SelHorario($item_semaforo['inicio_suspension_semaforo'], $item_semaforo['inicio_proceso_semaforo']);
                    $id_tiempo_luces = $this->SelTiempoLuces($item_semaforo['tiempo_verde'], $item_semaforo['tiempo_amarillo'], $item_semaforo['tiempo_rojo']);

                    $item_all = array(
                        'nombre' => $item_semaforo['nombre'],
                        'estado_semaforo' => $item_semaforo['estado_semaforo'],
                        'tiempo_inicio' => $item_semaforo['tiempo_inicio'],
                        'longitud' => $item_semaforo['longitud'],
                        'latitud' => $item_semaforo['latitud'],
                        'id_horario' => $id_horario,
                        'id_luces' => $id_tiempo_luces
                    );

                    $res= $semaforo->Insert($item_all);

                    if(!$res){
                        $this->Error();
                    }else{
                        $this->Exito();
                        $id_semaforo = $this->ValidarSemaforo($item_semaforo['longitud'], $item_semaforo['latitud']);
                        $res=$area->Insert($id_semaforo,$item_area);
                    }
                }else{
                    $this->Up($body);
                }
            }catch(Error $e){
                $this->Error();
            }
        }

        /**
        * actualizacion de los datos y la area geografica del semaforo
        *
        * @access public
        * @param array $body arreglo en formato json que contiene los datos del semaforo
        * @return json envia un mensaje en formato json con el resultado de la funcion
        */
        function Up($body){
            $item = json_decode($body, true);
            $semaforo = new Semaforo();
            $area = new Area();
            $item_semaforo = $item['semaforo'];
            $item_area = json_encode($item['area']);

            $id = $this->ValidarSemaforo($item_semaforo['longitud'], $item_semaforo['latitud']);
            if($id != 0){
                $id_horario = $this->SelHorario($item_semaforo['inicio_suspension_semaforo'], $item_semaforo['inicio_proceso_semaforo']);
                $id_tiempo_luces = $this->SelTiempoLuces($item_semaforo['tiempo_verde'], $item_semaforo['tiempo_amarillo'], $item_semaforo['tiempo_rojo']);

                $item_up = array(
                    'nombre' => $item_semaforo['nombre'],
                    'estado_semaforo' => $item_semaforo['estado_semaforo'],
                    'tiempo_inicio' => $item_semaforo['tiempo_inicio'],
                    'longitud' => $item_semaforo['longitud'],
                    'latitud' => $item_semaforo['latitud'],
                    'id_horario' => $id_horario,
                    'id_luces' => $id_tiempo_luces
                );

                $res= $semaforo->Update($item_up,$id);
                if(!$res){
                    $this->Error();
                }else{
                    $this->Exito();
                    $res=$area->Update($id,$item_area);
                }
            }else{
                $this->Error();
            }
        }

        /**
        * elimina el registro del semaforo
        *
        * @access public
        * @param array $body contiene la longitud y latitud del semaforo a eliminar en formato json
        * @return json envia un mensaje en formato json con el resultado de la funcion
        */
        function Del($body){
            $item = json_decode($body, true);
            $semaforo = new Semaforo();
            $area = new Area();
            $item_coordenadas = $item['coordenadas'];

            $id = $this->ValidarSemaforo($item_coordenadas['longitud'], $item_coordenadas['latitud']);
            if($id != 0){
            
                $area->Delete($id);
                $res= $semaforo->Delete($id);
            if(!$res){
                $this->Error();
            }else{
                $this->Exito();
            }
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
        * envia los datos de una consulta en formato json
        *
        * @access public
        * @param array $array contiene los datos de una cunsulta que seran trasformado a json
        * @return json envia un array en formato json con los resultados de la consulta
        */
        function PrintJSON($array){
            header('Content-Type: application/json');
            echo json_encode($array);
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

        /**
        * consulta de la clave primaria del horario del semaforo
        *
        * verifica que el horario exista para devolver su clave, en caso de que no se asi,
        * se registra el nuevo horario y la clave es retornada para el registro o actualizacion
        * del semaforo
        *
        * @access public
        * @param string $inicio_suspension_semaforo, $inicio_proceso_semaforo datos con una estructura 00:00:00 
        *               que simbolizan la hora de inicio y finalizacion del estado se suspencion del semaforo
        * @return $id retorna la clave del horario para vincularlo al semaforo 
        */
        function SelHorario($inicio_suspension_semaforo, $inicio_proceso_semaforo){
            $horario = new Horario();
            $item = array('inicio_suspension_semaforo' => $inicio_suspension_semaforo,'inicio_proceso_semaforo' => $inicio_proceso_semaforo);

            $res = $horario->SelectData($item);
            if($res->rowCount()){
                $row = $res->fetch();
                $id = (int)$row['id'];

                return $id;
            }else{
                $horario->Insert($item);
                $res = $horario->SelectData($item);
                $row = $res->fetch();
                $id = (int)$row['id'];

                return $id;
            }
        }

        /**
        * consulta de la clave primaria del tiempo que tarda los colores de el semaforo
        *
        * verifica que el tiempo de los colores exista para devolver su clave, en caso de que no se asi,
        * se registra el nuevo tiempo y la clave es retornada para el registro o actualizacion
        * del semaforo
        *
        * @access public
        * @param int $tiempo_verde, $tiempo_amarillo, $tiempo_rojo contien el tiempo de los colores del semaforo
        * @return $id retorna la clave del tiempo de los colores para vincularlo al semaforo
        */
        function SelTiempoLuces($tiempo_verde, $tiempo_amarillo, $tiempo_rojo){
            $tiempo_luces = new TiempoLuces();
            $item = array('tiempo_verde' => $tiempo_verde, 'tiempo_amarillo' => $tiempo_amarillo, 'tiempo_rojo' => $tiempo_rojo);
            $id=0;
            
            $res= $tiempo_luces->SelectData($item);
            if($res->rowCount() == 1){
                $row = $res->fetch();
                $id = (int)$row['id'];

                return $id;
            }else{
                $tiempo_luces->Insert($item);
                $res= $tiempo_luces->SelectData($item);
                if($res->rowCount()){
                    $row = $res->fetch();
                    $id = (int)$row['id'];
                }
                return $id;
            }
        }

        /**
        * verifica la existencia del semaforo atraves de su posicion con la longitud y latitud
        *
        * verifica si el registro del semaforo existe, retornando asi el valor de la clave o
        * en el caso de que no exista, retorna un 0
        *
        * @access public
        * @param float $longitud, $latitud variables decimales reprecenta el posicionamiento geografico
        *              del semaforo
        * @return $id retorna la clave del semaforo para validar la existencia
        */
        function ValidarSemaforo($longitud, $latitud){
            $semaforo = new Semaforo();
            $item = array('longitud' => $longitud, 'latitud' => $latitud);

            $res = $semaforo->SelectData($item);
            if($res->rowCount()){
                $row = $res->fetch();
                $id = (int)$row['id'];

                return $id;
            }else{
                $id = 0;

                return $id;
            }
        }
    }
?>