<?php
include_once 'Config/Conexion.php';

    class Usuario extends DB{

        /**
        * consulta de la existencia del usuario
        *
        * realiza una consulta sobre la existencia del usuario
        *
        * @access public
        * @param int $item arreglo que contiene el correo y contraseña del usuario
        * @return $query envia el resultado de la consulta espesifica
        */
        function Select($item){
            $query = $this->connect()->prepare('SELECT * FROM usuarios WHERE correo= :correo AND contrasena= :contrasena');
            $query->execute(['correo' => $item['correo'], 'contrasena' => $item['contraseña']]);
            return $query;
        }
    }
?>