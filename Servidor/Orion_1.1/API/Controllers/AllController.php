<?php
include_once 'Models/All.php';
include_once 'Models/Semaforo.php';
include_once 'Models/Horario.php';
include_once 'Models/Rango.php';
include_once 'Models/TiempoVerde.php';
include_once 'Models/TiempoAmarillo.php';
include_once 'Models/TiempoRojo.php';
include_once 'Models/Tile.php';

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
                $tile = new Tile();
                $array['Semaforos'] = array();

                $res= $semaforo_all->Show();
                if($res->rowCount()){
                    while($row = $res->fetch(PDO::FETCH_ASSOC)){
                        $id_rango = $this->SelRangoVal((float)$row['longitud'], (float)$row['latitud']);
                        $item = array(
                            'id' => (int)$row['id'],
                            'nombre' => $row['nombre'],
                            'status' => (boolean)$row['status'],
                            'longitud' => (float)$row['longitud'],
                            'latitud' => (float)$row['latitud'],
                            'tiempo_inicio' => (int)$row['tiempo_inicio'],
                            'inicio_suspencion' => $row['inicio_suspencion'],
                            'fin_suspencion' => $row['fin_suspencion'],
                            'tiempo_verde' => (int)$row['tiempo_verde'],
                            'tiempo_amarillo' => (int)$row['tiempo_amarillo'],
                            'tiempo_rojo' => (int)$row['tiempo_rojo'],
                            'area' => $tile->Sel($id_rango)
                        );
                        
                        array_push($array['Semaforos'],$item);
                        
                    }

                    $this->PrintJSON($array);

                }else{
                    $this->Exito('No hay elementos registrados');
                }
            }catch(Error $e){
                $this->Error($e->getMessage());
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
            $semaforo = new Semaforo();
            $all = new All();
            $tile = new Tile();
            $item_rango = $item['rango'];
            $array['Semaforo'] = array();

            $id = $this->SelRangoVal($item_rango['longitud'], $item_rango['latitud']);
            if($id != 0){
                $res = $semaforo->selectData($id);
                $row = $res->fetch();
                $id_sem = (int)$row['id'];
                $res= $all->Select($id_sem);

                if($res->rowCount() == 1){
                    $row = $res->fetch();
                    $item = array(
                        'id' => (int)$row['id'],
                        'nombre' => $row['nombre'],
                        'status' => (boolean)$row['status'],
                        'longitud' => (float)$row['longitud'],
                        'latitud' => (float)$row['latitud'],
                        'tiempo_inicio' => (int)$row['tiempo_inicio'],
                        'inicio_suspencion' => (string)$row['inicio_suspencion'],
                        'fin_suspencion' => (string)$row['fin_suspencion'],
                        'tiempo_verde' => (int)$row['tiempo_verde'],
                        'tiempo_amarillo' => (int)$row['tiempo_amarillo'],
                        'tiempo_rojo' => (int)$row['tiempo_rojo'],
                        'area' => $tile->Sel($id)
                    );
                    array_push($array['Semaforo'],$item);

                    $this->PrintJSON($array);

                }else{
                    $this->Error('el elemento no esta registrado');
                }
            }else{
                $this->Error('el elemento no esta registrado');
            }
        }

        /**
        * registra los datos y la geo-malla del semaforo
        * 
        * verifica la existencia del ssemaforo y en caso de que ya existe
        * se actualizan los datos del semaforo
        *
        * @access public
        * @param array $body arreglo en formato json que contiene los datos del semaforo
        * @return json envia un mensaje en formato json con el resultado de la funcion
        */
        function Ins($body){
            try{
                $item = json_decode($body, true);
                $semaforo = new Semaforo();
                $rango = new Rango();
                $tile = new Tile();
                $item_semaforo = $item['semaforo'];
                $item_area = json_encode($item['area']);

                $id = $this->SelRangoVal($item_semaforo['longitud'], $item_semaforo['latitud']);
                if($id == 0){
                    $id_horario = $this->SelHorario($item_semaforo['inicio_suspencion'], $item_semaforo['fin_suspencion']);
                    $id_rango = $this->SelRango($item_semaforo['longitud'], $item_semaforo['latitud']);
                    $id_tiempo_verde = $this->SelTiempoVerde($item_semaforo['tiempo_verde']);
                    $id_tiempo_amarillo = $this->SelTiempoAmarillo($item_semaforo['tiempo_amarillo']);
                    $id_tiempo_rojo = $this->SelTiempoRojo($item_semaforo['tiempo_rojo']);

                    $item_all = array(
                        'nombre' => $item_semaforo['nombre'],
                        'status' => $item_semaforo['status'],
                        'tiempo_inicio' => $item_semaforo['tiempo_inicio'],
                        'id_horario' => $id_horario,
                        'id_rango' => $id_rango,
                        'id_tverde' => $id_tiempo_verde,
                        'id_tamarillo' => $id_tiempo_amarillo,
                        'id_trojo' => $id_tiempo_rojo
                    );

                    $res= $semaforo->Insert($item_all);

                    $resa= $tile->Ins($id_rango,$item_area);
                    if(!$res){
                        $this->Error("Error al Crear registro");
                    }else{
                        $this->Exito("Registro creado correctamente");
                    }
                }else{
                    $this->Up($body);
                }
            }catch(Error $e){
                $this->Error($e->getMessage());
            }
        }

        /**
        * actualizacion de los datos y la geo-malla del semaforo
        *
        * @access public
        * @param array $body arreglo en formato json que contiene los datos del semaforo
        * @return json envia un mensaje en formato json con el resultado de la funcion
        */
        function Up($body){
            $item = json_decode($body, true);
            $semaforo = new Semaforo();
            $tile = new Tile();
            $item_semaforo = $item['semaforo'];
            $item_area = json_encode($item['area']);

            $id_rango = $this->SelRangoVal($item_semaforo['longitud'], $item_semaforo['latitud']);
            if($id_rango != 0){
                $res = $semaforo->selectData($id_rango);
                $row = $res->fetch();
                $id = (int)$row['id'];

                $id_horario = $this->SelHorario($item_semaforo['inicio_suspencion'], $item_semaforo['fin_suspencion']);
                $id_tiempo_verde = $this->SelTiempoVerde($item_semaforo['tiempo_verde']);
                $id_tiempo_amarillo = $this->SelTiempoAmarillo($item_semaforo['tiempo_amarillo']);
                $id_tiempo_rojo = $this->SelTiempoRojo($item_semaforo['tiempo_rojo']);

                $item_up = array(
                    'nombre' => $item_semaforo['nombre'],
                    'status' => $item_semaforo['status'],
                    'tiempo_inicio' => $item_semaforo['tiempo_inicio'],
                    'id_horario' => $id_horario,
                    'id_tverde' => $id_tiempo_verde,
                    'id_tamarillo' => $id_tiempo_amarillo,
                    'id_trojo' => $id_tiempo_rojo
                );

                $res= $semaforo->Update($item_up,$id);
                $tile->Up($id_rango,$item_area);
                if(!$res){
                    $this->Error("Error al actualizar registro");
                }else{
                    $this->Exito("Registro actulizado correctamente");
                }
            }else{
                $this->Error("El registro no existe");
            }
        }

        /**
        * elimina el registro del semaforo
        *
        * @access public
        * @param array $body contiene la longitud y latitud del semaforo a consultar en formato json
        * @return json envia un mensaje en formato json con el resultado de la funcion
        */
        function Del($body){
            $item = json_decode($body, true);
            $semaforo = new Semaforo();
            $tile = new Tile();
            $rango = new Rango();
            $item_semaforo = $item['rango'];

            $id_rango = $this->SelRangoVal($item_semaforo['longitud'], $item_semaforo['latitud']);
            if($id_rango != 0){
            
                $res = $semaforo->selectData($id_rango);
                $row = $res->fetch();
                $id = (int)$row['id'];
            
                $res= $semaforo->Delete($id);
                $rango->Delete($id_rango);
                $tile->Del($id_rango);
            if(!$res){
                $this->Error("Error al eliminar registro");
            }else{
                $this->Exito("Registro eliminado correctamente");
            }
            }
        }

        /**
        * envia el resultado correcto de un proceso en formato json
        *
        * @access public
        * @param string $mensaje contiene un string definiendo el resultado de la operacion
        * @return json envia un mensaje en formato json con el resultado correcto de la funcion
        */
        function Exito($mensaje){
            header('Content-Type: application/json');
            echo json_encode(array('Mensaje' => $mensaje));
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
            echo json_encode($array,JSON_UNESCAPED_UNICODE);
            http_response_code(200);
        }

        /**
        * envia un resutado erroneo de proceso en formato json
        *
        * @access public
        * @param string $mensaje contiene un string definiendo el resultado de la operacion
        * @return json envia un mensaje en formato json con el resultado erroneo de la funcion
        */
        function Error($mensaje){
            header('Content-Type: application/json');
            echo json_encode(array('Mensaje' => $mensaje));
            http_response_code(405);
        }

        /**
        * consulta de la clave primaria del horario del semaforo
        *
        * verifica que el horario exista para devolver su clave, en caso de que no se asi,
        * se registra el nuevo horario y la clave es retornada para el registro o actualizacion
        * del semaforo
        *
        * @access public
        * @param string $inicio, $fin datos con una estructura 00:00:00 que simbolizan la hora de inicio y finalizacion
        *               del estado se suspencion del semaforo
        * @return $id retorna la clave del horario para vincularlo al semaforo 
        */
        function SelHorario($inicio, $fin){
            $horario = new Horario();

            $res = $horario->SelectData($inicio, $fin);
            if($res->rowCount()){
                $row = $res->fetch();
                $id = (int)$row['id'];

                return $id;
            }else{
                $item = array('inicio_suspencion' => $inicio,'fin_suspencion' => $fin);
                $horario->Insert($item);
                $res = $horario->SelectData($inicio, $fin);
                $row = $res->fetch();
                $id = (int)$row['id'];

                return $id;
            }
        }
        
        /**
        * verifica la existencia del semaforo atraves de su posicion con la longitud y latitud
        *
        * verifica si el registro del semaforo existe, retornando asi el valor de la clave o
        * en el caso de que no un 0
        *
        * @access public
        * @param float $longitud, $latitud variables decimales reprecenta el posicionamiento geografico
        *              del semaforo
        * @return $id retorna la clave del rango para validar la existencia del semaforo
        */
        function SelRangoVal($longitud, $latitud){
            $rango = new Rango();

            $res = $rango->SelectData($longitud, $latitud);
            if($res->rowCount()){
                $row = $res->fetch();
                $id = (int)$row['id'];

                return $id;
            }else{
                $id = 0;

                return $id;
            }
        }

        /**
        * verifica la existencia del semaforo atraves de su posicion con la longitud y latitud
        *
        * verifica si el registro del semaforo existe, retornando asi el valor de la clave o
        * en el caso de que no un 0
        *
        * @access public
        * @param float $longitud, $latitud variables decimales reprecenta el posicionamiento geografico
        *              del semaforo
        * @return $id retorna la clave del rango para vincularlo al semaforo
        */
        function SelRango($longitud, $latitud){
            $rango = new Rango();

            $item = array('longitud' => $longitud,'latitud' => $latitud);
            $rango->Insert($item);
            $res = $rango->SelectData($longitud, $latitud);
            $row = $res->fetch();
            $id = (int)$row['id'];

            return $id;
        }

        /**
        * consulta de la clave primaria del tiempo que tarda el color verde del semaforo
        *
        * verifica que el tiempo del color verde exista para devolver su clave, en caso de que no se asi,
        * se registra el nuevo tiempo del color verde y la clave es retornada para el registro o actualizacion
        * del semaforo
        *
        * @access public
        * @param int $tiempo tiempo del color verde del semaforo a registrar o actualizar 
        * @return $id retorna la clave del tiempo del color verde para vincularlo al semaforo
        */
        function SelTiempoVerde($tiempo){
            $tiempo_verde = new TiempoVerde();

            $res= $tiempo_verde->SelectData($tiempo);
            if($res->rowCount()){
                $row = $res->fetch();
                $id = (int)$row['id'];

                return $id;
            }else{
                $item = array('tiempo_verde' => $tiempo);
                $tiempo_verde->Insert($item);
                $res= $tiempo_verde->SelectData($tiempo);
                $row = $res->fetch();
                $id = (int)$row['id'];

                return $id;
            }
        }

        /**
        * consulta de la clave primaria del tiempo que tarda el color amarillo del semaforo
        *
        * verifica que el tiempo del color amarillo exista para devolver su clave, en caso de que no se asi,
        * se registra el nuevo tiempo del color amarillo y la clave es retornada para el registro o actualizacion
        * del semaforo
        *
        * @access public
        * @param int $tiempo tiempo del color amarillo del semaforo a registrar o actualizar 
        * @return $id retorna la clave del tiempo del color amarillo para vincularlo al semaforo
        */
        function SelTiempoAmarillo($tiempo){
            $tiempo_amarillo = new TiempoAmarillo();

            $res= $tiempo_amarillo->SelectData($tiempo);
            if($res->rowCount()){
                $row = $res->fetch();
                $id = (int)$row['id'];

                return $id;
            }else{
                $item = array('tiempo_amarillo' => $tiempo);
                $tiempo_amarillo->Insert($item);
                $res= $tiempo_amarillo->SelectData($tiempo);
                $row = $res->fetch();
                $id = (int)$row['id'];

                return $id;
            }
        }

        /**
        * consulta de la clave primaria del tiempo que tarda el color rojo del semaforo
        *
        * verifica que el tiempo del color rojo exista para devolver su clave, en caso de que no se asi,
        * se registra el nuevo tiempo del color rojo y la clave es retornada para el registro o actualizacion
        * del semaforo
        *
        * @access public
        * @param int $tiempo tiempo del color rojo del semaforo a registrar o actualizar 
        * @return $id retorna la clave del tiempo del color rojo para vincularlo al semaforo
        */
        function SelTiempoRojo($tiempo){
            $tiempo_rojo = new TiempoRojo();

            $res= $tiempo_rojo->SelectData($tiempo);
            if($res->rowCount()){
                $row = $res->fetch();
                $id = (int)$row['id'];

                return $id;
            }else{
                $item = array('tiempo_rojo' => $tiempo);
                $tiempo_rojo->Insert($item);
                $res= $tiempo_rojo->SelectData($tiempo);
                $row = $res->fetch();
                $id = (int)$row['id'];

                return $id;
            }
        }
    }
?>