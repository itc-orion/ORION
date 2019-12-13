<?php

class DB{

    
    private $host;
    private $port;
    private $db;
    private $user;
    private $pas;
    private $charset;

    public function __construct(){
        $this->host = 'localhost';
        $this->port = '5432';
        $this->db = 'orion';
        $this->user = 'postgres';
        $this->pass = 'Duelista1';
        $this->charset = 'utf8';
    }

    function connect(){
        try{
            $connection = "pgsql:host=". $this->host. ";port=". $this->port. ";dbname=". $this->db;

            $options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_EMULATE_PREPARES => false
                    ];
            $pdo = new PDO($connection, "postgres", "Duelista1");

            return $pdo;
        }catch(PDOException $e){
            header('Content-Type: application/json');
            echo json_encode(array('Mensaje' => "Error connection" . $e->getMessage()));
            http_response_code(405);
        }
    }
}

?>