<?php

namespace MyApp;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use Ratchet\TinyRedisClient;



class Chat implements MessageComponentInterface {

    private $client,$redis;

    public function __construnct() {
       
    }

    public function onOpen(ConnectionInterface $conn) 
    {
        $this->client = $conn;
        $this->redis= new TinyRedisClient("localhost:9851");   
        $this->redis->__call("output", ["json"]);

        echo "\nConectado";
    }

    public function onMessage(ConnectionInterface $from, $msg) 
    { 
        
        echo "\n".$msg;
       


        $data=json_decode($this->redis->__call("intersects", ["fleet", "object" ,'{"type":"Point","coordinates":'.$msg.'}']));
        
        if($data->{'count'}>0){
            $this->client->send("true");
            echo "\ntrue";

        }else{
            $this->client->send("false");
            echo "\nfalse";
        }

    }

    public function onClose(ConnectionInterface $conn) {

        echo "\nDesconectado";

    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo $e->getMessage();
    }
}



?>