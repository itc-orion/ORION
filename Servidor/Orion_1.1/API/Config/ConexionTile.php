<?php
include_once 'Config/TinyRedisClient.php';

    class TileBD{
        private $tile;

        public function __construct(){
            $this->tile = new TinyRedisClient("localhost:9851");
            $this->tile->__call("output", ["json"]);
        }

        function Show(){
            return $this->tile->__call("scan", ["fleet"]);
        }

        function Select($id){
            return $this->tile->__call("get", ["fleet", $id]);
        }

        function Insert($id,$item){
            return $this->tile->__call("set", ["fleet", $id , "object",$item]);
        }

        function Update($id,$item){
            return $this->tile->__call("set", ["fleet", $id , "object",$item]);
        }

        function Delete($id){
            return $this->tile->__call("del", ["fleet", $id]);
        }
    }
?>