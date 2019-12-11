<?php

namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\TinyRedisClient;



class Chat implements MessageComponentInterface {

    private $redis;

    public function __construnct() {
       
    }

    public function onOpen(ConnectionInterface $conn) 
    {
        
        $this->redis= new TinyRedisClient("localhost:9851");   
        $this->redis->__call("output", ["json"]);

        echo "\nNuevo Usuario";
    }

    public function onMessage(ConnectionInterface $from, $coordinates) 
    { 
        
        $data=json_decode($this->redis->__call("intersects", ["fleet", "object" ,'{"type":"Point","coordinates":['.$coordinates.']}']));
        
        if($data->{'count'}>0){
            
            // Id del area al que entro
            $id = $data->{'objects'}[0]->{'id'};
            //Realizar consulta con id para obtener datos del semaforo y llenar array de semaforo
			
			include_once '../../Orion_1.1/API/Models/All.php';
			include_once '../../Orion_1.1/API/Models/Semaforo.php';
			
			$consulta_semaforo = new Semaforo();
			$all = new All();
			
			$res = $consulta_semaforo->selectData($id);
            $row = $res->fetch();
            $id_sem = (int)$row['id'];
            $res= $all->Select($id_sem);

            if($res->rowCount() == 1){
                $row = $res->fetch();

				$semaforo = array(
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
                    'tiempo_rojo' => (int)$row['tiempo_rojo']
					
				);

				$from->send(json_encode($semaforo));
			}else{

            $from->send("false");
            
			}
        }else{

            $from->send("false");
            
        }


    }

    public function onClose(ConnectionInterface $conn) {

        echo "\nUsuario desconectado";

    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo $e->getMessage();
    }
}