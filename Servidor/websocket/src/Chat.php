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

            $semaforo = array(
                'id' =>  ,
                'nombre' =>  ,
                'status' =>  ,
                'longitud' => ,
                'latitud' =>  ,
                'tiempo_inicio' => ,
                'inicio_suspencion' => ,
                'fin_suspencion' => ,
                'tiempo_verde' => ],
                'tiempo_amarillo' => ,
                'tiempo_rojo' => ,
                
            );

            $from->send(json_encode($semaforo));

           
            

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