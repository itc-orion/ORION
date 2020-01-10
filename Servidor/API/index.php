<?php


header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

include_once 'Controllers/AllController.php';
include_once 'Controllers/UsuarioController.php';
include_once 'Controllers/ErrorController.php';
include_once 'Controllers/ValidacionController.php';



/**
*Ingreso a las funciones del servidor
*
* para poser ingresar a las funciones del servidor es necesario el complemento del url,
* el tipo de metodo a realizar y dependiendo del caso a obtencion de un Json con los datos
* de un semaforo
*
* @access public
* @param  url,REQUEST_METHOD,body 
*         $item contiene elcomplemnete del url para el imgreso a la funcion del servidor
*         $_SERVER contiene el tipo de metodo que se esta pidiendo
*         $body contiene los datos del semaforo, estos dependeran de la funcion deseada
*
* @return $query retorna el resultado de la sentencia
*/
$api_all = new AllController();
$api_usuario = new UsuarioController();
$validar = new ValidacionController();
$error = new ErrorController();

if(isset($_GET['url'])){
    $item = $_GET['url'];
    if($_SERVER['REQUEST_METHOD']=='GET'){
        switch($item){
            case "All/Show";
                $api_all->All();
            break;
            default;
                $error->Mensaje('La direcion URL no existe');
            break;
        }
    }else if($_SERVER['REQUEST_METHOD']=='POST'){
        $body = file_get_contents('php://input');
        if(json_last_error()==0){
            switch($item){
                case "All/Select";
                    $api_all->Sel($body);
                break;
                case "All/Create";
                    $validar->Val($body);
                break;
                case "All/Delete";
                    $api_all->Del($body);
                break;
                case "Usuario/Validar";
                    $api_usuario->Sel($body);
                break;
                default;
                    $error->Mensaje("La direcion URL no existe");
                break;
            }
        }else{
            $error->Mensaje("Solo acepta archivos .json o la estructura del archivo tiene un error");
        }
    }else if($_SERVER['REQUEST_METHOD']=='DELETE'){
        $body = file_get_contents('php://input');
        if(json_last_error()==0){
            switch($item){
                case "All/Delete";
                    $api_all->Del($body);
                break;
                default;
                    $error->Mensaje("La direcion URL no existe");
                break;
            }
        }else{
            $error->Mensaje("Solo acepta archivos .json o la estructura del archivo tiene un error");
        }
    }else{
        $error->Mensaje("El tipo de Operacion que eligio no existe");
    }
}
?>