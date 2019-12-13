<?php

namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\TinyRedisClient;





class Chat implements MessageComponentInterface {

    private $redis,$connection,$dbconn;



    public function __construnct() {


       
    }

    public function onOpen(ConnectionInterface $conn) 
    {
        
        $this->redis= new TinyRedisClient("localhost:9851");   
        $this->redis->__call("output", ["json"]);

        $this->dbconn = pg_connect("host=localhost dbname=orion user=postgres password=qwerty9898") or die('Could not connect: ' . pg_last_error());



        echo "\nNuevo Usuario\n";
    }

    public function onMessage(ConnectionInterface $from, $coordinates) 
    { 
        
        $data=json_decode($this->redis->__call("intersects", ["fleet", "object" ,'{"type":"Point","coordinates":['.$coordinates.']}']));
   
        if($data->{'count'}>0){
            
            // Id del area al que entro
            $id = $data->{'objects'}[0]->{'id'};

            //Realizar consulta con id para obtener datos del semaforo y llenar array de semaforo
            $query = "SELECT id FROM semaforos WHERE id_rango=2";
            $result = pg_query($query) or die('Query failed: ' . pg_last_error());
            $line = pg_fetch_array($result, null, PGSQL_ASSOC);
            
            $query = "SELECT * FROM semaforos_all WHERE id=".$line['id'];
            $result = pg_query($query) or die('Query failed: ' . pg_last_error());
            $line = pg_fetch_array($result, null, PGSQL_ASSOC);

            $line['status']= ($line['status']=="t") ? "true":"false";

            $json['semaforo']=array();
            array_push($json['semaforo'],$line);


            echo json_encode($json);

            header('Content-Type: application/json');
            $from->send(json_encode($json));
           

         
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