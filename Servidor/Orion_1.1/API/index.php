<?php

include_once 'Controllers/AllController.php';
include_once 'Controllers/SemaforoController.php';
include_once 'Controllers/HorarioController.php';
include_once 'Controllers/RangoController.php';
include_once 'Controllers/TiempoVerdeController.php';
include_once 'Controllers/TiempoAmarilloController.php';
include_once 'Controllers/TiempoRojoController.php';
include_once 'Controllers/ErrorController.php';

$api_all = new AllController();
$api_semaforo = new SemaforoController();
$api_horario = new HorarioController();
$api_rango = new RangoController();
$api_tiempo_verde = new TiempoVerdeController();
$api_tiempo_amarillo = new TiempoAmarilloController();
$api_tiempo_rojo = new TiempoRojoController();
$error = new ErrorController();

if(isset($_GET['url'])){
    $item = $_GET['url'];
    $numero = intval(preg_replace('/[^0-9]+/','',$item),10);
    if($_SERVER['REQUEST_METHOD']=='GET'){
        switch($item){
            case "All/Show";
                $api_all->All();
                http_response_code(200);
            break; 
            case "All/$numero";
                $api_all->Sel($numero);
                http_response_code(200);
            break;
            case "Horario/Show";
                $api_horario->All();
                http_response_code(200);
            break;
            case "Horario/$numero";
                $api_horario->Sel($numero);
                http_response_code(200);
            break;
            case "Rango/Show";
                $api_rango->All();
                http_response_code(200);
            break;
            case "Rango/$numero";
                $api_rango->Sel($numero);
                http_response_code(200);
            break;
            case "TiempoVerde/Show";
                $api_tiempo_verde->All();
                http_response_code(200);
            break;
            case "TiempoVerde/$numero";
                $api_tiempo_verde->Sel($numero);
                http_response_code(200);
            break;
            case "TiempoAmarillo/Show";
                $api_tiempo_amarillo->All();
                http_response_code(200);
            break;
            case "TiempoAmarillo/$numero";
                $api_tiempo_amarillo->Sel($numero);
                http_response_code(200);
            break;
            case "TiempoRojo/Show";
                $api_tiempo_rojo->All();
                http_response_code(200);
            break;
            case "TiempoRojo/$numero";
                $api_tiempo_rojo->Sel($numero);
                http_response_code(200);
            break;
            case "Semaforo/Show";
                $api_semaforo->All();
                http_response_code(200);
            break; 
            case "Semaforo/$numero";
                $api_semaforo->Sel($numero);
                http_response_code(200);
            break;
            default;
                $error->Mensaje('La direcion URL no existe');
            break;
        }

    }else if($_SERVER['REQUEST_METHOD']=='POST'){
        $body = file_get_contents("php://input");
        
        if(json_last_error()==0){
            switch($item){
                case "Horario/Create";
                    $api_horario->Ins($body);
                    http_response_code(200);
                break;
                case "Rango/Create";
                    $api_rango->Ins($body);
                    http_response_code(200);
                break;
                case "TiempoVerde/Create";
                    $api_tiempo_verde->Ins($body);
                    http_response_code(200);
                break;
                case "TiempoAmarillo/Create";
                    $api_tiempo_amarillo->Ins($body);
                    http_response_code(200);
                break;
                case "TiempoRojo/Create";
                    $api_tiempo_rojo->Ins($body);
                    http_response_code(200);
                break;
                case "Semaforo/Create";
                    $api_semaforo->Ins($body);
                    http_response_code(200);
                break;
                default;
                    $error->Mensaje("La direcion URL no existe");
                break;
            }
        }else{
            $error->Mensaje("Solo acepta archivos .json o la estructura del archivo tiene un error");
            http_response_code(400);
        }

    }else if($_SERVER['REQUEST_METHOD']=='PUT'){
        $body = file_get_contents("php://input");
        
        if(json_last_error()==0){
            switch($item){
                case "Horario/$numero";
                    $api_horario->Up($body,$numero);
                    http_response_code(200);
                break;
                case "Rango/$numero";
                    $api_rango->Up($body,$numero);
                    http_response_code(200);
                break;
                case "TiempoVerde/$numero";
                    $api_tiempo_verde->Up($body,$numero);
                    http_response_code(200);
                break;
                case "TiempoAmarillo/$numero";
                    $api_tiempo_amarillo->Up($body,$numero);
                    http_response_code(200);
                break;
                case "TiempoRojo/$numero";
                    $api_tiempo_rojo->Up($body,$numero);
                    http_response_code(200);
                break;
                case "Semaforo/$numero";
                    $api_semaforo->Up($body,$numero);
                    http_response_code(200);
                break;
                default;
                    $error->Mensaje("La direcion URL no existe");
                break;
            }
        }else{
            $error->Mensaje("Solo acepta archivos .json o la estructura del archivo tiene un error");
            http_response_code(400);
        }

    }else if($_SERVER['REQUEST_METHOD']=='DELETE'){
        switch($item){
            case "Horario/$numero";
                $api_horario->Del($numero);
                http_response_code(200);
            break;
            case "Rango/$numero";
                $api_rango->Del($numero);
                http_response_code(200);
            break;
            case "TiempoVerde/$numero";
                $api_tiempo_verde->Del($numero);
                http_response_code(200);
            break;
            case "TiempoAmarillo/$numero";
                $api_tiempo_amarillo->Del($numero);
                http_response_code(200);
            break;
            case "TiempoRojo/$numero";
                $api_tiempo_rojo->Del($numero);
                http_response_code(200);
            break;
            case "Semaforo/$numero";
                $api_semaforo->Del($numero);
                http_response_code(200);
            break;
            default;
                $error->Mensaje("La direcion URL no existe");
            break;
        }

    }else{
        $error->Mensaje("El tipo de Operacion que eligio no existe");
        http_response_code(405);
    }
}
?>