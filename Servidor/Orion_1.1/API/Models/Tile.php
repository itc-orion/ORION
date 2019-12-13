<?php
include_once 'Config/ConexionTile.php';

    class Tile extends TileBD{

        /**
        * consulta de la geo-malla relacionada a un semaforo espesifico
        *
        * realiza la consulta y convierte el resultado que se encuentra en formato json
        * a un array para su posterior manipulacion
        *
        * @access public
        * @param int $id clave del rango por el cual esta vinculado al semaforo
        * @return $query envia el resultado de la consulta
        */
        function Sel($id){
            $json = $this->Select($id);
            $item = json_decode($json, true);
            return $item;
        }

        /**
        * registro de la geo-malla del semaforo
        *
        * @access public
        * @param int,json $id clave del rango por el cual esta vinculado al semaforo $item geo-malla del semaforo que sera registrada
        * @return $query retorna el resultado de la sentencia
        */
        function Ins($id,$item){
            $res = $this->Insert($id,$item);
            return $res;
        }

        /**
        * actualizacion de la geo-malla del semaforo
        *
        * @access public
        * @param int,json $id clave de la geo-malla $item geo-malla del semaforo que sera actualizada
        * @return $query retorna el resultado de la sentencia
        */
        function Up($id,$item){
            $res = $this->Update($id,$item);
            return $res;
        }

        /**
        * eliminacion de la geo-malla del semaforo
        *
        * @access public
        * @param int $id clave de la geo-malla
        * @return $query retorna el resultado de la sentencia
        */
        function Del($id){
            $res = $this->Delete($id);
            return $res;
        }
    }
?>