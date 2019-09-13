<?php

include_once 'Config/ConexionTile.php';

    class Tile extends TileBD{

        function All(){
            $json = $this->Show();
            $item = json_decode($json, true);
            return $item;
        }

        function Sel($id){
            $json = $this->Select($id);
            $item = json_decode($json, true);
            return $item;
        }

        function Ins($id,$item){
            $res = $this->Insert($id,$item);
            return $res;
        }

        function Up($id,$item){
            $res = $this->Update($id,$item);
            return $res;
        }

        function Del($id){
            $res = $this->Delete($id);
            return $res;
        }
    }

?>