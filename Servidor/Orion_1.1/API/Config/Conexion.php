<?php
    class DB{
       
        private $host;
        private $port;
        private $db;
        private $user;
        private $pas;
        private $charset;

        /**
        *  contiene los datos para la conexion a la base de datos
        *
        * @access public
        * @return void
        */
        public function __construct(){
            $this->host = 'localhost';
            $this->port = '5432';
            $this->db = 'orion';
            $this->user = 'postgres';
            $this->pass = 'Duelista1';
            $this->charset = 'utf8';
        }

        /**
        * Realiza la conexion a la base de datos
        *
        * @access public
        * @return $pdo variable para la conexion de la base de datos
        */
        function connect(){
            try{
                $connection = "pgsql:host=". $this->host. ";port=". $this->port. ";dbname=". $this->db;

                $pdo = new PDO($connection, $this->user, $this->pass);

                return $pdo;
            }catch(PDOException $e){
                header('Content-Type: application/json');
                echo json_encode(array('Mensaje' => "Error connection" . $e->getMessage()));
                http_response_code(405);
            }
        }
    }
?>