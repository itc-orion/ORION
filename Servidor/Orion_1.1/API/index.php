<?php
include_once 'Controllers/AllController.php';
include_once 'Controllers/SemaforoController.php';
include_once 'Controllers/HorarioController.php';
include_once 'Controllers/RangoController.php';
include_once 'Controllers/TiempoVerdeController.php';
include_once 'Controllers/TiempoAmarilloController.php';
include_once 'Controllers/TiempoRojoController.php';
include_once 'Controllers/ErrorController.php';
include_once 'Controllers/TileController.php';

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

$api_all = new AllController();
$api_semaforo = new SemaforoController();
$api_horario = new HorarioController();
$api_rango = new RangoController();
$api_tiempo_verde = new TiempoVerdeController();
$api_tiempo_amarillo = new TiempoAmarilloController();
$api_tiempo_rojo = new TiempoRojoController();
$tile = new TileController();
$error = new ErrorController();

if(isset($_GET['url'])){
    $item = $_GET['url'];
    $numero = intval(preg_replace('/[^0-9]+/','',$item),10);
    if($_SERVER['REQUEST_METHOD']=='GET'){
        switch($item){
            case "Tile/Show";
                $tile->All();
            break;
            case "Tile/$numero";
                $tile->Sel($numero);
            break;
            case "All/Show";
                $api_all->All();
            break; 
            case "All/$numero";
                $api_all->Sel($numero);
            break;
            case "Horario/Show";
                $api_horario->All();
            break;
            case "Horario/$numero";
                $api_horario->Sel($numero);
            break;
            case "Rango/Show";
                $api_rango->All();
            break;
            case "Rango/$numero";
                $api_rango->Sel($numero);
            break;
            case "TiempoVerde/Show";
                $api_tiempo_verde->All();
            break;
            case "TiempoVerde/$numero";
                $api_tiempo_verde->Sel($numero);
            break;
            case "TiempoAmarillo/Show";
                $api_tiempo_amarillo->All();
            break;
            case "TiempoAmarillo/$numero";
                $api_tiempo_amarillo->Sel($numero);
            break;
            case "TiempoRojo/Show";
                $api_tiempo_rojo->All();
            break;
            case "TiempoRojo/$numero";
                $api_tiempo_rojo->Sel($numero);
            break;
            case "Semaforo/Show";
                $api_semaforo->All();
            break; 
            case "Semaforo/$numero";
                $api_semaforo->Sel($numero);
            break;
            default;
                $error->Mensaje('La direcion URL no existe');
            break;
        }

    }else if($_SERVER['REQUEST_METHOD']=='POST'){
        $body = file_get_contents("php://input");
        
        if(json_last_error()==0){
            switch($item){
                case "Tile/Create/$numero";
                    $tile->Ins($numero,$body);
                break;
                case "All/Create";
                    $api_all->Ins($body);
                break;
                case "Horario/Create";
                    $api_horario->Ins($body);
                break;
                case "Rango/Create";
                    $api_rango->Ins($body);
                break;
                case "TiempoVerde/Create";
                    $api_tiempo_verde->Ins($body);
                break;
                case "TiempoAmarillo/Create";
                    $api_tiempo_amarillo->Ins($body);
                break;
                case "TiempoRojo/Create";
                    $api_tiempo_rojo->Ins($body);
                break;
                case "Semaforo/Create";
                    $api_semaforo->Ins($body);
                break;
                default;
                    $error->Mensaje("La direcion URL no existe");
                break;
            }
        }else{
            $error->Mensaje("Solo acepta archivos .json o la estructura del archivo tiene un error");
        }

    }else if($_SERVER['REQUEST_METHOD']=='PUT'){
        $body = file_get_contents("php://input");
        
        if(json_last_error()==0){
            switch($item){
                case "Tile/$numero";
                    $tile->Up($body,$numero);
                break;
                case "All/$numero";
                    $api_all->Up($body,$numero);
                break;
                case "Horario/$numero";
                    $api_horario->Up($body,$numero);
                break;
                case "Rango/$numero";
                    $api_rango->Up($body,$numero);
                break;
                case "TiempoVerde/$numero";
                    $api_tiempo_verde->Up($body,$numero);
                break;
                case "TiempoAmarillo/$numero";
                    $api_tiempo_amarillo->Up($body,$numero);
                break;
                case "TiempoRojo/$numero";
                    $api_tiempo_rojo->Up($body,$numero);
                break;
                case "Semaforo/$numero";
                    $api_semaforo->Up($body,$numero);
                break;
                default;
                    $error->Mensaje("La direcion URL no existe");
                break;
            }
        }else{
            $error->Mensaje("Solo acepta archivos .json o la estructura del archivo tiene un error");
        }

    }else if($_SERVER['REQUEST_METHOD']=='DELETE'){
        switch($item){
            case "Tile/$numero";
                $tile->Del($numero);
            break;
            case "All/$numero";
                $api_all->Del($numero);
            break;
            case "Horario/$numero";
                $api_horario->Del($numero);
            break;
            case "Rango/$numero";
                $api_rango->Del($numero);
            break;
            case "TiempoVerde/$numero";
                $api_tiempo_verde->Del($numero);
            break;
            case "TiempoAmarillo/$numero";
                $api_tiempo_amarillo->Del($numero);
            break;
            case "TiempoRojo/$numero";
                $api_tiempo_rojo->Del($numero);
            break;
            case "Semaforo/$numero";
                $api_semaforo->Del($numero);
            break;
            default;
                $error->Mensaje("La direcion URL no existe");
            break;
        }

    }else{
        $error->Mensaje("El tipo de Operacion que eligio no existe");
    }
}
?>