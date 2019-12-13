<?php
include_once 'Config/TinyRedisClient.php';

    class TileBD{
        private $tile;

        /**
        * Realiza la conexion a Tile38
        * declara que el formato del archivo que se registra es un json
        *
        * @access public
        * @return void
        */
        public function __construct(){
            $this->tile = new TinyRedisClient("localhost:9851");
            $this->tile->__call("output", ["json"]);
        }

        /**
        * consulta de la geo-malla de un semaforo espesifoco
        *
        * @access public
        * @param int $id clave primaria de la geo-malla
        * @return $tile retornal la geo-malla en formayo json
        */
        function Select($id){
            return $this->tile->__call("get", ["fleet", $id]);
        }

        /**
        * registro de la geo-malla del semaforo
        *
        * @access public
        * @param json $id clave primaria que se le dara ha la geo-malla $item datos de la geo-malla en formato json
        * @return $tile resultado de la sentencia en la base de datos
        */
        function Insert($id,$item){
            return $this->tile->__call("set", ["fleet", $id , "object",$item]);
        }

        /**
        * actualizacion de la geo-malla del semaforo
        *
        * @access public
        * @param int,json $id clave primaria que se le dara ha la geo-malla $item datos de la geo-malla en formato json
        * @return $tile resultado de la sentencia en la base de datos
        */
        function Update($id,$item){
            return $this->tile->__call("set", ["fleet", $id , "object",$item]);
        }

        /**
        * eliminacion de la geo-malla del semaforo
        *
        * @access public
        * @param int $id clave primaria de la geo-malla
        * @return $tile resultado de la sentencia en la base de datos
        */
        function Delete($id){
            return $this->tile->__call("del", ["fleet", $id]);
        }
    }
?>